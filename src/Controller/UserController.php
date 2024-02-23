<?php

declare(strict_types = 1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController {
	/** @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter */
	public function createUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
		$data = [
			'email' => 'john@doe.com',
			'id' => '00000000-0000-0000-0000-000000000000',
			'name' => 'John Doe',
		];
		$response->getBody()->write(\json_encode($data, \JSON_THROW_ON_ERROR));
		$response = $response->withHeader('Content-Type', 'application/json');
		return $response->withStatus(201);
	}

	/**
	 * @param array{userId: string} $parameters
	 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
	 */
	public function getUser(
		ServerRequestInterface $request,
		ResponseInterface $response,
		array $parameters
	): ResponseInterface {
		$userId = $parameters['userId'];
		$data = [
			'email' => 'john@doe.com',
			'id' => $userId,
			'name' => 'John Doe',
		];
		$response->getBody()->write(\json_encode($data, \JSON_THROW_ON_ERROR));
		$response = $response->withHeader('Content-Type', 'application/json');
		return $response;
	}
}
