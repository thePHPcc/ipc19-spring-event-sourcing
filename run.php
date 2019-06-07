<?php

require __DIR__ . '/vendor/autoload.php';

$factory = new \Eventsourcing\Factory();

$cartItems = new \Eventsourcing\Checkout\CartItemCollection([]);
$sessionId = new \Eventsourcing\SessionId('bar');

$checkoutService = $factory->createCheckoutService();
$checkoutService->startCheckout($cartItems, $sessionId);

