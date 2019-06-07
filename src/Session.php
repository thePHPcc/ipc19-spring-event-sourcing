<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Checkout\CheckoutId;

class Session
{
    /**
     * @var CheckoutId
     */
    private $checkoutId;

    /**
     * @var SessionId
     */
    private $id;

    public function __construct(SessionId $id)
    {
        $this->id = $id;
    }

    public function getCheckoutId(): CheckoutId
    {
        if ($this->checkoutId === null) {
            $this->checkoutId = new CheckoutId();
        }

        return $this->checkoutId;
    }

    public function getId(): SessionId
    {
        return $this->id;
    }
}
