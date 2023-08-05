<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_Model', 'M_User');
		if($this->session->has_userdata('status_login')) {
			if($this->session->userdata('status_login') == 'logon') {
				redirect('Dashboard');
			}
		}
	}


	public function index()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if(empty($username) || empty($password)) {
			$this->load->view('login');
		} else {
			$result = $this->M_User->verifyLogin($username, $password);

			if($result) {
				$user = $this->M_User->getRowByUsername($username);
				$this->session->set_userdata([
					'status_login'	=> 'logon',
					'user'			=> $user,
				]);

				http_response_code(200);
				echo json_encode([
					'message'	=> 'Login berhasil'
				]);
			} else {
				http_response_code(422);
				echo json_encode([
					'message'	=> 'Username/Password salah'
				]);
			}
		}
	}
}
