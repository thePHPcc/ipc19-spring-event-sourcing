<?php declare(strict_types=1);

namespace Eventsourcing\Checkout;
use Eventsourcing\EventLogReader;
use Eventsourcing\EventLogWriter;
use Eventsourcing\SessionId;

class CheckoutService
{
    /**
     * @var EventLogReader
     */
    private $eventLogReader;
    /**
     * @var EventLogWriter
     */
    private $eventLogWriter;

    public function __construct(EventLogReader $eventLogReader, EventLogWriter $eventLogWriter)
    {
        $this->eventLogReader = $eventLogReader;
        $this->eventLogWriter = $eventLogWriter;
    }

    public function startCheckout(
        CartItemCollection $cartItems,
        SessionId $sessionId
    ): void
    {
        $eventLog = $this->eventLogReader->read($sessionId);
        $checkout = new Checkout($eventLog, new \DateTimeImmutable());
        $checkout->startCheckout($cartItems);
        $this->eventLogWriter->write($checkout->getEvents(), $sessionId);
    }


}
