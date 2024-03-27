<?php

declare(strict_types = 1);

namespace App\Dto;

class CreateUserDto {
	public function __construct(
		private readonly string $username,
		private readonly string $email
	) {
	}

	public function getEmail(): string {
		return $this->email;
	}

	public function getUsername(): string {
		return $this->username;
	}
}
