<?php

use Eventsourcing\Checkout\CartItem;
use Eventsourcing\Checkout\CartItemCollection;
use Eventsourcing\Factory;
use Eventsourcing\SessionId;

require __DIR__ . '/vendor/autoload.php';

$sessionId = new SessionId('foo');

$factory = new Factory($sessionId);

$cartItems = new CartItemCollection(
    [
        new CartItem(1, 'some product', 1299),
        new CartItem(2, 'some other product', 1799),
    ]
);

$checkoutService = $factory->createCheckoutService();
$checkoutService->startCheckout($cartItems);

