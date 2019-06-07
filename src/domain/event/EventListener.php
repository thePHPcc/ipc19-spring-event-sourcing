<?php declare(strict_types=1);

namespace Eventsourcing;
class EventListener
{
    private $eventHandlers = [];

    public function register(EventHandler $eventHandler)
    {
        foreach ($eventHandler->getSupportedEvents() as $supportedEvent) {
            if (!array_key_exists($supportedEvent, $this->eventHandlers)) {
                $this->eventHandlers[$supportedEvent] = [];
            }
            $this->eventHandlers[$supportedEvent][] = $eventHandler;
        }
    }

    public function handle(EventLog $eventLog): void
    {
        foreach ($eventLog as $event) {
            $eventClass = get_class($event);
            if (!array_key_exists($eventClass, $this->eventHandlers)) {
                continue;
            }

            foreach ($this->eventHandlers[$eventClass] as $eventHandler) {
                /** @var EventHandler $eventHandler */
                $eventHandler->handle($event);
            }
        }
    }
}
