<?php 

define('_DIR_ROOT', str_replace('\\', '/', __DIR__));

// Xu ly http root
if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
	$web_root = 'https://' . $_SERVER['HTTP_HOST'];
} else {
	$web_root = 'http://' . $_SERVER['HTTP_HOST'];
}

$folder = str_replace(strtolower(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'])), '', strtolower(str_replace('\\', '/', _DIR_ROOT)));

$web_root = $web_root.$folder;

define('_WEB_ROOT', $web_root);


/*
* Tu dong load configs
*/
$configs_dir = scandir('configs');
if(!empty($configs_dir)) {
	foreach ($configs_dir as $key => $item) {
		if($item != '.' && $item != '..' && file_exists('configs/'.$item)) {
			require_once 'configs/'.$item;
		}
	}
}

// Load all service
if(!empty($config['app']['service'])) {
	$allServices = $config['app']['service'];
	if(!empty($allServices)) {
		foreach($allServices as $serviceName) {
			if(file_exists('app/core/'.$serviceName.'.php')) {
				require_once 'app/core/'.$serviceName.'.php';
			}
		}
	}
}

// Load Service Provider Class
require_once 'core/ServiceProvider.php';

// Load View Class
require_once 'core/View.php';

// Load
require_once 'core/Load.php';

// Middleware
require_once 'core/MiddleWares.php';

require_once 'core/Route.php'; // load route
require_once 'core/Session.php'; // load sesion 

// Kiem tra config va load database
if(!empty($config['database'])) {
	$db_config = array_filter($config['database']);

	if(!empty($db_config)) {
		require_once 'core/Connection.php';
		require_once 'core/QueryBuilder.php';
		require_once 'core/Database.php';
		require_once 'core/DB.php';
	}
}

// Load core helper
require_once './core/Helper.php';

// Load all helpers
$allHelper = scandir('app/helpers');
if(!empty($allHelper)) {
	foreach ($allHelper as $key => $item) {
		if($item != '.' && $item != '..' && file_exists('app/helpers/'.$item)) {
			require_once 'app/helpers/'.$item;
		}
	}
}

require_once './app/app.php'; // Load app

require_once './core/Model.php'; // Load base model
require_once './core/Template.php'; // Load Template
require_once './core/Controller.php'; // Load base controller
require_once './core/Request.php'; // Load request
require_once './core/Response.php'; // Load response