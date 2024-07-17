<?php

declare(strict_types = 1);

namespace App;

use Nette\Application\Routers\RouteList;

class RouterFactory {
	public static function createRouter(): RouteList {
		$router = new RouteList();

		$router->withModule('API')
			->addRoute('api/v1/books', [
				'presenter' => 'Books',
				'action' => 'getBooks',
				'method' => 'GET',
			]);

		$router->addRoute('<presenter>[/<action>[/<id>]]', 'Home:default');
		return $router;
	}
}
