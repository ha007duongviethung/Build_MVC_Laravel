<?php 

/**
 * 
 */
class Connection
{
	private static $instance = null;
	private static $connect = null;

	private function __construct($config) {


		// Ket noi database
		try {			
			// Cau hinh dsn
			$dsn = 'mysql:dbname='.$config['db'].';host='.$config['host'];

			// Cau hinh $options
			/*
			* Cau hinh utf8
			* Cau hinh ngoai le khi try van loi
			*/

			$options = [
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			];

			// Cau lenh ket noi
			$conn = new PDO($dsn, $config['user'], $config['pass'], $options);

			self::$connect = $conn;

		} catch (Exception $e) {
			$mess = $e->getMessage();
			$data['message'] = $mess;
			App::$app->loadError('database', $data);
			die();
		}
	}

	public static function getInstance($config) {
		if(self::$instance == null) {
			$connection = new Connection($config);
			self::$instance = self::$connect;
		}
		return self::$instance;
	}
}