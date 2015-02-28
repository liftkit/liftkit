<?php


	use Application\Module\Application as ApplicationModule;
	use LiftKit\Application\Application;
	use LiftKit\Application\Hook\Action;
	
	
	/**
	 * @var Application $application
	 * @var ApplicationModule $module
	 */
	 
	 
	/**
	 * Register hooks
	 */
	  
	$application->registerHook('403', new Action);
	$application->registerHook('404', new Action);
	$application->registerHook('500', new Action);
	

	$application->bindHook(
		'403',
		function () use ($module)
		{
			http_response_code(403);
			
			return $module->execute('/error-403');
		}
	);
	

	$application->bindHook(
		'404',
		function () use ($module)
		{
			http_response_code(404);
			
			return $module->execute('/error-404');
		}
	);
	

	$application->bindHook(
		'500',
		function () use ($module)
		{
			http_response_code(500);
			
			return $module->execute('/error-500');
		}
	);
	 
	 