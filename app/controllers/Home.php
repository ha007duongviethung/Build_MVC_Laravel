<?php 

class Home extends Controller {
	public $province;
	public $data;

	public function __construct() {
		$this->province = $this->model('HomeModel');
	}

	public function index() {
		// $data = $this->province->all();

		// $data = $this->province->find(1127);
		// print_r($data);
		
		/* Query Builder */
		// $data = $this->province->getListStories();

		// $data = $this->province->getDetailStories(2000);
		// print_r($data);

		// $data = [
		// 	'account' => 'Tam Lon',
		// 	'password' => md5('$llmt03052001'),
		// 	'full_name' => 'Trương Thị Minh Tâm',
		// 	'age' => '20',
		// 	'gender' => '0',
		// 	'address' => 'Mỏ Ám, Đồng Tiến, Hữu Lũng, Lạng Sơn'
		// ];

		// $id = $this->province->insertUsers($data);
		// echo $id;

		// $data = [
		// 	'account' => 'Hero Hùng',
		// 	'update_at' => date('Y-m-d H:i:s')
		// ];

		// $this->province->updateUsers($data, 1);

		// $this->province->deleteUsers(1);

		// $data = $this->db->table('user')->insert($data);

		// $check = Session::data('username', [
		// 		'name' => 'Hero',
		// 		'email' => 'anhhungLeonard@gmail.com'
		// 	]);
		// var_dump($check);

		// Session::data('info', 'tamlon');

		// Session::delete();
		// $sessionData = Session::data();
		// print_r($sessionData);

		// Session::flash('msg', 'Success');
		// $msg = Session::flash('msg');
		// echo $msg;
	}

	public function get_user() {
		$this->data['msg'] = Session::flash('msg');
		$this->render('users/add', $this->data);
	}

	public function post_user() {
		$userId = 9;
		$request = new Request();
		// $email = $request->getFields()['email'];
		
		// $response = new Response();
		// // $response->redirect('home/get_user');
		// $response->redirect('http://vnexpress.net');

		if($request->isPost()) {
			/* Set rules */
			$request->rules([
				'fullname' => 'required|min:5|max:30|unique:user:full_name:id_user=' . $userId,
				'age' => 'required|callback_check_age',
				'email' => 'required|email|min:6',
				'password' => 'required|min:3',
				'comfirm_password' => 'required|match:password'
			]);

			/* Set message */
			$request->message([
				'fullname.required' => 'Full name cannot be blank',
				'fullname.min' => "Full name larger than 5 characters",
				'fullname.max' => "Full name less than 30 characters",
				'fullname.unique' => 'Full name already exists',
				'age.required' => 'Age password cannot be blank',
				'age.callback_check_age' => 'Age must be more than 20',
				'email.required' => 'Email cannot be blank',
				'email.email' => 'Invalid email',
				'email.min' => 'Email larger than 6 characters',
				'password.required' => 'Password cannot be blank',
				'password.min' => 'Password larger than 3 characters',
				'comfirm_password.required' => 'Comform password cannot be blank',
				'comfirm_password.match' => 'Password incorrect',
			]);

			$validate = $request->validate();

			if(!$validate) {
				Session::flash('msg', 'Errors has occurred. Please check again');
			}

		}

		$response = new Response();
		$response->redirect('home/get_user');
	}

	public function check_age($age) {
		if($age > 20) return true;
		return false;
	}
}