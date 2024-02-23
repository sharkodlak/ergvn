<?php

declare(strict_types = 1);

namespace App\App\Api;

use League\OpenAPIValidation\PSR7\ServerRequestValidator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestValidator implements MiddlewareInterface {
	public function __construct(
		private readonly ServerRequestValidator $validator
	) {
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
		$this->validator->validate($request);
		return $handler->handle($request);
	}
}
