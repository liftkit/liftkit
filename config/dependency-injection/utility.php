<?php


	use LiftKit\Document\Html as HtmlDocument;
	use LiftKit\DependencyInjection\Container\Container;


	/**
	 * @var Container $container
	 */


	$container->setRule(
		'Application.Utility.Document',
		function ()
		{
			return new HtmlDocument;
		}
	);