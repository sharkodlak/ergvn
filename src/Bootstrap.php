<?php

declare(strict_types = 1);

namespace App;

use App\Api\RouterFactory;
use App\Api\SlimAppFactory;
use DI\Container;
use Slim\Middleware\ErrorMiddleware;

class Bootstrap
{
	public static function boot(): Container
	{
		$container = new Container();

		$routerFactory = new RouterFactory();

		$container->set(
			SlimAppFactory::class,
			fn() => new SlimAppFactory(
				true,
				$container,
				$routerFactory
			)
		);

		return $container;
	}
}
