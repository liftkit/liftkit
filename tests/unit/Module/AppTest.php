<?php


	namespace App\Tests\Unit\Module;

	use App\Tests\Helpers\TestCase;


	class AppTest extends TestCase
	{


		public function testInitializeModule ()
		{
			$this->initializeModule();
		}
		
		
		public function testExecute ()
		{
			$module = $this->initializeModule();
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
			$module = $this->initializeModule();
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
		
		
		public function test404 ()
		{
			$module = $this->initializeModule();
			$response = $module->execute('/trigger-404');
			
			$this->assertContains(
				'<h1>404: Not Found</h1>',
				(string) $response
			);
			
			$this->assertContains(
				'<title>404: Not Found</title>',
				(string) $response
			);
		}
		
		
		public function test500 ()
		{
			$module = $this->initializeModule();
			$response = $module->execute('/trigger-500');
			
			$this->assertContains(
				'<h1>500: Internal Server Error</h1>',
				(string) $response
			);
			
			$this->assertContains(
				'<title>500: Internal Server Error</title>',
				(string) $response
			);
		}
		
		
		public function testExampleModulePage1 ()
		{
			$module = $this->initializeModule();
			$response = $module->execute('/example/page1');
			
			$this->assertEquals(
				'page1',
				(string) $response
			);
		}
		
		
		public function testExampleModulePage2 ()
		{
			$module = $this->initializeModule();
			$response = $module->execute('/example/page2');
			
			$this->assertEquals(
				'overridden',
				(string) $response
			);
		}
	}