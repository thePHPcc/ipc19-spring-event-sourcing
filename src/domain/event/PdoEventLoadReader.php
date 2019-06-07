<?php declare(strict_types=1);

namespace Eventsourcing;
class PdoEventLoadReader implements EventLogReader
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

    public function read(): EventLog
    {
        $eventLog = new EventLog();
        $statement = $this->pdo->prepare('
        SELECT data FROM events WHERE emitter_id = :emitterId');
        $statement->bindValue('emitterId', $this->sessionId->asString());
        $statement->execute();
        while($eventData = $statement->fetchColumn(0)) {
            $eventLog->add(unserialize($eventData));
        }

        return $eventLog;
    }

}
