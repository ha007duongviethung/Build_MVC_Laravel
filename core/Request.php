<?php

/**
 * 
 */
class Request
{
	private $__rules = [];
	private $__message = [];
	private $__errors = [];
	public $db;

	public function __construct() {
		$this->db = new Database();
	}

	public function getMethod() {
		return strtolower($_SERVER['REQUEST_METHOD']);
	}

	public function isGet() {
		if($this->getMethod() == 'get') {
			return true;
		}
		return false;
	}

	public function isPost() {
		if($this->getMethod() == 'post') {
			return true;
		}
		return false;
	}

	public function getFields() {
		$dataFields = [];

		if($this->isGet()) {
			if(!empty($_GET)) {
				foreach ($_GET as $key => $value) {
					if(is_array($value))
					{
						$dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
					} else {
						$dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);					
					}
				}
			}
		}

		if($this->isPost()) {
			if(!empty($_POST)) {
				foreach ($_POST as $key => $value) {
					if(is_array($value)) {
						$dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
					} else {
						$dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
					}
				}
			}
		}

		return $dataFields;
	}

	// set rules
	public function rules($rules=[]) {
		$this->__rules = $rules;
	}

	// set message
	public function message($message=[]) {
		$this->__message = $message;
	}

	// run validate
	public function validate() {

		$this->__rules = array_filter($this->__rules);

		$checkValidate = true;

		if(!empty($this->__rules)) {
			$dataFields = $this->getFields();

			foreach ($this->__rules as $fieldName => $ruleItem) {
				$rulesItemArr = explode('|', $ruleItem);

				foreach ($rulesItemArr as $rule) {

					$rulesArr = explode(':', $rule);
					$ruleValue = null;

					$ruleName = reset($rulesArr);

					if(count($rulesArr) > 1) {
						$ruleValue = end($rulesArr);
					}

					if($ruleName == 'required') {
						if(empty(trim($dataFields[$fieldName]))) {
							$this->setErrors($fieldName, $ruleName);
							$checkValidate = false;
						}
					}

					if($ruleName == 'min') {
						if(strlen(trim($dataFields[$fieldName])) <= $ruleValue) {
							$this->setErrors($fieldName, $ruleName);
							$checkValidate = false;
						}
					}

					if($ruleName == 'max') {
						if(strlen(trim($dataFields[$fieldName])) >= $ruleValue) {
							$this->setErrors($fieldName, $ruleName);
							$checkValidate = false;
						}
					}

					if($ruleName == 'email') {
						if(!filter_var($dataFields[$fieldName], FILTER_VALIDATE_EMAIL)) {
							$this->setErrors($fieldName, $ruleName);
							$checkValidate = false;
						}
					}

					if($ruleName == 'match') {
						if(trim($dataFields[$fieldName]) != trim($dataFields[$ruleValue])) {
							$this->setErrors($fieldName, $ruleName);
							$checkValidate = false;
						}
					}

					if($ruleName  == 'unique') {
						$tableName = null;
						$fieldCheck = null;
						if(!empty($rulesArr[1])) {
							$tableName = $rulesArr[1];
						}

						if(!empty($rulesArr[2])) {
							$fieldCheck = $rulesArr[2];
						}

						if(!empty($tableName) && !empty($fieldCheck)) {
							$dataFields[$fieldName] = trim($dataFields[$fieldName]);

							if(count($rulesArr) == 3) {
								$checkExist = $this->db->query("SELECT $fieldCheck FROM $tableName WHERE $fieldCheck = '$dataFields[$fieldName]'")->rowCount();
							} elseif(count($rulesArr) == 4) {
								if(!empty($rulesArr[3]) && preg_match('~.+?\=.+?~is', $rulesArr[3]))
								$conditionWhere = $rulesArr[3];
								$conditionWhere = str_replace('=', '<>', $conditionWhere);
								$checkExist = $this->db->query("SELECT $fieldCheck FROM $tableName WHERE $fieldCheck = '$dataFields[$fieldName]' AND $conditionWhere")->rowCount();
							}
								if(!empty($checkExist)) {
									$this->setErrors($fieldName, $ruleName);
									$checkValidate = false;
								}
						}
					}

					// callback validate
					if(preg_match('~^callback_(.+)~is', $ruleName, $callbackArr)) {
						if(!empty($callbackArr[1])) {
							$callbackName = $callbackArr[1];
							$controller = App::$app->getCurrentController();

							if(method_exists($controller, $callbackName)) {
								$checkCallback = call_user_func_array([$controller, $callbackName], [trim($dataFields[$fieldName])]);
								if(!$checkCallback) {
									$this->setErrors($fieldName, $ruleName);
									$checkValidate = false;
								}
							}
						}
					}
				}
			}
		}

		$sessionKey = Session::isInValid();
		Session::flash($sessionKey.'_errors', $this->errors());
		Session::flash($sessionKey.'_old', $this->getFields());

		return $checkValidate;
	}

	// get errors
	public function errors($fieldName='') {
		if(!empty($this->__errors)) {
			if(empty($fieldName)) {
				$errorsArr = [];
				foreach ($this->__errors as $key => $error) {
					$errorsArr[$key] = reset($error);
				}
				return $errorsArr;
			}

			return reset($this->__errors[$fieldName]);
		}

		return false;
	}

	// set errors
	public function setErrors($fieldName, $ruleName) {
		$this->__errors[$fieldName][$ruleName] = $this->__message[$fieldName. '.' . $ruleName];
	}
}
