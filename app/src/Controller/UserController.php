<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController
{
	public function createUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		$response->getBody()->write('Creating a new user');
		return $response->withStatus(201);
	}

	public function getUser(ServerRequestInterface $request, ResponseInterface $response, array $parameters): ResponseInterface
	{
		$userId = $parameters['userId'];
		$response->getBody()->write('Get user ' . $userId);
		return $response;
	}
}
