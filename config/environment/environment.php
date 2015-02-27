<?php


	if (strstr($_SERVER['HTTP_HOST'], '.local') || strstr(php_uname('n'), '.local')) {
		return 'development';

	} else if (strstr($_SERVER['HTTP_HOST'], '.dev') || strstr(php_uname('n'), 'dev')) {
		return 'staging';

	} else {
		return 'production';
	}