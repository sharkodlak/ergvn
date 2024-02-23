<?php

declare(strict_types = 1);

namespace App\App\Api;

use League\OpenAPIValidation\PSR7\ValidatorBuilder;

class ValidatorFactory {
	private readonly ValidatorBuilder $validatorBuilder;

	public function __construct(
		private readonly string $openApiYamlFile
	) {
		$this->validatorBuilder = (new ValidatorBuilder())
			->fromYamlFile($this->openApiYamlFile);
	}

	public function createRequestValidator(): RequestValidator {
		$validator = $this->validatorBuilder->getServerRequestValidator();
		return new RequestValidator($validator);
	}

	public function createResponseValidator(): ResponseValidator {
		$validator = $this->validatorBuilder->getResponseValidator();
		return new ResponseValidator($validator);
	}
}
