<?php

declare(strict_types=1);

use Nette\Bootstrap\Configurator;

require __DIR__ . '/../vendor/autoload.php';

try {
    $configurator = new Configurator();
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
