<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\{RecipientController, OfferController, VoucherController};
// Routes

$app->get('/', function (Request $request, Response $response, array $args) use ($container){
    // Sample log message
    echo 'Restful API - Please read documentation.';
});

// Recipient Routes
$app->get('/recipient/{id}', function (Request $request, Response $response, array $args) use ($container){
    // Todo: Get functions returns null
    $recipientController = $container->get(RecipientController::class);
    return $recipientController->get($args);
});

$app->get('/recipient', function (Request $request, Response $response, array $args) use ($container){
    // Todo: Get All functions returns null
    $recipientController = $container->get(RecipientController::class);
    return $recipientController->getAll($request);
});

$app->post('/recipient', function (Request $request, Response $response, array $args) use ($container){
    $recipientController = $container->get(\App\Controller\RecipientController::class);
    return $recipientController->add($request);
});

// Offer Routes
$app->get('/offer/{id}', function (Request $request, Response $response, array $args) use ($container){
    // Todo: Get functions returns null
    $offerController = $container->get(OfferController::class);
    return $offerController->get($args);
});

$app->get('/offer', function (Request $request, Response $response, array $args) use ($container){
    // Todo: Get All functions returns null
    $offerController = $container->get(OfferController::class);
    return $offerController->getAll($request);
});

$app->post('/offer', function (Request $request, Response $response, array $args) use ($container){
    $offerController = $container->get(OfferController::class);
    return $offerController->add($request);
});

// Voucher Routes

$app->post('/createVoucher', function (Request $request, Response $response, array $args) use ($container){
    $voucherController = $container->get(VoucherController::class);
    return $voucherController->createVouchers($request);
});

$app->post('/getValidVouchers', function (Request $request, Response $response, array $args) use ($container){
    $voucherController = $container->get(VoucherController::class);
    return $voucherController->getValidVouchersByEmail($request);
});

$app->post('/getVoucherDiscount', function (Request $request, Response $response, array $args) use ($container){
    $voucherController = $container->get(VoucherController::class);
    return $voucherController->useVoucherDiscount($request);
});