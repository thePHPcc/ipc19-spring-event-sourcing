<?php declare(strict_types=1);

namespace Eventsourcing\Checkout;
use Eventsourcing\EventListener;
use Eventsourcing\EventLogReader;
use Eventsourcing\EventLogWriter;

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

    public function startCheckout(CartItemCollection $cartItems): void
    {
        $eventLog = $this->eventLogReader->read();
        $checkout = new Checkout($eventLog, new \DateTimeImmutable());
        $checkout->startCheckout($cartItems);

        $recordedEvents = $checkout->getRecordedEvents();
        $this->eventLogWriter->write($recordedEvents);
        $this->eventListener->handle($recordedEvents);
    }


}
