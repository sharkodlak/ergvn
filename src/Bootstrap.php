<?php

declare(strict_types = 1);

namespace App;

use App\App\Api\ValidatorFactory;
use App\App\RouterFactory;
use App\App\SlimAppFactory;
use DI\Container;

class Bootstrap
{
	public static function boot(): Container
	{
		$container = new Container();
		$routerFactory = new RouterFactory();
		$validatorFactory = new ValidatorFactory(
			__DIR__ . '/../openapi.yaml'
		);

		$container->set(
			SlimAppFactory::class,
			fn() => new SlimAppFactory(
				$container,
				$routerFactory,
				$validatorFactory
			)
		);

		return $container;
	}
}
