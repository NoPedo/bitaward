<?php
if (PHP_SAPI !== 'cli') {
	exit;
}
$container = require __DIR__ . '/../app/bootstrap.php';
/** @var \Symfony\Component\Console\Application $application */
$application = $container->getService("kdyby.console.application");
$application->setAutoExit(TRUE);
$application->run();
