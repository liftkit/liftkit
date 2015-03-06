<?php


	use LiftKit\DependencyInjection\Container\Container;
	use LiftKit\Loader\File\Script as ScriptLoader;


	/**
	 * @var Container $container
	 */

	$container->setSingletonRule(
		'App.TestScriptLoader',
		function ()
		{
			return new ScriptLoader(dirname(dirname(__DIR__)) . '/config/', '.php');
		}
	);