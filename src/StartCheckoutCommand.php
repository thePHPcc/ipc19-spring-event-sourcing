<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Cart\CartItemCollection;
use Eventsourcing\Checkout\CartItem;
use Eventsourcing\Checkout\CheckoutId;
use Eventsourcing\Checkout\CheckoutService;

class StartCheckoutCommand
{
    /**
     * @var CartService
     */
    private $cartService;

    /**
     * @var CheckoutService
     */
    private $checkoutService;

    public function __construct(CartService $cartService, CheckoutService $checkoutService)
    {
        $this->cartService = $cartService;
        $this->checkoutService = $checkoutService;
    }

    public function execute(): void
    {
        $cartItems = $this->cartService->getCartItems();
        $this->checkoutService->startCheckout($this->mapCartItems($cartItems));
    }

    private function mapCartItems(CartItemCollection $cartItems): Checkout\CartItemCollection
    {
        $checkoutCartItems = [];
        foreach ($cartItems as $cartItem) {
            /** @var CartItem $cartItem */
            $checkoutCartItems[] = new CartItem(
                $cartItem->getId(),
                $cartItem->getDescription(),
                $cartItem->getPrice()
            );
        }

        return new Checkout\CartItemCollection($checkoutCartItems);
    }

}
