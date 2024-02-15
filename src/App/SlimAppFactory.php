<?php

declare(strict_types = 1);

namespace App\App;

use DI\Container;
use Slim\App;
use Slim\Factory\AppFactory;

class SlimAppFactory
{
	public function __construct(
		private bool $debugMode,
		private readonly Container $container,
		private readonly RouterFactory $routerFactory
	) {
	}


	public function create(): App
	{
		AppFactory::setContainer($this->container);
		$app = AppFactory::create();

		$app->addErrorMiddleware(true, true, true);
		$this->routerFactory->registerRoutes($app);

		return $app;
	}
}
