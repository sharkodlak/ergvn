<?php

declare(strict_types = 1);

namespace App\App\Api;

use League\OpenAPIValidation\PSR7\ValidatorBuilder;

class ValidatorFactory
{
	private readonly ValidatorBuilder $validatorBuilder;

	public function __construct(
		private readonly string $openApiYamlFile
	) {
		$this->validatorBuilder = (new ValidatorBuilder())
			->fromYamlFile($this->openApiYamlFile);
	}


	public function createRequestValidator(): Validator
	{
		$validator = $this->validatorBuilder->getServerRequestValidator();
		return new Validator($validator);
	}


	public function createResponseValidator(): Validator
	{
		$validator = $this->validatorBuilder->getResponseValidator();
		return new Validator($validator);
	}
}
