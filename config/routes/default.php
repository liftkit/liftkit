<?php


	use LiftKit\DependencyInjection\Container\Container;
	use LiftKit\Router\Http as Router;
	use LiftKit\Router\Route\Http\Controller as ControllerRoute;


	/**
	 * @var Router $router
	 * @var Container $container
	 */


	$router->registerController(
		'/', 
		$container->getObject('Application.Controller.Index'),
		'Application.Index'
	);

