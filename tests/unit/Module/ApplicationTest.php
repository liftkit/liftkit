<?php


	namespace Application\Tests\Unit\Module;

	use Application\Module\Application;
	use Application\Tests\Helpers\TestCase;


	class ApplicationTest extends TestCase
	{


		public function testInitializeModule ()
		{
			$this->getModule();
		}


		protected function getModule ()
		{
			return new Application($this->container);
		}
	}