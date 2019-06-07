<?php declare(strict_types=1);

namespace Eventsourcing;
class EventLogWriter
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function write(EventLog $eventLog, SessionId $sessionId): void
    {
        $filename = $this->path . '/' . $sessionId->asString();
        file_put_contents($filename, serialize($eventLog));
    }
}
