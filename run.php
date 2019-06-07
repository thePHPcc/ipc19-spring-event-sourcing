<?php

use Eventsourcing\Factory;
use Eventsourcing\SessionId;

require __DIR__ . '/vendor/autoload.php';

$_COOKIE['checkout_demo_session'] = '10603jjdasv8vpid64t214762l';
$session = new \Eventsourcing\Session();

$factory = new Factory($session);

$billingAddress = new \Eventsourcing\Checkout\BillingAddress(
    'john',
    'doe',
    'john@example.org',
    'some street',
    '12345',
    'some city',
    'DE'
);

//$factory->createSetBillingAddressCommand($billingAddress)->execute();
//$factory->createStartCheckoutCommand()->execute();
$factory->createCompleteCheckoutCommand()->execute();

