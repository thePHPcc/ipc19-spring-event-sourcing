<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Checkout\BillingAddress;
use Eventsourcing\Checkout\CheckoutService;

class SetBillingAddressCommand
{
    /**
     * @var CheckoutService
     */
    private $checkoutService;
    /**
     * @var BillingAddress
     */
    private $billingAddress;

    public function __construct(
        CheckoutService $checkoutService, BillingAddress $billingAddress
    )
    {
        $this->checkoutService = $checkoutService;
        $this->billingAddress = $billingAddress;
    }

    public function execute(): void
    {
        $this->checkoutService->setBillingAddress($this->billingAddress);
    }
}
