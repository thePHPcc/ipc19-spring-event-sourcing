<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Checkout\BillingAddress;
use Eventsourcing\Checkout\CartItemCollection;

class CheckoutCompletedEvent implements Event
{
    /**
     * @var \DateTimeImmutable
     */
    private $occuredAt;

    /**
     * @var CartItemCollection
     */
    private $cartItems;

    /**
     * @var BillingAddress
     */
    private $billingAddress;

    public function __construct(\DateTimeImmutable $occuredAt, CartItemCollection $cartItems, BillingAddress $billingAddress)
    {
        $this->occuredAt = $occuredAt;
        $this->cartItems = $cartItems;
        $this->billingAddress = $billingAddress;
    }

    public function getOccuredAt(): \DateTimeImmutable
    {
        return $this->occuredAt;
    }

    public function getTopic(): Topic
    {
        return new CheckoutCompletedTopic();
    }

    public function getCartItems(): CartItemCollection
    {
        return $this->cartItems;
    }

    public function getBillingAddress(): BillingAddress
    {
        return $this->billingAddress;
    }
}
