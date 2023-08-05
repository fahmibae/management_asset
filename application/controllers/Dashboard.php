<?php 


class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->has_userdata('status_login')) $this->redirectToLogin();
		if($this->session->userdata('status_login') != 'logon') $this->redirectToLogin();

		$this->load->model('Barang_Model', 'M_Barang');
		$this->load->model('User_Model', 'M_User');
		$this->load->model('Pengajuan_Model', 'M_Pengajuan');
	}


	public function redirectToLogin()
	{
		redirect('/');
		exit;
	}


	public function index()
	{
		$role = $this->session->userdata('user')->role;
		if($role == 'admin') $view = 'dashboard/admin';
		if($role == 'unit_kerja') $view = 'dashboard/unit_kerja';
		if($role == 'logistik') $view = 'dashboard/logistik';

		$this->load->view('layouts', [
			'content'		=> $view,
			'title'			=> 'Dashboard',
		]);
	}
}