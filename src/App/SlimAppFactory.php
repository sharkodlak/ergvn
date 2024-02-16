<?php

declare(strict_types = 1);

namespace App\App;

use App\App\Api\ValidatorFactory;
use DI\Container;
use Slim\App;
use Slim\Factory\AppFactory;

class SlimAppFactory
{
	public function __construct(
		private bool $debugMode,
		private readonly Container $container,
		private readonly RouterFactory $routerFactory,
		private readonly ValidatorFactory $validatorFactory
	) {
	}


	public function create(): App
	{
		AppFactory::setContainer($this->container);
		$app = AppFactory::create();

		$requestValidator = $this->validatorFactory->createRequestValidator();
		$app->add($requestValidator);

		$responseValidator = $this->validatorFactory->createResponseValidator();
		$app->add($responseValidator);

		$app->addErrorMiddleware(true, true, true);
		$this->routerFactory->registerRoutes($app);

		return $app;
	}
}
