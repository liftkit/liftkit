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
			
			$this->assertContains(
				'<h1>Welcome to LiftKit</h1>',
				(string) $response
			);
			
			$this->assertContains(
				'<title>Welcome to LiftKit</title>',
				(string) $response
			);
		}
		
		
		public function test403 ()
		{
			$module = $this->getModule();
			$response = $module->execute('/trigger-403');
			
			$this->assertContains(
				'<h1>403: Forbidden</h1>',
				(string) $response
			);
			
			$this->assertContains(
				'<title>403: Forbidden</title>',
				(string) $response
			);
		}


		protected function getModule ()
		{
			return new Application($this->container);
		}
	}