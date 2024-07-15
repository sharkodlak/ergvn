<?php

declare(strict_types = 1);

namespace App\BookModule\ValueObject;

readonly class Price {
	const FORMAT = '%.2f';

	// NOTE: Using of float type for test assignment, in real project it should be better type
	public function __construct(
		private float $value
	) {
	}

	public function __toString(): string {
		return \sprintf(self::FORMAT, $this->value);
	}

	public function getValue(): float {
		return $this->value;
	}
}
