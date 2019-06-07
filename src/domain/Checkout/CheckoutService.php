<?php declare(strict_types=1);

namespace Eventsourcing\Checkout;
use Eventsourcing\EventListener;
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
    /**
     * @var EventListener
     */
    private $eventListener;

    public function __construct(
        EventLogReader $eventLogReader,
        EventLogWriter $eventLogWriter,
        EventListener $eventListener
    )
    {
        $this->eventLogReader = $eventLogReader;
        $this->eventLogWriter = $eventLogWriter;
        $this->eventListener = $eventListener;
    }

    public function startCheckout(
        CartItemCollection $cartItems,
        SessionId $sessionId
    ): void
    {
        $eventLog = $this->eventLogReader->read($sessionId);
        $checkout = new Checkout($eventLog, new \DateTimeImmutable());
        $checkout->startCheckout($cartItems);
        $this->eventLogWriter->write($checkout->getRecordedEvent(), $sessionId);
        $this->eventListener->handle($eventLog);
    }


}
