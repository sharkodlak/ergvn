<?php

declare(strict_types = 1);

namespace Tests\Unit\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase {
	/** @var UserRepository&MockObject $userRepository */
	private UserRepository $userRepository;

	public function testFindUserById(): void {
		$userId = '00000000-0000-0000-0000-000000000000';
		$user = new User($userId);
		$this->userRepository
			->expects($this->once())
			->method('findUserById')
			->willReturn($user);
		
		$this->assertEquals($user, $this->userRepository->findUserById($userId));
	}

	protected function setUp(): void {
		$this->userRepository = $this->createMock(UserRepository::class);
	}
}
