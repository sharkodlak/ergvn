<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
	public function index(Request $request, Response $response): Response
	{
		$response->getBody()->write('Hello, Slim Framework!');
		return $response;
	}
}
