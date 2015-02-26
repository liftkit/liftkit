<?php


	namespace Application\Controller;

	use LiftKit\Controller\Controller as LiftKitController;
	use LiftKit\Application\Application;
	use LiftKit\DependencyInjection\Container\Container;

	use LiftKit\Loader\File\View as ViewLoader;


	abstract class Controller extends LiftKitController
	{
		/**
		 * @var ViewLoader
		 */
		protected $viewLoader;


		public function __construct (Application $application, Container $container)
		{
			parent::__construct($application, $container);

			$this->viewLoader = $this->container->getObject('Application.ViewLoader');
		}
	}