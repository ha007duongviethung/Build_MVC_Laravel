<?php 

/**
 * 
 */
class Load
{
	public static function model($model) {
		if(file_exists('./app/models/'.$model.'.php')) {
			require_once './app/models/'.$model.'.php';
			if(class_exists($model)) {
				$model = new $model();
				return $model;
			}
		}

		return false;
	}

	public static function view($view, $data = []) {
		if(!empty($data)) {
			extract($data); // doi key thanh bien
		}
		if(file_exists('./app/views/'.$view.'.php')) {
			require_once './app/views/'.$view.'.php';
		}
	}
}	