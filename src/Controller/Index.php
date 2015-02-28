<?php


	namespace Application\Controller;


	class Index extends Controller
	{


		public function index ()
		{
			$this->document->setTitle('Welcome to LiftKit');
			
			return $this->display(
				$this->viewLoader->load('index')
			);
		}
		
		
		public function error403 ()
		{
			$this->document->setTitle('403: Forbidden');
			
			return $this->display(
				$this->viewLoader->load('403')
			);
		}
		
		
		public function error404 ()
		{
			$this->document->setTitle('404: Not Found');
			
			return $this->display(
				$this->viewLoader->load('404')
			);
		}
		
		
		public function error500 ()
		{
			$this->document->setTitle('500: Internal Server Error');
			
			return $this->display(
				$this->viewLoader->load('500')
			);
		}
		
		
		public function trigger403 ()
		{
			return $this->application->triggerHook('403');
		}
		
		
		public function trigger404 ()
		{
			return $this->application->triggerHook('404');
		}
		
		
		public function trigger500 ()
		{
			return $this->application->triggerHook('500');
		}
		
		
		protected function display ($pageContent)
		{
			return $this->viewLoader->load(
				'templates/default',
				[
					'pageContent' => $pageContent,
					'document'    => $this->document,
				]
			);
		}
	}