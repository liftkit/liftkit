<?php

	use App\Module\App;

	use LiftKit\DependencyInjection\Container\Container;

	use LiftKit\Loader\File\Script as ScriptLoader;
	use LiftKit\Loader\File\Config as ConfigLoader;
	use LiftKit\Loader\File\View as ViewLoader;

	use LiftKit\Application\Application as Application;
	use LiftKit\Config\Config;
	use LiftKit\Router\Http as HttpRouter;
	use LiftKit\Request\Http as Request;
	use LiftKit\Input\Input;


	$container->setSingletonRule(
		'App.ConfigLoader',
		function ()
		{
			return new ConfigLoader(dirname(dirname(__DIR__)) . '/config/', '.php');
		}
	);


	$container->setSingletonRule(
		'App.ScriptLoader',
		function ()
		{
			return new ScriptLoader(dirname(dirname(__DIR__)) . '/config/', '.php');
		}
	);


	$container->setSingletonRule(
		'App.ModuleLoader',
		function ()
		{
			return new ScriptLoader(dirname(dirname(__DIR__)) . '/vendor/', '.php');
		}
	);


	$container->setSingletonRule(
		'App.ViewLoader',
		function ()
		{
			return new ViewLoader(dirname(dirname(__DIR__)) . '/views/', '.php');
		}
	);


	$container->setSingletonRule(
		'App.Config',
		function ()
		{
			return new Config;
		}
	);


	$container->setSingletonRule(
		'App.Module',
		function (Container $container)
		{
			return new App($container);
		}
	);


	$container->setSingletonRule(
		'App.Application',
		function ()
		{
			return new Application;
		}
	);


	$container->setSingletonRule(
		'App.Router',
		function ()
		{
			return new HttpRouter;
		}
	);


	$container->setSingletonRule(
		'App.Request',
		function ()
		{
			return new Request(
				$_SERVER,
				new Input($_GET),
				new Input($_POST),
				new Input($_COOKIE)
			);
		}
	);
