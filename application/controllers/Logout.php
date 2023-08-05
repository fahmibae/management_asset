<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->has_userdata('status_login')) $this->redirectToLogin();
		if($this->session->userdata('status_login') != 'logon') $this->redirectToLogin();
	}


	public function redirectToLogin()
	{
		redirect('/');
		exit;
	}


	public function index()
	{
		$this->session->sess_destroy();
		$this->redirectToLogin();
	}
}