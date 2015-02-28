<?php


	use App\Controller\Example as ExampleController;
	use LiftKit\DependencyInjection\Container\Container;
	
	/**
	 * @var Container $container
	 */
	
	$container->setRule(
		'ExampleModule.Controller.Example',
		function (Container $container)
		{
			return new ExampleController($container);
		}
	);