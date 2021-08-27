<?php

/**
 * 
 */
class Dashboard
{
	public function index() {
		echo "Hello Dashboard";
	}

	public function detail($id) {
		echo 'Dashboard detail - ' . $id;
	}
}