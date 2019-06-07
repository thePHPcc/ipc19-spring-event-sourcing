<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Cart\CartItemCollection;
use Eventsourcing\Checkout\CartItem;
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

    /**
     * @var SessionId
     */
    private $sessionId;

    public function __construct(CartService $cartService, CheckoutService $checkoutService, SessionId $sessionId)
    {
        $this->cartService = $cartService;
        $this->checkoutService = $checkoutService;
        $this->sessionId = $sessionId;
    }

    public function execute(): void
    {
        $cartItems = $this->cartService->getCartItems($this->sessionId);
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
