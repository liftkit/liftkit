<?php


	require_once(__DIR__ . '/vendor/autoload.php');

	use LiftKit\DependencyInjection\Container\Container;
	use App\Module\App;
	use LiftKit\Request\Request;
	use LiftKit\Input\Input;


	// Initialize Container

	$container = new Container;

	require(__DIR__ . '/config/dependency-injection/default.php');


	// Initialize Module

	$app = new App($container);

	$app->initialize();


	// Route Request

	$app->execute($container->getObject('App.Request'))->render();