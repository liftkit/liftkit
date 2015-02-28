<?php


	use LiftKit\Document\Html as HtmlDocument;
	use LiftKit\DependencyInjection\Container\Container;


	/**
	 * @var Container $container
	 */


	$container->setRule(
		'App.Utility.Document',
		function ()
		{
			return new HtmlDocument;
		}
	);