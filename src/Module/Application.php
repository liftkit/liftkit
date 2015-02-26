<?php


	namespace Application\Module;

	use LiftKit\Module\Module;

	use LiftKit\Loader\File\Script as ScriptLoader;
	use LiftKit\Loader\File\Config as ConfigLoader;

	use LiftKit\Config\Config;

	use LiftKit\Database\Connection\Connection as DatabaseConnection;
	use LiftKit\Database\Schema\Schema as DatabaseSchema;

	use LiftKit\Router\Router;


	class Application extends Module
	{
		/**
		 * @var ScriptLoader
		 */
		protected $scriptLoader;


		/**
		 * @var ConfigLoader
		 */
		protected $configLoader;


		/**
		 * @var Config
		 */
		protected $config;


		/**
		 * @var DatabaseConnection
		 */
		protected $database;


		/**
		 * @var DatabaseSchema
		 */
		protected $schema;


		/**
		 * @var Router
		 */
		protected $router;


		public function execute ($uri)
		{
			$this->router->execute($uri);
		}


		protected function initialize ()
		{
			$this->initializeDefault();
			$this->initializeDatabase();
			$this->initializeRouter();
		}


		protected function initializeDefault ()
		{
			$this->scriptLoader = $this->container->getObject('Application.ScriptLoader');
			$this->configLoader = $this->container->getObject('Application.ConfigLoader');

			$this->config = $this->container->getObject('Application.Config');
		}


		protected function initializeDatabase ()
		{
			$this->scriptLoader->load('dependency-injection/database', array('container' => $this->container));

			$this->database = $this->container->getObject(
				'Application.Database.Connection',
				array(
					$this->configLoader->load('database/connection/default')
				)
			);

			$this->schema = $this->container->getObject('Application.Database.Schema');

			$this->scriptLoader->load('database/schema/default', array('schema' => $this->schema));
		}


		protected function initializeRouter ()
		{
			$this->router = $this->container->getObject('Application.Router');

			$this->scriptLoader->load(
				'routes/default',
				array(
					'container' => $this->container,
					'router'    => $this->router,
				)
			);
		}
	}