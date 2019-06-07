<?php

use Eventsourcing\Factory;
use Eventsourcing\SessionId;

require __DIR__ . '/vendor/autoload.php';

$sessionId = new SessionId('has4t1glskcktjh4ujs9eet26u');
$sessionFilename = __DIR__ . '/var/session_' . $sessionId->asString();
if (!file_exists($sessionFilename)) {
    $session = new \Eventsourcing\Session($sessionId);
} else {
    $session = unserialize(file_get_contents($sessionFilename));
}

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

file_put_contents($sessionFilename, serialize($session));
