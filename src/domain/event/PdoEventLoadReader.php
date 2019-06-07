<?php declare(strict_types=1);

namespace Eventsourcing;
class PdoEventLoadReader implements EventLogReader
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function read(SessionId $sessionId): EventLog
    {
        $eventLog = new EventLog();
        $statement = $this->pdo->prepare('
        SELECT data FROM events WHERE emitter_id = :emitterId');
        $statement->bindValue('emitterId', $sessionId->asString());
        $statement->execute();
        while($eventData = $statement->fetchColumn(0)) {
            $eventLog->add(unserialize($eventData));
        }

        return $eventLog;
    }

}
