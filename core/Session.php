<?php 

/**
 * 
 */
class Session
{
	/*
	* data(key, value) => setSession
	* data(key) => getSession
	*/
	public static function data($key='', $value='') {
		$sessionKey = self::isInvalid();
		if(!empty($value)) {
			if(!empty($key)) {
				$_SESSION[$sessionKey][$key] = $value; // set session
				return true;
			}

			return false;
		} else {
			if(empty($key)) {
				if(isset($_SESSION[$sessionKey])) {
					return $_SESSION[$sessionKey];
				}
			} else {
				if(isset($_SESSION[$sessionKey][$key])) {
					return $_SESSION[$sessionKey][$key]; // get session
				}
			}
		}
	}

	/*
	* delete(key) => xoa session voi key
	* delete() => xoa het session
	*/
	public static function delete($key='') {
		$sessionKey = self::isInvalid();
		if(!empty($key)) {
			if(isset($_SESSION[$sessionKey][$key])) {
				unset($_SESSION[$sessionKey][$key]);
				return true;
			} else {
				return false;
			}
		} else {
			unset($_SESSION[$sessionKey]);
			return true;
		}
	}

	/*
	* flash data
	* - set flash data as set session
	* - get flash data as get session + delete session
	*/

	public static function flash($key='', $value='') {
		$dataFlash = self::data($key, $value);
		if(empty($value)) {
			self::delete($key);
		}

		return $dataFlash;
	}

	public static function showErrors($message) {
		$data = ['message' => $message];
		App::$app->loadError('exception', $data);
		die();
	}

	public static function isInvalid() {
		global $config;

		if(!empty($config['session'])) {
			$sessionConfig = $config['session'];
			if(!empty($sessionConfig['session_key'])) {
				$sessionKey = $sessionConfig['session_key'];
				return $sessionKey;
			} else {
				self::showErrors('Thiếu cấu hình session. Vui lòng kiểm tra file: configs/session.php');
			}
		} else {
			self::showErrors('Thiếu cấu hình session. Vui lòng kiểm tra file: configs/session.php');
		}
	}
}