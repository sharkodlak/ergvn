<?php

declare(strict_types = 1);

namespace App\App;

use ArrayAccess;
use RuntimeException;
use Symfony\Component\Yaml\Yaml;

/**
 * @phpstan-type ConfigArray array{
 *   params: array<string, mixed>,
 * }
 */
class Config implements ArrayAccess {
	public readonly array $config;

	public function __construct(
		string $configFile = __DIR__ . '/../../config/app.yaml'
	) {
		/** @var ConfigArray $config */
		$this->config = Yaml::parseFile($configFile);
	}

	public function offsetExists(mixed $offset): bool {
		return isset($this->config[$offset]);
	}

	public function offsetGet(mixed $offset): mixed {
		return $this->config[$offset];
	}

	public function offsetSet(mixed $offset, mixed $value): void {
		throw new RuntimeException('Config is read-only');
	}

	public function offsetUnset(mixed $offset): void {
		throw new RuntimeException('Config is read-only');
	}
}
