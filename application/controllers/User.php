<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		if(!$this->session->has_userdata('status_login')) $this->redirectTo($target);
		if($this->session->userdata('status_login') != 'logon') $this->redirectTo($target);
		if($this->session->userdata('user')->role != 'admin') $this->redirectTo('Dashboard');

		$this->load->model('User_Model', 'M_User');
		$this->load->model('Unit_Kerja_Model', 'M_Unit_Kerja');
	}


	public function redirectTo($target = '/')
	{
		redirect($target);
		exit;
	}


	public function index()
	{
		$this->load->view('layouts', [
			'content'		=> 'user/user_index',
			'title'			=> 'User',
			'breadcrumbs'	=> [
				[
					'title'	=> 'User',
					'link'	=> base_url('User'),
				]
			]
		]);
	}


	public function create()
	{
		$this->load->view('layouts', [
			'content'		=> 'user/user_create',
			'title'			=> 'Tambah User',
			'breadcrumbs'	=> [
				[
					'title'	=> 'User',
					'link'	=> base_url('User'),
				],
				[
					'title'	=> 'Tambah',
					'link'	=> base_url('User/create'),
				]
			]
		]);
	}


	public function store()
	{
		$input = (object) $this->input->post();

		$user = $this->M_User->createUser([
			'nama_user'		=> $input->nama_user,
			'username'		=> $input->username,
			'password'		=> $input->password,
			'role'			=> $input->role,
			'id_unit_kerja'	=> $input->id_unit_kerja ?? null,
		]);

		echo json_encode([
			'message'	=> 'Berhasil disimpan',
		]);
	}


	public function edit($userID)
	{
		$user = $this->M_User->find($userID);

		if(empty($user)) redirect('User');

		$this->load->view('layouts', [
			'content'		=> 'user/user_edit',
			'title'			=> 'Edit User',
			'breadcrumbs'	=> [
				[
					'title'	=> 'User',
					'link'	=> base_url('User'),
				],
				[
					'title'	=> 'Edit',
					'link'	=> base_url('User/edit/'.$userID),
				]
			],
			'user'			=> $user
		]);
	}


	public function update($userID)
	{
		$input = (object) $this->input->post();

		$data = [
			'nama_user'		=> $input->nama_user,
			'username'		=> $input->username,
			'role'			=> $input->role,
			'id_unit_kerja'	=> $input->id_unit_kerja ?? null,
		];

		if(property_exists($input, 'password')) {
			$data['password'] = $input->password;
		}

		$user = $this->M_User->updateUser($userID, $data);

		echo json_encode([
			'message'	=> 'Berhasil diupdate',
		]);
	}


	public function delete($userID)
	{
		$input = (object) $this->input->post();

		$user = $this->M_User->deleteUser($userID);

		redirect('User');
	}
}
