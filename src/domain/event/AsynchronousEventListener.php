<?php declare(strict_types=1);

namespace Eventsourcing;
class AsynchronousEventListener
{
    private $eventHandlers = [];

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var int
     */
    private $currentId;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

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

    public function listen()
    {
        while(true) {
            if (!$event = $this->getNextEvent()) {
                usleep(15000);
                continue;
            }

            $this->handle($event);
            $this->acknowledgeCurrentEvent();
        }
    }

    private function getNextEvent(): ?Event
    {
        $statement = $this->pdo->prepare(
            'SELECT id, data FROM events WHERE id > IFNULL(
              (SELECT last_id FROM event_streams WHERE identifier = :identifier), 0) 
              AND topic = :topic LIMIT 1'
        );
        $statement->bindValue('identifier', 'mail-notifier');
        $statement->bindValue('topic', (new CheckoutCompletedTopic())->asString());
        $statement->execute();

        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }
        $event = unserialize($row['data']);
        $this->currentId = $row['id'];

        return $event;
    }

    private function handle(Event $event): void
    {
        /** @var Event $event */
        if (!array_key_exists($event->getTopic()->asString(), $this->eventHandlers)) {
            return;
        }

        foreach ($this->eventHandlers[$event->getTopic()->asString()] as $eventHandler) {
            /** @var EventHandler $eventHandler */
            $eventHandler->handle($event);
        }
    }

    private function acknowledgeCurrentEvent(): void
    {
        $statement = $this->pdo->prepare('REPLACE INTO event_streams (identifier, last_id) VALUES (:identifier, :lastId)');
        $statement->bindValue('identifier', 'mail-notifier');
        $statement->bindValue('lastId', $this->currentId);
        $statement->execute();

        $this->currentId = null;
    }
}
