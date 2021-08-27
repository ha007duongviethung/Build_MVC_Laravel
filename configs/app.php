<?php

$config['app'] = [
	'service' => [
		HtmlHelper::class // 'HtmlHelper'
	],
	'routeMiddleware' => [
		'san-pham' => AuthMiddleware::class
	],
	'globalMiddleware' => [
		ParamsMiddleware::class
	]
];
