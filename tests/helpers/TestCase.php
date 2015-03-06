<?php


	namespace App\Tests\Helpers;

	use LiftKit\DependencyInjection\Container\Container;
	use App\Module\App;
	use PHPUnit_Framework_TestCase;
	use LiftKit\Request\Http as HttpRequest;


	abstract class TestCase extends PHPUnit_Framework_TestCase
	{
		/**
		 * @var Container
		 */
		protected $container;



		public function setUp ()
		{
			$this->container = $container = new Container;

			require(dirname(dirname(__DIR__)) . '/config/dependency-injection/default.php');
			require(dirname(__DIR__) . '/config/dependency-injection/default.php');
		}


		protected function initializeModule ()
		{
			$app = new App($this->container);

			$app->initialize();

			$scriptLoader = $this->container->getObject('App.TestScriptLoader');

			$scriptLoader->load(
				'dependency-injection/utility',
				[
					'container' => $this->container,
				]
			);

			return $app;
		}


		protected function createRequest ($method, $uri)
		{
			return new HttpRequest(
				[
					'REQUEST_METHOD' => $method,
					'REQUEST_URI'    => $uri,
				]
			);
		}

	}