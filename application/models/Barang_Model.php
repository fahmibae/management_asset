<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_Model extends MY_Model {

	protected $table = 'barang';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Unit_Kerja_Model', 'M_Unit_Kerja');
	}


	public function generateNoBarang($kodeUnitKerja = '')
	{
		$prefix = $kodeUnitKerja;

		$this->db->like('no_barang', $prefix, 'after');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0) {
			$lastRecord = $query->row();
			$lastId = str_replace($prefix, '', $lastRecord->no_barang);
			$lastId = (int) $lastId;
			$id = $lastId + 1;
			$id = (string) $id;
			$noBarang = $prefix.str_repeat('0', 5 - strlen($id)).$id;
			return $noBarang;
		}

		return $prefix.'00001';
	}


	public function allByRole()
	{
		// if($this->session->userdata('user')->role == 'unit_kerja') {
		// 	return $this->getByWhere([
		// 		'id_unit_kerja'	=> $this->session->userdata('user')->id_unit_kerja,
		// 	]);
		// }

		return $this->all();
	}


	public function getBarangBaikByRole()
	{
		// if($this->session->userdata('user')->role == 'unit_kerja') {
		// 	return $this->getByWhere([
		// 		'id_unit_kerja'	=> $this->session->userdata('user')->id_unit_kerja,
		// 		'kondisi'	=> 'baik',
		// 	]);
		// }

		return $this->getByWhere([
			'kondisi'	=> 'baik',
		]);
	}


	public function getBarangBurukByRole()
	{
		// if($this->session->userdata('user')->role == 'unit_kerja') {
		// 	return $this->getByWhere([
		// 		'id_unit_kerja'	=> $this->session->userdata('user')->id_unit_kerja,
		// 		'kondisi'	=> 'buruk',
		// 	]);
		// }

		return $this->getByWhere([
			'kondisi'	=> 'buruk',
		]);
	}


	public function kondisiHtml($status)
	{
		if($status == 'baik') return '<span class="text-success"> Baik </span>';
		if($status == 'rusak') return '<span class="text-danger"> Rusak </span>';
	}


	public function getUnitKerja($barangID)
	{
		$barang = $this->find($barangID);
		if(empty($barang->id_unit_kerja)) return false;

		$unitKerja = $this->M_Unit_Kerja->find($barang->id_unit_kerja);
		return $unitKerja;
	}


	public function namaUnitKerja($barangID)
	{
		$unitKerja =  $this->getUnitKerja($barangID);

		return $unitKerja ? $unitKerja->nama_unit_kerja : '-';
	}


	public function kodeUnitKerja($barangID)
	{
		$unitKerja =  $this->getUnitKerja($barangID);

		return $unitKerja ? $unitKerja->kode_unit_kerja : '-';
	}


	public function jumlahBarangKondisiBaikByRole()
	{
		if($this->session->userdata('user')->role == 'unit_kerja')
		{
			$barang = $this->getByWhere([
				'id_unit_kerja'	=> $this->session->userdata('user')->id_unit_kerja,
				'kondisi'		=> 'baik'
			]);

			return count($barang);
		}
		else
		{
			$barang = $this->getByWhere([
				'kondisi'		=> 'baik'
			]);

			return count($barang);
		}
	}

}
