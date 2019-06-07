<?php

use Eventsourcing\Factory;
use Eventsourcing\SessionId;

require __DIR__ . '/vendor/autoload.php';

$sessionId = new SessionId('has4t1glskcktjh4ujs9eet26u');
$session = new \Eventsourcing\Session($sessionId);

$factory = new Factory($session);

$factory->createStartCheckoutCommand()->execute();
