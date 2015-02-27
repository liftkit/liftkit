<?php

	use LiftKit\Database\Schema\Schema;
	

	/**
	 * @var Schema $schema
	 */

	$schema->defineTable('children')
		->manyToOne('parents');

	$schema->defineTable('parents')
		->oneToMany('children');