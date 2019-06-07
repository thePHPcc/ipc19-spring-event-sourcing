<?php declare(strict_types=1);

namespace Eventsourcing;
class EventListener
{
    private $eventHandlers = [];

    public function register(EventHandler $eventHandler)
    {
        foreach ($eventHandler->getSupportedTopics() as $supportedTopic) {
            /** @var Topic $supportedTopic */
            if (!array_key_exists($supportedTopic->asString(), $this->eventHandlers)) {
                $this->eventHandlers[$supportedTopic->asString()] = [];
            }
            $this->eventHandlers[$supportedTopic->asString()][] = $eventHandler;
        }
    }

    public function handle(EventLog $eventLog): void
    {
        foreach ($eventLog as $event) {
            /** @var Event $event */
            if (!array_key_exists($event->getTopic()->asString(), $this->eventHandlers)) {
                continue;
            }

            foreach ($this->eventHandlers[$event->getTopic()->asString()] as $eventHandler) {
                /** @var EventHandler $eventHandler */
                $eventHandler->handle($event);
            }
        }
    }
}
