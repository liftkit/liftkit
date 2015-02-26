<?php


	namespace Application\Tests\Helpers;

	use LiftKit\DependencyInjection\Container\Container;
	use PHPUnit_Framework_TestCase;


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

	}