<?php
umask(0);
require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

if (isset($_SERVER['DEBUG']) && $_SERVER['DEBUG'] === 'true') {
	$configurator->setDebugMode(TRUE);
}

//$configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->addParameters(['appDir' => __DIR__]);

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();

return $container;
