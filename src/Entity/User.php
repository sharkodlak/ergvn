<?php

declare(strict_types = 1);

namespace App\Entity;

class User {
	public function __construct(
		private readonly string $id
	) {
	}

	public function getId(): string {
		return $this->id;
	}

	private function setId(string $id): void {
		$this->id = $id;
	}
}
