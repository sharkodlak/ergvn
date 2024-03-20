<?php

declare(strict_types = 1);

namespace App\App;

use App\Infrastructure\UserRepositoryImpl;
use App\Repository\UserRepository;
use Aura\Sql\ExtendedPdo;
use DI\Container;
use DI\ContainerBuilder;
use PDO;

use function DI\autowire;
use function DI\create;
use function DI\value;

/** @phpstan-type ConfigArray array<string, string> */
class Services {
	public function __construct(
		private readonly ContainerBuilder $containerBuilder,
		private readonly Config $config
	) {
	}

	public function register(): Container {
		$this->containerBuilder->addDefinitions([
			PDO::class => create(ExtendedPdo::class)
				->constructor(
					value(
						\sprintf(
							'pgsql:host=%s;dbname=%s',
							$this->config['DB_HOST'],
							$this->config['DB_NAME']
						)
					),
					value($this->config['DB_USER']),
					value($this->config['DB_PASS'])
				),
			UserRepository::class => autowire(UserRepositoryImpl::class),
		]);
		return $this->containerBuilder->build();
	}
}
