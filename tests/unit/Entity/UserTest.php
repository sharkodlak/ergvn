<?php

declare(strict_types = 1);

namespace Tests\Unit\Entity;

use App\Entity\User;
use App\ValueObject\Email;
use App\ValueObject\UserId;
use App\ValueObject\UserName;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {
	public function testGetId(): void {
		$userId = new UserId('123');
		$username = new UserName('test');
		$mail = new Email('test@test.example');
		$user = new User($userId, $username, $mail);
		$this->assertSame('123', $user->getId()->getValue());
	}
}
