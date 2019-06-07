<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Checkout\CheckoutService;

class CompleteCheckoutCommand
{
    /**
     * @var CheckoutService
     */
    private $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function execute(): void
    {
        $this->checkoutService->completeCheckout();
    }
}
