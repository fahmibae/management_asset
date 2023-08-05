<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->has_userdata('status_login')) $this->redirectToLogin();
		if($this->session->userdata('status_login') != 'logon') $this->redirectToLogin();

		$this->load->model('Barang_Model', 'M_Barang');
	}


	public function redirectToLogin()
	{
		redirect('/');
		exit;
	}


	public function index()
	{
		$this->load->view('layouts', [
			'content'		=> 'barang/barang_index',
			'title'			=> 'Barang',
			'breadcrumbs'	=> [
				[
					'title'	=> 'Barang',
					'link'	=> base_url('Barang'),
				]
			]
		]);
	}


	public function detail($barangID)
	{
		$barang = $this->M_Barang->find($barangID);

		if(empty($barang)) redirect('Barang');

		$this->load->view('layouts', [
			'content'		=> 'barang/barang_detail',
			'title'			=> 'Detail Barang',
			'breadcrumbs'	=> [
				[
					'title'	=> 'Barang',
					'link'	=> base_url('Barang'),
				],
				[
					'title'	=> 'Detail',
					'link'	=> base_url('Barang/detail/'.$barangID),
				]
			],
			'barang'		=> $barang
		]);
	}


	public function rusak($barangID)
	{
		$barang = $this->M_Barang->find($barangID);

		if(empty($barang)) redirect('Barang');
		if($barang->kondisi != 'baik') redirect('Barang');

		$this->load->view('layouts', [
			'content'		=> 'barang/barang_rusak',
			'title'			=> 'Barang Rusak',
			'breadcrumbs'	=> [
				[
					'title'	=> 'Barang',
					'link'	=> base_url('Barang'),
				],
				[
					'title'	=> 'Barang Rusak',
					'link'	=> base_url('Barang/rusak/'.$barangID),
				]
			],
			'barang'		=> $barang
		]);
	}


	public function save_rusak($barangID)
	{
		$barang = $this->M_Barang->find($barangID);

		if($barang->kondisi != 'baik') {
			http_response_code(422);
			echo json_encode([
				'message'	=> 'Tidak dapat dilanjutkan. Harap reload laman.'
			]);
			exit;
		}

		$catatan = $this->input->post('catatan');

		$barang = $this->M_Barang->update($barangID, [
			'kondisi'	=> 'rusak',
			'catatan'	=> $catatan ?? null,
		]);

		echo json_encode([
			'message'	=> 'Berhasil'
		]);
	}


	public function pdf($kondisi = 'all')
	{
		$this->load->library('Pdf');
		if($kondisi == 'baik') {
			$barang = $this->M_Barang->getBarangBaikByRole();
			$kondisi = 'Kondisi Baik';
		} elseif ($kondisi == 'buruk') {
			$barang = $this->M_Barang->getBarangBurukByRole();
			$kondisi = 'Kondisi Buruk';
		} else {
			$barang = $this->M_Barang->allByRole();
			$kondisi = 'Semua Kondisi';
		}

		$html = $this->load->view('barang/barang_pdf', [
			'barang'	=> $barang,
			'kondisi'	=> $kondisi,
		], true);
		$this->pdf->createPDF($html, "Barang ({$kondisi})", false, 'A4', 'landscape');
	}
}
