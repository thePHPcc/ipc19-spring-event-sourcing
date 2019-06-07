<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Checkout\CheckoutService;

class Factory
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function createCheckoutService(): CheckoutService
    {
        return new CheckoutService(
            $this->createEventLogReader(),
            $this->createEventLogWriter(),
            $this->createEventListener()
        );
    }

    private function createEventListener(): EventListener
    {
        return new EventListener();
    }

    private function createEventLogReader(): EventLogReader
    {
        return new PdoEventLoadReader($this->createPdo());
    }

    private function createEventLogWriter(): EventLogWriter
    {
        return new PdoEventLogWriter($this->createPdo());
    }

    private function createPdo(): \PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new \PDO('sqlite:' . __DIR__ . '/../var/events.db');
        }

        return $this->pdo;
    }
}
