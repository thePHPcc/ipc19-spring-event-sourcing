<?php declare(strict_types=1);

namespace Eventsourcing\Checkout;

use DateTimeImmutable;
use Eventsourcing\BillingAddressEnteredEvent;
use Eventsourcing\BillingAddressEnteredTopic;
use Eventsourcing\CheckoutStartedEvent;
use Eventsourcing\CheckoutStartedTopic;
use Eventsourcing\Event;
use Eventsourcing\EventLog;
use Eventsourcing\CheckoutCompletedEvent;
use Eventsourcing\CheckoutCompletedTopic;
use Eventsourcing\SessionId;

class Checkout
{
    /**
     * @var EventLog
     */
    private $eventLog;

    /**
     * @var DateTimeImmutable
     */
    private $currentDateTime;
    /**
     * @var bool
     */
    private $checkoutCompleted = false;

    /**
     * @var CartItemCollection
     */
    private $cartItems;

    /**
     * @var BillingAddress
     */
    private $billingAddress;

    public function __construct(EventLog $history, DateTimeImmutable $currentDateTime)
    {
        $this->currentDateTime = $currentDateTime;
        $this->eventLog = new EventLog();
        $this->replay($history);
    }

    public function getRecordedEvents(): EventLog
    {
        return $this->eventLog;
    }

    public function startCheckout(CartItemCollection $cartItems): void
    {
        $this->ensureCheckoutHasNotBeenStarted();

        $this->recordEvent(new CheckoutStartedEvent($cartItems, $this->currentDateTime));
    }

    public function setBillingAddress(BillingAddress $billingAddress): void
    {
        $this->ensureCheckoutHasBeenStarted();
        $this->ensureCheckoutHasNotBeenCompleted();

        $this->recordEvent(new BillingAddressEnteredEvent($billingAddress, $this->currentDateTime));
    }

    public function completeCheckout(): void
    {
        $this->ensureCheckoutHasBeenStarted();
        $this->ensureBillingAddressHasBeenEntered();
        $this->ensureCheckoutHasNotBeenCompleted();

        $this->recordEvent(
            new CheckoutCompletedEvent(
                $this->currentDateTime,
                $this->cartItems,
                $this->billingAddress
            )
        );
    }

    private function ensureCheckoutHasNotBeenCompleted(): void
    {
        if ($this->checkoutCompleted) {
            throw new CheckoutAlreadyCompletedException();
        }
    }

    private function ensureBillingAddressHasBeenEntered(): void
    {
        if ($this->billingAddress === null) {
            throw new NoBillingAddressEnteredException();
        }
    }

    private function ensureCheckoutHasBeenStarted(): void
    {
        if ($this->cartItems === null) {
            throw new CheckoutNotStartedException();
        }
    }

    private function ensureCheckoutHasNotBeenStarted(): void
    {
        if ($this->cartItems !== null) {
            throw new CheckoutAlreadyStartedException();
        }
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
        switch($event->getTopic()) {
            case new CheckoutStartedTopic():
                /** @var CheckoutStartedEvent $event*/
                $this->cartItems = $event->getCartItems();
                return;
            case new BillingAddressEnteredTopic():
                /** @var BillingAddressEnteredEvent $event*/
                $this->billingAddress = $event->getBillingAddress();
                return;
            case new CheckoutCompletedTopic():
                $this->checkoutCompleted = true;
                return;
        }
    }
}
