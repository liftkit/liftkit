<?php

	use LiftKit\DependencyInjection\Container\Container;
	use LiftKit\Config\Config;

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
					'mysql:host=' . $config['host'] . ';dbname=' . $config['schema'],
					$config['user'],
					$config['password']
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
