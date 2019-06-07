<?php

require __DIR__ . '/vendor/autoload.php';

$factory = new \Eventsourcing\Factory();

$cartItems = new \Eventsourcing\Checkout\CartItemCollection([]);
$sessionId = new \Eventsourcing\SessionId('foo');

$checkoutService = $factory->createCheckoutService();
$checkoutService->startCheckout($cartItems, $sessionId);

