<?php


	namespace App\Controller;

	use LiftKit\Controller\Controller as LiftKitController;
	use LiftKit\DependencyInjection\Container\Container;

	use LiftKit\Application\Application;

	use LiftKit\Loader\File\View as ViewLoader;
	use LiftKit\Document\Html as Document;
	

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

			$this->application = $this->container->getObject('App.Application');
			$this->viewLoader  = $this->container->getObject('App.ViewLoader');
			$this->document    = $this->container->getObject('App.Utility.Document');
		}
	}
