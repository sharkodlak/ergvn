<?php

declare(strict_types = 1);

namespace App\Infrastructure;

use App\Entity\User;
use App\Repository\UserRepository;
use PDO;

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

	public function findByUserId(string $id): ?User {
		$stmt = $this->pdo->prepare('SELECT user_id FROM users WHERE user_id = :id');
		$stmt->execute(['id' => $id]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		\assert(\is_array($row) || $row === false, 'Unexpected fetch result');

		if ($row === false) {
			return null;
		}

		return new User($row['user_id']);
	}
}
