<?php


	if (php_sapi_name() === 'cli') {
		return 'cli';

	} else if (strstr($_SERVER['HTTP_HOST'], '.local')) {
		return 'development';

	} else if (strstr($_SERVER['HTTP_HOST'], '.dev')) {
		return 'staging';

	} else {
		return 'production';
	}