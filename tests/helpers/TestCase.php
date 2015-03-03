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
		}


		protected function initializeModule ()
		{
			$app = new App($this->container);

			$app->initialize();

			return $app;
		}


		protected function createRequest ($method, $uri)
		{
			return new HttpRequest(
				array(
					'REQUEST_METHOD' => $method,
					'REQUEST_URI'    => $uri,
				)
			);
		}

	}