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
		}
		
		
		protected function modulesLoaded ()
		{
			parent::modulesLoaded();
			
			$this->loadDependencyInjectionConfig('dependency-injection/example-module');
		}
	}