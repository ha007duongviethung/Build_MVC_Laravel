<?php 

/**
 * 
 */
class App
{
	private $__controller;
	private $__action;
	private $__params;
	private $__route;
	private $__db;

	public static $app;
	
	function __construct()
	{
		global $routes;
		global $config;

		self::$app = $this;

		$this->__route = new Route();

		if(!empty($routes['default_controller'])) {
		$this->__controller = $routes['default_controller'];
		}
		$this->__action = 'index';
		$this->__params = [];

		if(class_exists('DB')) {
			$dbObject = new DB();
			$this->__db = $dbObject->db;
		}

		$this->handleUrl();
	}

	function getUrl() {
		if(!empty($_SERVER['PATH_INFO'])) {
			$url = $_SERVER['PATH_INFO'];
		} else {
			$url = '/';
		}

		return $url;
	}

	public function handleUrl() {
		$url = $this->getUrl();

		$url = $this->__route->handleRoute($url);

		// Middleware app
		$this->handleGlobalMiddleware();
		$this->handleRouteMiddleware($this->__route->getUri());

		$urlArr = array_filter(explode('/', $url));
		$urlArr = array_values($urlArr);

		$urlCheck = '';
		if(!empty($urlArr)) {
			foreach ($urlArr as $key => $item) {
				$urlCheck .= ucfirst($item).'/';
				$fileCheck = rtrim($urlCheck, '/');

				if(!empty($urlArr[$key-1])) {
					unset($urlArr[$key-1]);
				}

				if(file_exists('./app/controllers/'.$fileCheck.'.php')) {
					$urlCheck = $fileCheck;
					break;
				} else {
					$urlCheck = strtolower($urlCheck);
				};
			}

			$urlArr = array_values($urlArr);
		}
		
		// Xu ly controller
		if(!empty($urlArr[0])) {
			$this->__controller = ucfirst($urlArr[0]);
			unset($urlArr[0]);
		} else {
			$this->__controller = ucfirst($this->__controller);
		}

		// Xu khi khi url rong
		if(empty($urlCheck)) {
			$urlCheck = $this->__controller;
		}

		if(file_exists('./app/controllers/'.$urlCheck.'.php')) {
			require_once './app/controllers/'.$urlCheck.'.php';

			// Kiem tra class ton tai
			if(class_exists($this->__controller)) {
				$this->__controller = new $this->__controller();

				if(!empty($this->__db)) {
					$this->__controller->db = $this->__db;
				}
			} else {
				$this->loadError();
			}
		} else {
			$this->loadError();
		}

		// Xu ly action
		if(!empty($urlArr[1])) {
			$this->__action = $urlArr[1];
			unset($urlArr[1]);
		}

		// Xu ly params
		$this->__params = array_values($urlArr);

		// Kiem tra method ton tai
		if(method_exists($this->__controller, $this->__action)) {
			call_user_func_array([$this->__controller, $this->__action], $this->__params);
		} else {
			$this->loadError();
		}

	}

	public function getCurrentController() {
		return $this->__controller;
	}

	public function loadError($name = '404', $data = []) {
		extract($data);
		require_once './app/errors/'.$name.'.php';
	}

	public function handleRouteMiddleware($routeKey) {
		global $config;
		$routeKey = trim($routeKey);
		if(!empty($config['app']['routeMiddleware'])) {
			$routeMiddlewareArr = $config['app']['routeMiddleware'];
			foreach ($routeMiddlewareArr as $key => $middlewareItem) {
				if($routeKey == trim($key) && file_exists('app/middlewares/'.$middlewareItem.'.php')) {
					require_once 'app/middlewares/'.$middlewareItem.'.php';
					if(class_exists($middlewareItem)) {
						$middlewareObject = new $middlewareItem();
						$middlewareObject->handle();
					}
				}
			}
		}
	}

	public function handleGlobalMiddleware() {
		global $config;

		if(!empty($config['app']['globalMiddleware'])) {
			$globalMiddlewareArr = $config['app']['globalMiddleware'];
			foreach ($globalMiddlewareArr as $key => $middlewareItem) {
				if(file_exists('app/middlewares/'.$middlewareItem.'.php')) {
					require_once 'app/middlewares/'.$middlewareItem.'.php';
					if(class_exists($middlewareItem)) {
						$middlewareObject = new $middlewareItem();
						$middlewareObject->handle();
					}
				}
			}
		}
	}
}