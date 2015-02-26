<?php


	namespace Application\Controller;


	class Index extends Controller
	{



		public function index ()
		{
			return $this->viewLoader->load('index');
		}
	}