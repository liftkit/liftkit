<?php

	use LiftKit\DependencyInjection\Container\Container;

	use LiftKit\Database\Connection\MySql;
	use LiftKit\Database\Cache\Cache;
	use LiftKit\Database\Schema\Schema;

	/**
	 * @var Container $container
	 */


	$container->setRule(
		'App.Database.Cache',
		function ()
		{
			return new Cache;
		}
	);


	$container->setRule(
		'App.Database.Config',
		function (Container $container)
		{
			return $container->getObject('App.ConfigLoader')
				->load('database/connection/' . $container->getParameter('App.Environment'));
		}
	);


	$container->setSingletonRule(
		'App.Database.Connection',
		function (Container $container)
		{
			$config = $container->getObject('App.Database.Config');

			return new MySql(
				$container,
				$container->getObject('App.Database.Cache'),
				new PDO(
					$config['driver'] 
						. ':host=' . $config['host'] 
						. ';port=' . $config['port'] 
						. ';dbname=' . $config['dbname'] 
						. ';charset=' . $config['charset'],
					$config['user'],
					$config['password'],
					$config['options']
				)
			);
		}
	);


	$container->setSingletonRule(
		'App.Database.Schema',
		function (Container $container)
		{
			$connection = $container->getObject('App.Database.Connection');

			return new Schema($connection);
		}
	);
