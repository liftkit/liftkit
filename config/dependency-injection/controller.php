<?php


	use Application\Controller\Index as IndexController;
	use LiftKit\DependencyInjection\Container\Container;


	/**
	 * @var Container $container
	 */


	$container->setRule(
		'Application.Controller.Index',
		function (Container $container)
		{
			return new IndexController($container);
		}
	);