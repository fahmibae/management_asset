<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->has_userdata('status_login')) $this->redirectTo();
		if($this->session->userdata('status_login') != 'logon') $this->redirectTo();

		$this->load->model('Pengajuan_Model', 'M_Pengajuan');
		$this->load->model('User_Model', 'M_User');
	}


	public function redirectTo($target = '/')
	{
		redirect($target);
		exit;
	}


	public function index()
	{
		$this->load->view('layouts', [
			'content'		=> 'pengajuan/pengajuan_index',
			'title'			=> 'Pengajuan',
			'breadcrumbs'	=> [
				[
					'title'	=> 'Pengajuan',
					'link'	=> base_url('Pengajuan'),
				]
			]
		]);
	}


	public function create()
	{
		$this->load->view('layouts', [
			'content'		=> 'pengajuan/pengajuan_create',
			'title'			=> 'Tambah Pengajuan',
			'breadcrumbs'	=> [
				[
					'title'	=> 'Pengajuan',
					'link'	=> base_url('Pengajuan'),
				],
				[
					'title'	=> 'Tambah',
					'link'	=> base_url('Pengajuan/create'),
				]
			]
		]);
	}


	public function store()
	{
		$input = (object) $this->input->post();

		$pengajuan = $this->M_Pengajuan->createPengajuan([
			'tgl_pengajuan'	=> $input->tgl_pengajuan,
		], $input->details);

		echo json_encode([
			'message'	=> 'Berhasil disimpan',
		]);
	}


	public function edit($pengajuanID)
	{
		$pengajuan = $this->M_Pengajuan->find($pengajuanID);

		if($this->session->userdata('user')->id_unit_kerja != $pengajuan->id_unit_kerja) $this->redirectTo('Dashboard');

		if(empty($pengajuan)) redirect('Pengajuan');

		$this->load->view('layouts', [
			'content'		=> 'pengajuan/pengajuan_edit',
			'title'			=> 'Edit Pengajuan',
			'breadcrumbs'	=> [
				[
					'title'	=> 'Pengajuan',
					'link'	=> base_url('Pengajuan'),
				],
				[
					'title'	=> 'Edit',
					'link'	=> base_url('Pengajuan/edit/'.$pengajuanID),
				]
			],
			'pengajuan'		=> $pengajuan
		]);
	}


	public function update($pengajuanID)
	{
		$pengajuan = $this->M_Pengajuan->find($pengajuanID);

		if($this->session->userdata('user')->id_unit_kerja != $pengajuan->id_unit_kerja) $this->redirectTo('Dashboard');

		$input = (object) $this->input->post();

		$pengajuan = $this->M_Pengajuan->updatePengajuan($pengajuanID, [
			'tgl_pengajuan'	=> $input->tgl_pengajuan,
		], $input->details);

		echo json_encode([
			'message'	=> 'Berhasil diupdate',
		]);
	}


	public function delete($pengajuanID)
	{
		$pengajuan = $this->M_Pengajuan->find($pengajuanID);

		if($this->session->userdata('user')->id_unit_kerja != $pengajuan->id_unit_kerja) $this->redirectTo('Dashboard');

		$input = (object) $this->input->post();

		$this->M_Pengajuan->deletePengajuan($pengajuanID);

		redirect('Pengajuan');
	}


	public function penyetujuan($pengajuanID)
	{
		if($this->session->userdata('user')->role != 'admin') $this->redirectTo('Dashboard');

		$pengajuan = $this->M_Pengajuan->find($pengajuanID);

		if(empty($pengajuan)) redirect('Pengajuan');
		if($pengajuan->status != 'menunggu') redirect('Pengajuan');

		$this->load->view('layouts', [
			'content'		=> 'pengajuan/pengajuan_penyetujuan',
			'title'			=> 'Penyetujuan Pengajuan',
			'breadcrumbs'	=> [
				[
					'title'	=> 'Pengajuan',
					'link'	=> base_url('Pengajuan'),
				],
				[
					'title'	=> 'Penyetujuan',
					'link'	=> base_url('Pengajuan/penyetujuan/'.$pengajuanID),
				]
			],
			'pengajuan'		=> $pengajuan
		]);
	}


	public function save_penyetujuan($pengajuanID)
	{
		if($this->session->userdata('user')->role != 'admin') $this->redirectTo('Dashboard');

		$pengajuan = $this->M_Pengajuan->find($pengajuanID);

		if($pengajuan->status != 'menunggu') {
			http_response_code(422);
			echo json_encode([
				'message'	=> 'Tidak dapat dilanjutkan. Harap reload laman.'
			]);
			exit;
		}

		$input = (object) $this->input->post();
		$this->M_Pengajuan->penyetujuan($pengajuanID, $input->details);

		echo json_encode([
			'message'	=> 'Berhasil',
		]);
	}


	public function detail($pengajuanID)
	{
		$pengajuan = $this->M_Pengajuan->find($pengajuanID);

		if(empty($pengajuan)) redirect('Pengajuan');

		$this->load->view('layouts', [
			'content'		=> 'pengajuan/pengajuan_detail',
			'title'			=> 'Detail Pengajuan',
			'breadcrumbs'	=> [
				[
					'title'	=> 'Pengajuan',
					'link'	=> base_url('Pengajuan'),
				],
				[
					'title'	=> 'Detail',
					'link'	=> base_url('Pengajuan/detail/'.$pengajuanID),
				]
			],
			'pengajuan'		=> $pengajuan
		]);
	}


	public function penerimaan($pengajuanID)
	{
		if($this->session->userdata('user')->role != 'logistik') $this->redirectTo('Dashboard');

		$pengajuan = $this->M_Pengajuan->find($pengajuanID);

		if(empty($pengajuan)) redirect('Pengajuan');
		if($pengajuan->status != 'disetujui') redirect('Pengajuan');

		$this->load->view('layouts', [
			'content'		=> 'pengajuan/pengajuan_penerimaan',
			'title'			=> 'Penerimaan Pengajuan',
			'breadcrumbs'	=> [
				[
					'title'	=> 'Pengajuan',
					'link'	=> base_url('Pengajuan'),
				],
				[
					'title'	=> 'Penerimaan',
					'link'	=> base_url('Pengajuan/penerimaan/'.$pengajuanID),
				]
			],
			'pengajuan'		=> $pengajuan
		]);
	}


	public function save_penerimaan($pengajuanID)
	{
		if($this->session->userdata('user')->role != 'logistik') $this->redirectTo('Dashboard');

		$pengajuan = $this->M_Pengajuan->find($pengajuanID);

		if($pengajuan->status != 'disetujui') {
			http_response_code(422);
			echo json_encode([
				'message'	=> 'Tidak dapat dilanjutkan. Harap reload laman.'
			]);
			exit;
		}

		$result = $this->M_Pengajuan->penerimaan($pengajuanID);

		echo json_encode([
			'message'	=> 'Berhasil',
		]);
	}

}