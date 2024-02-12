<?php

declare(strict_types=1);

use App\Api\SlimAppFactory;
use App\Bootstrap;

require __DIR__ . '/../../vendor/autoload.php';

$container = Bootstrap::boot();
$appFactory = $container->get(SlimAppFactory::class);
$app = $appFactory->create();

$app->run();
