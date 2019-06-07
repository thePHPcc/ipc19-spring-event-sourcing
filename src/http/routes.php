<?php

use Slim\Http\Request;
use Slim\Http\Response;

$factory = new \Eventsourcing\Factory(new \Eventsourcing\Session());
$commandFactory = $factory->createHttpCommandFactory();
$queryFactory = $factory->createHttpQueryFactory();

// Routes
$app->post('/startCheckout', function(Request $request, Response $response) use ($commandFactory) {
    $commandFactory->createStartCheckoutCommand()->execute();
    return $response->withRedirect('/checkout/address', 303);
});

$app->post('/checkout/address', function(Request $request, Response $response) use ($commandFactory) {
    $commandFactory->createSetBillingAddressCommand()->execute($request);
    return $response->withRedirect('/checkout/confirm', 303);
});

$app->get('/checkout/address', function(Request $request, Response $response) use ($queryFactory) {
    $queryFactory->createBillingAddressFormQuery()->execute($response);
    return $response;
});

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write('404');
});


