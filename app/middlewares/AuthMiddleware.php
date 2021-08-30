<?php 
/**
 * 
 */
class AuthMiddleware extends Middlewares
{
	public function handle() {
		$homeModel = Load::model('HomeModel');
		// $data = $homeModel->all();
		// print_r($data);
		
		if(Session::data('admin_login') == null) {
			$response = new Response();
			// $response->redirect('trang-chu');
		}
	}
}