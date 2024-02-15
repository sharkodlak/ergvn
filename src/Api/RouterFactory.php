<?php

declare(strict_types = 1);

namespace App\Api;

use App\Controller\UserController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class RouterFactory
{
	public function registerRoutes(App $slimApp): void
	{
		$versionGroup = $slimApp->group('/api/v{apiVersion}', function (RouteCollectorProxy $version): void {
			$version->group('/user', function (RouteCollectorProxy $user): void {
				$user->get('/{userId}', UserController::class . ':getUser');
				$user->post('', UserController::class . ':createUser');
			});
		});
	}
}
