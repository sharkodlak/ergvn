<?php

declare(strict_types = 1);

namespace App\Entity;

use App\ValueObject\Email;
use App\ValueObject\UserId;
use App\ValueObject\UserName;

class User {
	public function __construct(
		private readonly UserId $id,
		private readonly UserName $username,
		private readonly Email $email
	) {
	}

	public function getEmail(): Email {
		return $this->email;
	}

	public function getId(): UserId {
		return $this->id;
	}

	public function getUsername(): UserName {
		return $this->username;
	}
}
