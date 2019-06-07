<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Checkout\CheckoutId;

class PdoEventLoadReader implements EventLogReader
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

    public function read(): EventLog
    {
        $eventLog = new EventLog();
        $statement = $this->pdo->prepare('
        SELECT data FROM events WHERE emitter_id = :emitterId');
        $statement->bindValue('emitterId', $this->checkoutId->asString());
        $statement->execute();
        while($eventData = $statement->fetchColumn(0)) {
            $eventLog->add(unserialize($eventData));
        }

        return $eventLog;
    }

}
