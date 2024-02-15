<?php

declare(strict_types = 1);

namespace App;

use App\App\RouterFactory;
use App\App\SlimAppFactory;
use DI\Container;

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
