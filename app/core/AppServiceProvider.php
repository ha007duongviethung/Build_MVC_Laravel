<?php

/**
 * 
 */
class AppServiceProvider extends ServiceProvider
{
	public function boot() {
		$dataUser = $this->db->table('user')->where('id_user', '=', 9)->first();

		$data['userInfo'] = $dataUser;
		$data['copyright'] = 'Copyright &copy; 2021 by Heroes Pluss';

		View::share($data);
	}
}