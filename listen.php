<?php
require __DIR__ . '/vendor/autoload.php';

$eventListener = new \Eventsourcing\AsynchronousEventListener(
    new PDO('sqlite:' . __DIR__ . '/var/events.db')
);
$eventListener->register(new \Eventsourcing\SendOrderConfirmationMailEventHandler(
    new \Eventsourcing\MailService()
));

$eventListener->listen();

