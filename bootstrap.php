<?php


	require_once(__DIR__ . '/vendor/autoload.php');

	use LiftKit\DependencyInjection\Container\Container;
	use LiftKit\Router\Exception\NoMatchingRoute as RouteException;


	// Initialize Container

	$container = new Container;

	require(__DIR__ . '/config/dependency-injection/default.php');


	// Initialize Module

	$appModule = $container->getObject('App.Module');
	$appModule->initialize();

	$application = $container->getObject('App.Application');
	$request     = $container->getObject('App.Request');


	// Route Request

	try {
		$appModule->execute($request)->render();

	} catch (RouteException $e) {
		$application->triggerHook('404')->render();

	} catch (Exception $e) {
		$application->triggerHook('500')->render();
	}
