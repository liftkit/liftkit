<?php


	/**
	 * Put your environment detection logic in this file. Included are some reasonable defaults
	 * that apply to our server configurations.
	 *
	 * Do NOT rely on our default values for your own use.
	 *
	 * This file should return a string indicating the environment name. You can specify your own.
	 *
	 * By default, you Application's module will load the config files found in config/errors/ and
	 * config/database/connection/ with the same name as the environment string. These files are
	 * used for setting error reporting configuration and database connection configuration,
	 * respectively.
	 *
	 * You can create your own environment-dependent configurations by extending
	 * \App\Module\Module in \App\Module\Application.
	 */


	$hostName = php_uname('n');

	if (strstr($hostName, '.local')) {
		return 'development';

	} else if (strstr($hostName, 'dev')) {
		return 'staging';

	} else {
		return 'production';
	}
