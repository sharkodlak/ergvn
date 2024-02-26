<?php

declare(strict_types=1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

$config = new Configuration();

return $config
	->ignoreErrorsOnPackage('nyholm/psr7', [ErrorType::UNUSED_DEPENDENCY])
	->ignoreErrorsOnPackage('nyholm/psr7-server', [ErrorType::UNUSED_DEPENDENCY])
;