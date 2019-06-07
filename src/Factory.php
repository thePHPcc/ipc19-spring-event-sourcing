<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Checkout\CheckoutService;

class Factory
{
    public function createCheckoutService(): CheckoutService
    {
        return new CheckoutService(
            $this->createEventLogReader(), $this->createEventLogWriter()
        );
    }

    private function createEventLogReader(): EventLogReader
    {
        return new EventLogReader(__DIR__ . '/../var/events');
    }

    private function createEventLogWriter(): EventLogWriter
    {
        return new EventLogWriter(__DIR__ . '/../var/events');
    }
}
