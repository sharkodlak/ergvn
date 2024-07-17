<?php

declare(strict_types=1);

use Nette\Bootstrap\Configurator;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = new Dotenv();
    $dotenv->load(__DIR__ . '/../.env');

    $configurator = new Configurator();
    $configurator->addDynamicParameters([
        'env' => $_ENV,
    ]);

    $configurator->setTempDirectory(__DIR__ . '/../temp');
    $configurator->enableTracy(__DIR__ . '/../var/log');
    $configurator->addConfig(__DIR__ . '/../config/common.neon');
    $configurator->setDebugMode(true);

    $container = $configurator->createContainer();
    $container->getService('application')->run();
} catch (Throwable $e) {
    var_dump($e);
    exit(1);
}
