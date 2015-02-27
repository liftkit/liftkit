<?php

	use LiftKit\Loader\File\Script as ScriptLoader;
	use LiftKit\Loader\File\Config as ConfigLoader;
	use LiftKit\Loader\File\View as ViewLoader;

	use LiftKit\Application\Application as Application;
	use LiftKit\Config\Config;
	use LiftKit\Router\Http as HttpRouter;


	$container->setSingletonRule(
		'Application.ConfigLoader',
		function ()
		{
			return new ConfigLoader(dirname(dirname(__DIR__)) . '/config/', '.php');
		}
	);


	$container->setSingletonRule(
		'Application.ScriptLoader',
		function ()
		{
			return new ScriptLoader(dirname(dirname(__DIR__)) . '/config/', '.php');
		}
	);


	$container->setSingletonRule(
		'Application.ViewLoader',
		function ()
		{
			return new ViewLoader(dirname(dirname(__DIR__)) . '/views/', '.php');
		}
	);


	$container->setSingletonRule(
		'Application.Config',
		function ()
		{
			return new Config;
		}
	);


	$container->setSingletonRule(
		'Application.Application',
		function ()
		{
			return new Application;
		}
	);


	$container->setSingletonRule(
		'Application.Router',
		function ()
		{
			return new HttpRouter;
		}
	);