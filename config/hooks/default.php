<?php


	use App\Module\App as AppModule;
	use LiftKit\Application\Application;
	use LiftKit\Application\Hook\Action;
	use LiftKit\Request\Http as Request;


	/**
	 * @var Application $application
	 * @var AppModule $module
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

			return $module->execute(new Request(
				[
					'REQUEST_METHOD' => 'GET',
					'REQUEST_URI'    => '/error-403',
				]
			));
		}
	);


	$application->bindHook(
		'404',
		function () use ($module)
		{
			http_response_code(404);

			return $module->execute(new Request(
				[
					'REQUEST_METHOD' => 'GET',
					'REQUEST_URI'    => '/error-404',
				]
			));
		}
	);


	$application->bindHook(
		'500',
		function () use ($module)
		{
			http_response_code(500);

			return $module->execute(new Request(
				[
					'REQUEST_METHOD' => 'GET',
					'REQUEST_URI'    => '/error-500',
				]
			));
		}
	);

