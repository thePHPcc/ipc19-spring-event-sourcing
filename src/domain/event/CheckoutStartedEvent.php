<?php declare(strict_types=1);

namespace Eventsourcing;
use DateTimeImmutable;
use Eventsourcing\SessionId;
use Eventsourcing\Checkout\CartItemCollection;

class CheckoutStartedEvent implements Event
{
    /**
     * @var CartItemCollection
     */
    private $cartItems;

    /**
     * @var SessionId
     */
    private $sessionId;

    /**
     * @var DateTimeImmutable
     */
    private $occuredAt;

    public function __construct(
        CartItemCollection $cartItems,
        SessionId $sessionId,
        DateTimeImmutable $occuredAt
    )
    {
        $this->cartItems = $cartItems;
        $this->sessionId = $sessionId;
        $this->occuredAt = $occuredAt;
    }
}
