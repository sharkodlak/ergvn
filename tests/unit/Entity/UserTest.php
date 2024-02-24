<?php

declare(strict_types = 1);

namespace Tests\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {
	public function testGetId(): void {
		$user = new User('123');
		$this->assertSame('123', $user->getId());
	}
}
