<?php declare(strict_types=1);

namespace Eventsourcing;
class PdoEventLogWriter implements EventLogWriter
{
    /**
     * @var \PDO
     */
    private $pdo;
    /**
     * @var SessionId
     */
    private $sessionId;

    public function __construct(\PDO $pdo, SessionId $sessionId)
    {
        $this->pdo = $pdo;
        $this->sessionId = $sessionId;
    }

    public function write(EventLog $eventLog): void
    {
        $statement = $this->pdo->prepare('
            INSERT INTO events (`emitter_id`, `topic`, `occured_at`, `data`)
            VALUES (:emitterId, :topic, :occuredAt, :data)');

        foreach ($eventLog as $event) {
            /** @var Event $event */
            $statement->bindValue('emitterId', $this->sessionId->asString());
            $statement->bindValue('topic', get_class($event));
            $statement->bindValue('occuredAt', $event->getOccuredAt()->format(DATE_ATOM));
            $statement->bindValue('data', serialize($event));
            $statement->execute();
        }
    }
}
