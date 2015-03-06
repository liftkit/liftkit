<?php


	use LiftKit\Tests\Stub\Session\Session;
	use LiftKit\DependencyInjection\Container\Container;


	/**
	 * @var Container $container
	 */


	$container->setSingletonRule(
		'App.Utility.Session',
		function ()
		{
			return new Session;
		}
	);