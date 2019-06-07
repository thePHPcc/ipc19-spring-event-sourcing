<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Checkout\CheckoutId;

class PdoEventLogWriter implements EventLogWriter
{
    /**
     * @var \PDO
     */
    private $pdo;
    /**
     * @var CheckoutId
     */
    private $checkoutId;

    public function __construct(\PDO $pdo, CheckoutId $checkoutId)
    {
        $this->pdo = $pdo;
        $this->checkoutId = $checkoutId;
    }

    public function write(EventLog $eventLog): void
    {
        $statement = $this->pdo->prepare('
            INSERT INTO events (`emitter_id`, `topic`, `occured_at`, `data`)
            VALUES (:emitterId, :topic, :occuredAt, :data)');

        foreach ($eventLog as $event) {
            /** @var Event $event */
            $statement->bindValue('emitterId', $this->checkoutId->asString());
            $statement->bindValue('topic', $event->getTopic()->asString());
            $statement->bindValue('occuredAt', $event->getOccuredAt()->format(DATE_ATOM));
            $statement->bindValue('data', serialize($event));
            $statement->execute();
        }
    }
}
