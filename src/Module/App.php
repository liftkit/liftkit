<?php


	namespace App\Module;


	class App extends Module
	{
		
		
		protected function loadModules()
		{
			$this->addSubModule(
				'ExampleModule',
				$this->loadModule('liftkit/example-module/example-module')
			);
			
			parent::loadModules();
		}
		
		
		protected function modulesLoaded ()
		{
			$this->loadDependencyInjectionConfig('dependency-injection/example-module');
		}
	}