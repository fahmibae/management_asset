<?php 

class Setting extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->has_userdata('status_login')) $this->redirectTo();
		if($this->session->userdata('status_login') != 'logon') $this->redirectTo();
		$this->load->model('User_Model', 'M_User');
	}
	


	public function redirectTo($target = '/')
	{
		redirect($target);
		exit;
	}


	public function index()
	{
		redirect('Setting/ganti_password');
	}


	public function ganti_password()
	{
		$password_lama = $this->input->post('password_lama');
		$password_baru = $this->input->post('password_baru');

		if(empty($password_lama) || empty($password_baru))
		{
			$this->load->view('layouts', [
				'content'		=> 'setting/ganti_password',
				'title'			=> 'Ganti Password',
				'breadcrumbs'	=> [
					[
						'title'	=> 'Ganti Password',
						'link'	=> base_url('Setting/ganti_password'),
					]
				]
			]);
		}
		else
		{
			if($this->M_User->verifyOldPassword($password_lama))
			{
				$this->M_User->changePassword($password_baru);
				echo json_encode([
					'message'	=> 'Berhasil',
				]);
				exit;
			}
			else
			{
				http_response_code(422);
				echo json_encode([
					'message'	=> 'Password lama salah',
					'errors'	=> [
						'password_lama'	=> 'Password lama salah',
					]
				]);
				exit;
			}
		}
	}

}