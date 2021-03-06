<?php


	namespace App\Module;

	use LiftKit\Module\Module as LiftKitModule;

	use LiftKit\Application\Application;
	use LiftKit\Loader\File\Script as ScriptLoader;
	use LiftKit\Loader\File\Config as ConfigLoader;

	use LiftKit\Config\Config;

	use LiftKit\Database\Connection\Connection as DatabaseConnection;
	use LiftKit\Database\Schema\Schema as DatabaseSchema;

	use LiftKit\Router\Router;
	use LiftKit\Request\Request;


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
		 * @var ScriptLoader
		 */
		protected $moduleLoader;


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


		public function execute (Request $request)
		{
			return $this->router->execute($request);
		}


		public function initialize ()
		{
			$this->initializeDefault();
			$this->initializeEnvironment();
			$this->initializeDatabase();
			$this->initializeUtilities();
			$this->initializeHooks();
			$this->initializeControllers();
			$this->initializeRouter();

			$this->loadModules();
			$this->modulesLoaded();
		}


		protected function initializeDefault ()
		{
			$this->scriptLoader = $this->container->getObject('App.ScriptLoader');
			$this->configLoader = $this->container->getObject('App.ConfigLoader');
			$this->moduleLoader = $this->container->getObject('App.ModuleLoader');
			$this->config       = $this->container->getObject('App.Config');
			$this->application  = $this->container->getObject('App.Application');
		}


		public function initializeEnvironment ()
		{
			$this->config['environment'] = $this->scriptLoader->load('environment/environment');
			$this->scriptLoader->load('errors/' . $this->config['environment']);
			$this->container->setParameter('App.Environment', $this->config['environment']);
		}


		protected function initializeDatabase ()
		{
			$this->loadDependencyInjectionConfig('dependency-injection/database');

			$this->database = $this->container->getObject('App.Database.Connection');
			$this->schema   = $this->container->getObject('App.Database.Schema');

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
			$this->router = $this->container->getObject('App.Router');

			$this->loadRouteConfig('routes/default');
		}


		protected function loadModules ()
		{
		}


		protected function modulesLoaded ()
		{
			foreach ($this->getSubModules() as $subModule) {
				$subModule->initialize();
			}
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


		protected function loadModule ($moduleFile)
		{
			return $this->moduleLoader->load(
				$moduleFile,
				['container' => $this->container]
			);
		}
	}
