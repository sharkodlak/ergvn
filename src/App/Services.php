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
						sprintf('pgsql:host=%s;dbname=%s',
							$this->config['params']['db']['host'],
							$this->config['params']['db']['dbname']
						)
					),
					value($this->config['params']['db']['user']),
					value($this->config['params']['db']['password'])
				),
			UserRepository::class => autowire(UserRepositoryImpl::class),
		]);
		$container = $this->containerBuilder->build();
		return $container;
	}
}
