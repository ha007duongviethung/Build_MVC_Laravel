<?php

/**
 * 
 */
class News extends Controller
{
	public $data = [];

	public function index() {
		$this->data['sub_content']['new_title'] = 'TamLon';
		$this->data['sub_content']['new_content'] = 'Fanpage TamLon';
		$this->data['sub_content']['new_auth'] = 'TamLonTV';
		$this->data['content'] = 'news/list';
		$this->render('layouts/client_layout', $this->data);
	}

	public function category($id) {
		echo "Tin tuc - " . $id;
	}
}