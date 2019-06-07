<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Checkout\BillingAddress;

class BillingAddressEnteredEvent implements Event
{
    /**
     * @var \DateTimeImmutable
     */
    private $occuredAt;

    /**
     * @var BillingAddress
     */
    private $billingAddress;

    public function __construct(
        BillingAddress $billingAddress, \DateTimeImmutable $occuredAt
    )
    {
        $this->billingAddress = $billingAddress;
        $this->occuredAt = $occuredAt;
    }

    public function getBillingAddress(): BillingAddress
    {
        return $this->billingAddress;
    }

    public function getOccuredAt(): \DateTimeImmutable
    {
        return $this->occuredAt;
    }

    public function getTopic(): Topic
    {
        return new BillingAddressEnteredTopic();
    }

}
