<?php declare(strict_types=1);

namespace Eventsourcing\Checkout;

use DateTimeImmutable;
use Eventsourcing\CheckoutStartedEvent;
use Eventsourcing\Event;
use Eventsourcing\EventLog;
use Eventsourcing\SessionId;

class Checkout
{
    /**
     * @var EventLog
     */
    private $eventLog;

    private $checkoutStarted = false;
    /**
     * @var DateTimeImmutable
     */
    private $currentDateTime;

    public function __construct(EventLog $history, DateTimeImmutable $currentDateTime)
    {
        $this->currentDateTime = $currentDateTime;
        $this->eventLog = new EventLog();
        $this->replay($history);
    }

    public function getRecordedEvent(): EventLog
    {
        return $this->eventLog;
    }

    public function startCheckout(CartItemCollection $cartItems): void
    {
        if ($this->checkoutStarted) {
            throw new CheckoutAlreadyStartedException();
        }
        $this->recordEvent(new CheckoutStartedEvent($cartItems, $this->currentDateTime));
    }

    private function recordEvent(Event $event): void
    {
        $this->applyEvent($event);
        $this->eventLog->add($event);
    }

    private function replay(EventLog $history): void
    {
        foreach ($history as $event) {
            /** @var Event $event */
            $this->applyEvent($event);
        }
    }

    private function applyEvent(Event $event): void
    {
        if ($event instanceof CheckoutStartedEvent) {
            $this->checkoutStarted = true;
        }
    }
}
