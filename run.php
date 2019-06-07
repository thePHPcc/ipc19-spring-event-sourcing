<?php

use Eventsourcing\Factory;
use Eventsourcing\SessionId;

require __DIR__ . '/vendor/autoload.php';

$sessionId = new SessionId('has4t1glskcktjh4ujs9eet26u');
$factory = new Factory($sessionId);

$factory->createStartCheckoutCommand()->execute();
