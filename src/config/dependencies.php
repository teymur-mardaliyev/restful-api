<?php

use Doctrine\Common\{Cache\FilesystemCache};
use Doctrine\ORM\{EntityManager, Mapping\Driver\XmlDriver, Tools\Setup};
use Slim\Container;
use App\Service\{LoggerService, CodeGenerator};

use App\Controller\{
    RecipientController,
    OfferController,
    VoucherController
};

use App\Repository\{
    RecipientRepository,
    OfferRepository,
    VoucherRepository
};

use App\Entity\{
    VoucherCode,
    SpecialOffer,
    Recipient
};


$settings = require_once __DIR__ . '/settings.php';

$container = new Container($settings);

$container[EntityManager::class] = function (Container $container): EntityManager {
    $settings = $container['settings']['doctrine'];

    $config = Setup::createAnnotationMetadataConfiguration(
        array($settings['metadata_dirs']),
        $settings['dev_mode']
    );

    $driver = new XmlDriver([
        $settings['xml_maps']
    ]);

    $config->addEntityNamespace('App\\Entity', 'src\Entity');

    $config->setMetadataDriverImpl($driver);

    $config->setMetadataCacheImpl(
        new FilesystemCache(
            $settings['cache_dir']
        )
    );

    return EntityManager::create(
        $settings['connection'],
        $config
    );
};

// Logger

$container[LoggerService::class] = function () use ($container) : LoggerService{
    $settings = $container->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return new LoggerService($logger);
};

// Voucher Code Generator

$container[CodeGenerator::class] = function () use ($container) : CodeGenerator{
    return new CodeGenerator();
};

// Recipient

$container[RecipientRepository::class] = function () use ($container) : RecipientRepository{
    return new RecipientRepository(
        $container->get(EntityManager::class),
        $container->get(LoggerService::class)
    );
};


$container[RecipientController::class] = function () use ($container) : RecipientController{
    // ToDo: Entity should be changed to Factory Design Patter
    return new RecipientController(
        $container->get(RecipientRepository::class),
        new Recipient()
    );
};

// Offer

$container[OfferRepository::class] = function () use ($container) : OfferRepository{
    return new OfferRepository(
        $container->get(EntityManager::class),
        $container->get(LoggerService::class)
    );
};

$container[OfferController::class] = function () use ($container) : OfferController{
    // ToDo: Entity should be changed to Factory Design Patter
    return new OfferController(
        $container->get(OfferRepository::class),
        new SpecialOffer()
    );
};

// Voucher

$container[VoucherRepository::class] = function (Container $container) : VoucherRepository{
    return new VoucherRepository(
        $container->get(EntityManager::class),
        $container->get(LoggerService::class)
    );
};

$container[VoucherController::class] = function () use ($container) : VoucherController{
    // ToDo: Entity should be changed to Factory Design Patter
    return new VoucherController(
        $container->get(VoucherRepository::class),
        new VoucherCode(),
        $container->get(OfferRepository::class),
        $container->get(RecipientRepository::class),
        $container->get(CodeGenerator::class)
    );
};



return $container;