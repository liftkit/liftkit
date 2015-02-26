<?php

	use LiftKit\DependencyInjection\Container\Container;
	use LiftKit\Config\Config;

	use LiftKit\Database\Connection\MySQL;
	use LiftKit\Database\Cache\Cache;
	use LiftKit\Database\Schema\Schema;


	/**
	 * @var Container $container
	 */


	$container->setRule(
		'Application.Database.Cache',
		function ()
		{
			return new Cache;
		}
	);
	
	
	$container->setRule(
		'Application.Database.Config',
		function (Container $container)
		{
			return $container->getObject('Application.ConfigLoader')->load('database/connection/default');
		}
	);


	$container->setSingletonRule(
		'Application.Database.Connection',
		function (Container $container)
		{
			$config = $container->getObject('Application.Database.Config');
			
			return new MySQL(
				$container,
				$container->getObject('Application.Database.Cache'),
				$config['host'],
				$config['user'],
				$config['password'],
				$config['schema']
			);
		}
	);


	$container->setSingletonRule(
		'Application.Database.Schema',
		function (Container $container)
		{
			return new Schema($container->getObject('Application.Database.Connection'));
		}
	);