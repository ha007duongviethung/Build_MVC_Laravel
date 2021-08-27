<?php

/**
 * 
 */
class Controller
{
	public $db;

	public function model($model) {
		if(file_exists('./app/models/'.$model.'.php')) {
			require_once './app/models/'.$model.'.php';
			if(class_exists($model)) {
				$model = new $model();
				return $model;
			}
		}

		return false;
	}

	public function render($view, $data=[]) {
		if(!empty($data)) {
			extract($data); // doi key thanh bien
		}
		if(file_exists('./app/views/'.$view.'.php')) {
			require_once './app/views/'.$view.'.php';
		}
	}
}