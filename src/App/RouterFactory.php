<?php

declare(strict_types = 1);

namespace App\App;

use App\Controller\UserController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class RouterFactory
{
	public function registerRoutes(App $slimApp): void
	{
		$slimApp->group('/api/v{apiVersion}', static function (RouteCollectorProxy $version): void {
			$version->group('/user', static function (RouteCollectorProxy $user): void {
				$user->get('/{userId}', UserController::class . ':getUser');
				$user->post('', UserController::class . ':createUser');
			});
		});
	}
}
