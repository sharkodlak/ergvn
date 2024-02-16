<?php

declare(strict_types = 1);

namespace App\App\Api;

use League\OpenAPIValidation\PSR7\Exception\MultipleOperationsMismatchForRequest;
use League\OpenAPIValidation\PSR7\Exception\NoOperation;
use League\OpenAPIValidation\PSR7\OperationAddress;
use League\OpenAPIValidation\PSR7\PathFinder;
use League\OpenAPIValidation\PSR7\ResponseValidator as LeagueResponseValidator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class ResponseValidator implements MiddlewareInterface
{
	public function __construct(
		private readonly LeagueResponseValidator $validator
	) {
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		$response = $handler->handle($request);
		$matchingOperationsAddrs = $this->findMatchingOperations($request);

		if ($matchingOperationsAddrs === []) {
			throw NoOperation::fromPathAndMethod($request->getUri()->getPath(), \strtolower($request->getMethod()));
		}

		// Single match is the most desirable variant, because we reduce ambiguity down to zero
		if (\count($matchingOperationsAddrs) === 1) {
			$this->validator->validate($matchingOperationsAddrs[0], $response);
			return $response;
		}

		// There are multiple matching operations, this is bad, because if none of them match the message
		// then we cannot say reliably which one intended to match
		foreach ($matchingOperationsAddrs as $matchedAddr) {
			try {
				$this->validator->validate($matchedAddr, $response);
				return $response;
			} catch (Throwable) {
				// that operation did not match
			}
		}

		// no operation matched at all...
		throw MultipleOperationsMismatchForRequest::fromMatchedAddrs($matchingOperationsAddrs);
	}

	/**
	 * Check the openapi spec and find matching operations(path+method)
	 * This should consider path parameters as well
	 * "/users/12" should match both ["/users/{id}", "/users/{group}"]
	 *
	 * @return array<OperationAddress>
	 */
	private function findMatchingOperations(ServerRequestInterface $request): array
	{
		$pathFinder = new PathFinder($this->validator->getSchema(), (string) $request->getUri(), $request->getMethod());
		return $pathFinder->search();
	}
}