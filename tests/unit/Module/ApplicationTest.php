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
		
		
		public function testExecute ()
		{
			$module = $this->getModule();
			$response = $module->execute('/');
			
			$this->assertEquals(
				(string) $response,
				file_get_contents(dirname(dirname(dirname(__DIR__))) . '/views/index.php')
			);
		}


		protected function getModule ()
		{
			return new Application($this->container);
		}
	}