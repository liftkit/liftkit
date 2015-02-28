<?php


	namespace App\Controller;
	
	use ExampleModule\Controller\Example as ExampleController;
	
	
	class Example extends ExampleController
	{
		
		
		public function page2 ()
		{
			return 'overridden';
		}
	}