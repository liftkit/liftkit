<?php


	namespace Application\Controller;

	use LiftKit\Controller\Controller as LiftKitController;
	use LiftKit\DependencyInjection\Container\Container;

	use LiftKit\Application\Application;

	use LiftKit\Loader\File\View as ViewLoader;
	use LiftKit\Document\Document;
	

	abstract class Controller extends LiftKitController
	{
		/**
		 * @var Application $application
		 */
		protected $application;
		
		
		/**
		 * @var ViewLoader
		 */
		protected $viewLoader;
		
		
		/**
		 * @var Document
		 */
		protected $document;


		public function __construct (Container $container)
		{
			parent::__construct($container);

			$this->application = $this->container->getObject('Application.Application');
			$this->viewLoader  = $this->container->getObject('Application.ViewLoader');
			$this->document    = $this->container->getObject('Application.Utility.Document');
		}
	}