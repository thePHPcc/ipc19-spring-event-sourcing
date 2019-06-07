<?php declare(strict_types=1);

namespace Eventsourcing;
class EventLogReader
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function read(SessionId $sessionId): EventLog
    {
        $filename = $this->path . '/' . $sessionId->asString();
        if (!file_exists($filename)) {
            return new EventLog();
        }
        return unserialize(file_get_contents($filename));
    }
}
