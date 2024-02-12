<?php

declare(strict_types=1);

use App\Controller\UserController;
use DI\Container;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);

$app = AppFactory::create();
$routeCollector = $app->getRouteCollector();
$routingMiddleware = $app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define a simple route
$app->get('/{route:.*}', function (RequestInterface $request, ResponseInterface $response, $args) {
	$name = $args['route'];
	$response->getBody()->write("Route: $name");
	return $response;
});

$app->run();
