<?php


	require_once(__DIR__ . '/vendor/autoload.php');

	use LiftKit\DependencyInjection\Container\Container;
	use App\Module\App;


	// Initialize Container

	$container = new Container;

	require(__DIR__ . '/config/dependency-injection/default.php');


	// Initialize Module

	$app = new App($container);
	
	$app->initialize();
	$app->execute($_SERVER['REQUEST_URI'])->render();