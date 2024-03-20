<?php

declare(strict_types = 1);

namespace App;

use App\App\Api\ValidatorFactory;
use App\App\Config;
use App\App\RouterFactory;
use App\App\Services;
use App\App\SlimAppFactory;
use DI\Container;
use DI\ContainerBuilder;
use Symfony\Component\Dotenv\Dotenv;

class Bootstrap {
	public static function boot(): Container {
		$containerBuilder = new ContainerBuilder();
		$dotenv = new Dotenv();
		$config = new Config($dotenv, __DIR__ . '/../.env');
		$services = new Services($containerBuilder, $config);
		$routerFactory = new RouterFactory();
		$openApiFile = __DIR__ . '/../openapi.yaml';
		$validatorFactory = new ValidatorFactory($openApiFile);

		$container = $services->register();
		$container->set(
			SlimAppFactory::class,
			static fn () => new SlimAppFactory(
				$container,
				$routerFactory,
				$validatorFactory,
				$config
			)
		);

		return $container;
	}
}
