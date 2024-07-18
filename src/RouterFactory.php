<?php

declare(strict_types = 1);

namespace App;

use Nette\Application\Routers\RouteList;

class RouterFactory {
	// phpcs:ignore SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
	public static function createRouter(): RouteList {
		$router = new RouteList();

		$router->withModule('API')
			->addRoute('api/v1/books/<bookId>', [
				'presenter' => 'Books',
				'action' => 'book',
				'method' => [
					'GET',
					'PUT',
					'DELETE',
				],
			])
			->addRoute('api/v1/books', [
				'presenter' => 'Books',
				'action' => 'books',
				'method' => [
					'GET',
					'POST',
				],
			]);

		$router->addRoute('<presenter>[/<action>[/<id>]]', 'Home:default');
		return $router;
	}
}
