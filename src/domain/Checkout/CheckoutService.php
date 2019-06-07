<?php declare(strict_types=1);

namespace Eventsourcing\Checkout;
use Eventsourcing\EventListener;
use Eventsourcing\EventLog;
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
        $checkout = $this->createCheckout();
        $checkout->startCheckout($cartItems);

        $this->storeAndHandleEvents($checkout->getRecordedEvents());
    }

    public function setBillingAddress(BillingAddress $billingAddress): void
    {
        $checkout = $this->createCheckout();
        $checkout->setBillingAddress($billingAddress);

        $this->storeAndHandleEvents($checkout->getRecordedEvents());
    }

    public function completeCheckout(): void
    {
        $checkout = $this->createCheckout();
        $checkout->completeCheckout();

        $this->storeAndHandleEvents($checkout->getRecordedEvents());
    }

    private function storeAndHandleEvents(EventLog $recordedEvents): void
    {
        $this->eventLogWriter->write($recordedEvents);
        $this->eventListener->handle($recordedEvents);
    }

    private function createCheckout(): Checkout
    {
        $eventLog = $this->eventLogReader->read();
        return new Checkout($eventLog, new \DateTimeImmutable());
    }

}
