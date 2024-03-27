<?php

declare(strict_types = 1);

namespace App\Infrastructure;

use App\Dto\CreateUserDto;
use App\Entity\User;
use App\Exceptions\UserAlreadyExists;
use App\Repository\UserRepository;
use App\ValueObject\Email;
use App\ValueObject\UserId;
use App\ValueObject\UserName;
use PDO;
use PDOStatement;

/**
 * @phpstan-type UserRow array{
 *   id: string,
 * }
 */
class UserRepositoryImpl implements UserRepository {
	public function __construct(
		private readonly PDO $pdo
	) {
	}

	public function createUser(CreateUserDto $newUser): void {
		$user = $this->findByUsername($newUser->getUsername());

		if ($user !== null) {
			throw new UserAlreadyExists('User already exists');
		}

		$stmt = $this->pdo->prepare('INSERT INTO users (username, email) VALUES (:username, :email)');
		$stmt->execute([
			'email' => $newUser->getEmail(),
			'username' => $newUser->getUsername(),
		]);
	}

	public function findByUserId(string $id): ?User {
		$stmt = $this->pdo->prepare('SELECT user_id FROM users WHERE user_id = :id');
		$stmt->execute(['id' => $id]);
		return $this->fetch($stmt);
	}

	public function findByUsername(string $username): ?User {
		$stmt = $this->pdo->prepare('SELECT user_id FROM users WHERE username = :username');
		$stmt->execute(['username' => $username]);
		return $this->fetch($stmt);
	}

	private function fetch(PDOStatement $stmt): ?User {
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		\assert(\is_array($row) || $row === false, 'Unexpected fetch result');

		if ($row === false) {
			return null;
		}

		$userId = new UserId($row['user_id']);
		$username = new UserName($row['username']);
		$email = new Email($row['email']);

		return new User($userId, $username, $email);
	}
}
