<?php


	/**
	 * Staging reporting config
	 */

	error_reporting(E_ALL & ~ E_NOTICE & ~E_STRICT);

	ini_set('display_errors', false);
	ini_set('log_errors', true);