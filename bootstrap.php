<?php


	require_once(__DIR__ . '/vendor/autoload.php');


	use LiftKit\DependencyInjection\Container\Container;

	use Application\Module\Application;


	// Initialize Container

	$container = new Container;

	require(__DIR__ . '/config/dependency-injection/default.php');


	// Initialize Module

	$applicationModule = new Application($container);