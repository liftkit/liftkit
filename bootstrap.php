<?php


	require_once(__DIR__ . '/vendor/autoload.php');

	use LiftKit\DependencyInjection\Container\Container;
	use App\Module\App;

	use LiftKit\Router\Exception\NoMatchingRoute as RouteException;


	// Initialize Container

	$container = new Container;

	require(__DIR__ . '/config/dependency-injection/default.php');


	// Initialize Module

	$app = new App($container);

	$app->initialize();


	// Route Request

	try {
		$app->execute($container->getObject('App.Request'))->render();

	} catch (RouteException $e) {
		$container->getObject('App.Application')->triggerHook('404')->render();

	} catch (Exception $e) {
		$container->getObject('App.Application')->triggerHook('500');
	}