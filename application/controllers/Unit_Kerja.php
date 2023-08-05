<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_Kerja extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		if(!$this->session->has_userdata('status_login')) $this->redirectTo();
		if($this->session->userdata('status_login') != 'logon') $this->redirectTo();
		if($this->session->userdata('user')->role != 'admin') $this->redirectTo('Dashboard');

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
			'content'		=> 'unit_kerja/unit_kerja_index',
			'title'			=> 'Unit Kerja',
			'breadcrumbs'	=> [
				[
					'title'	=> 'Unit Kerja',
					'link'	=> base_url('Unit_Kerja'),
				]
			]
		]);
	}


	public function create()
	{
		$this->load->view('layouts', [
			'content'		=> 'unit_kerja/unit_kerja_create',
			'title'			=> 'Tambah Unit Kerja',
			'breadcrumbs'	=> [
				[
					'title'	=> 'Unit Kerja',
					'link'	=> base_url('Unit_Kerja'),
				],
				[
					'title'	=> 'Tambah',
					'link'	=> base_url('Unit_Kerja/create'),
				]
			]
		]);
	}


	public function store()
	{
		$input = (object) $this->input->post();

		$unitKerja = $this->M_Unit_Kerja->createUnitKerja([
			'nama_unit_kerja'	=> $input->nama_unit_kerja,
			'kode_unit_kerja'	=> $input->kode_unit_kerja,
		]);

		echo json_encode([
			'message'	=> 'Berhasil disimpan',
		]);
	}


	public function edit($unitKerjaID)
	{
		$unitKerja = $this->M_Unit_Kerja->find($unitKerjaID);

		if(empty($unitKerja)) redirect('Unit_Kerja');

		$this->load->view('layouts', [
			'content'		=> 'unit_kerja/unit_kerja_edit',
			'title'			=> 'Edit Unit Kerja',
			'breadcrumbs'	=> [
				[
					'title'	=> 'Unit Kerja',
					'link'	=> base_url('Unit_Kerja'),
				],
				[
					'title'	=> 'Edit',
					'link'	=> base_url('Unit_Kerja/edit/'.$unitKerjaID),
				]
			],
			'unitKerja'		=> $unitKerja
		]);
	}


	public function update($unitKerjaID)
	{
		$input = (object) $this->input->post();

		$unitKerja = $this->M_Unit_Kerja->updateUnitKerja($unitKerjaID, [
			'nama_unit_kerja'	=> $input->nama_unit_kerja,
			'kode_unit_kerja'	=> $input->kode_unit_kerja,
		]);

		echo json_encode([
			'message'	=> 'Berhasil diupdate',
		]);
	}


	public function delete($unitKerjaID)
	{
		$input = (object) $this->input->post();

		$unitKerja = $this->M_Unit_Kerja->deleteUnitKerja($unitKerjaID);

		redirect('Unit_Kerja');
	}
}