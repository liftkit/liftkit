<?php


	namespace Application\Module;

	use LiftKit\Module\Module as LiftKitModule;
	
	use LiftKit\Application\Application;
	use LiftKit\Loader\File\Script as ScriptLoader;
	use LiftKit\Loader\File\Config as ConfigLoader;

	use LiftKit\Config\Config;

	use LiftKit\Database\Connection\Connection as DatabaseConnection;
	use LiftKit\Database\Schema\Schema as DatabaseSchema;

	use LiftKit\Router\Router;


	abstract class Module extends LiftKitModule
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
		 * @var Application
		 */
		protected $application;


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
			return $this->router->execute($uri);
		}


		protected function initialize ()
		{
			$this->initializeDefault();
			$this->initializeEnvironment();
			$this->initializeDatabase();
			$this->initializeUtilities();
			$this->initializeHooks();
			$this->initializeControllers();
			$this->initializeRouter();
		}


		protected function initializeDefault ()
		{
			$this->scriptLoader = $this->container->getObject('Application.ScriptLoader');
			$this->configLoader = $this->container->getObject('Application.ConfigLoader');
			$this->config       = $this->container->getObject('Application.Config');
			$this->application  = $this->container->getObject('Application.Application');
		}


		public function initializeEnvironment ()
		{
			$this->config['environment'] = $this->scriptLoader->load('environment/environment', ['container' => $this->container]);
			$this->scriptLoader->load('errors/' . $this->config['environment']);
			$this->container->setParameter('Application.Environment', $this->config['environment']);
		}


		protected function initializeDatabase ()
		{
			$this->loadDependencyInjectionConfig('dependency-injection/database');

			$this->database = $this->container->getObject('Application.Database.Connection');
			$this->schema   = $this->container->getObject('Application.Database.Schema');

			$this->loadSchemaConfig('database/schema/default');
		}
		
		
		protected function initializeUtilities ()
		{
			$this->loadDependencyInjectionConfig('dependency-injection/utility');
		}
		
		
		protected function initializeHooks ()
		{
			$this->loadHooksConfig('hooks/default');
		}


		protected function initializeControllers ()
		{
			$this->loadDependencyInjectionConfig('dependency-injection/controller');
		}


		protected function initializeRouter ()
		{
			$this->router = $this->container->getObject('Application.Router');

			$this->loadRouteConfig('routes/default');
		}


		protected function loadDependencyInjectionConfig ($configFile)
		{
			$this->scriptLoader->load(
				$configFile,
				['container' => $this->container]
			);
		}


		protected function loadSchemaConfig ($configFile)
		{
			$this->scriptLoader->load(
				$configFile,
				['schema' => $this->schema]
			);
		}


		protected function loadRouteConfig ($configFile)
		{
			$this->scriptLoader->load(
				$configFile,
				[
					'container' => $this->container,
					'router'    => $this->router,
				]
			);
		}


		protected function loadHooksConfig ($configFile)
		{
			$this->scriptLoader->load(
				$configFile,
				[
					'application' => $this->application,
					'module'      => $this,
				]
			);
		}
	}