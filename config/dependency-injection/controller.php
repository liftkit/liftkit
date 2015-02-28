<?php


	use App\Controller\Index as IndexController;
	use LiftKit\DependencyInjection\Container\Container;


	/**
	 * @var Container $container
	 */


	$container->setRule(
		'App.Controller.Index',
		function (Container $container)
		{
			return new IndexController($container);
		}
	);