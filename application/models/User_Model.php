<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends MY_Model {

	protected $table = 'user';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Unit_Kerja_Model', 'M_Unit_Kerja');
	}


	public function createUser($data)
	{
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

		$user = $this->create($data);

		return $user;
	}


	public function updateUser($id, $data)
	{
		if(array_key_exists('password', $data)) {
			if($data['password'] != '') {
				$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
			} else {
				unset($data['password']);
			}
		}

		$user = $this->update($id, $data);

		return $user;
	}


	public function deleteUser($id)
	{
		return $this->delete($id);
	}


	public function verifyLogin($username, $password)
	{
		$user = $this->getRowByWhere([
			'username'	=> $username,
		]);

		if(empty($user)) return false;

		return password_verify($password, $user->password);
	}


	public function verifyOldPassword($oldPassword)
	{
		$username = $this->session->userdata('user')->username;
		return $this->verifyLogin($username, $oldPassword);
	}


	public function changePassword($newPassword)
	{
		$id = $this->session->userdata('user')->id;
		return $this->update($id, [
			'password'	=> password_hash($newPassword, PASSWORD_DEFAULT),
		]);
	}


	public function getRowByUsername($username)
	{
		$user = $this->getRowByWhere([
			'username'	=> $username,
		]);

		return $user;
	}


	public function getUnitKerja($userID)
	{
		$user = $this->find($userID);
		if(empty($user->id_unit_kerja)) return false;

		$unitKerja = $this->M_Unit_Kerja->find($user->id_unit_kerja);
		return $unitKerja;
	}


	public function kodeUnitKerja($userID)
	{
		$unitKerja =  $this->getUnitKerja($userID);

		return $unitKerja ? $unitKerja->kode_unit_kerja : '-';
	}


	public function namaUnitKerja($userID)
	{
		$unitKerja =  $this->getUnitKerja($userID);

		return $unitKerja ? $unitKerja->nama_unit_kerja : '-';
	}


	public function namaRole($role)
	{
		if($role == 'admin') return 'Administrator';
		if($role == 'logistik') return 'Logistik';
		if($role == 'unit_kerja') return 'Unit Kerja';
		return '-';
	}


	public function authUnitKerja()
	{
		return $this->getUnitKerja($this->session->userdata('user')->id);
	}


	public function authIDUnitKerja()
	{
		$unitKerja = $this->authUnitKerja();
		return $unitKerja ? $unitKerja->id : '';
	}


	public function authKodeUnitKerja()
	{
		$unitKerja = $this->authUnitKerja();
		return $unitKerja ? $unitKerja->kode_unit_kerja : '';
	}


	public function authNamaUnitKerja()
	{
		$unitKerja = $this->authUnitKerja();
		return $unitKerja ? $unitKerja->nama_unit_kerja : '';
	}

}
