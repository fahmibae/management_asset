<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan_Model extends MY_Model {

	protected $table = 'pengajuan';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Unit_Kerja_Model', 'M_Unit_Kerja');
		$this->load->model('User_Model', 'M_User');
		$this->load->model('Pengajuan_Detail_Model', 'M_Pengajuan_Detail');
		$this->load->model('Barang_Model', 'M_Barang');
	}


	public function createPengajuan($data, $details)
	{
		$kodeUnitKerja = $this->M_User->authKodeUnitKerja();
		$data['id_user'] = $this->session->userdata('user')->id;
		$data['id_unit_kerja'] = $this->M_User->authIDUnitKerja();
		$data['status'] = 'menunggu';
		$data['no_pengajuan'] = $this->generateNoPengajuan($kodeUnitKerja);
		$pengajuan = $this->create($data);

		$this->createPengajuanDetails($pengajuan, $details);
		
		return $pengajuan;
	}


	public function updatePengajuan($pengajuanID, $data, $details)
	{
		$data['id_user'] = $this->session->userdata('user')->id;
		$pengajuan = $this->update($pengajuanID, $data);

		$this->clearPengajuanDetails($pengajuanID);
		$this->createPengajuanDetails($pengajuan, $details);
		
		return $pengajuan;
	}


	public function deletePengajuan($pengajuanID)
	{
		$this->clearPengajuanDetails($pengajuanID);
		$this->delete($pengajuanID);
	}


	public function createPengajuanDetails($pengajuan, $details)
	{
		$namaBarangs = $details['nama_barang'];
		$qtys = $details['qty'];
		$i = 0;
		// $noBarangs = $details['noBarang'];
		// $kode = $this->kodeUnitKerja($pengajuan->id);

		foreach($namaBarangs as $namaBarang)
		{
			// $createNew = false;
			// if($noBarang != 'NEW') {
			// 	$pengajuanDetail = $this->M_Pengajuan_Detail->
				
			// } else {
			// 	$createNew = true;
			// }

			// if($createNew) {
			// 	// $noBarang = $this->M_Pengajuan_Detail->generateNoBarang($kode);
				
			// }
			$this->M_Pengajuan_Detail->create([
				'id_pengajuan'	=> $pengajuan->id,
				'nama_barang'	=> $namaBarang,
				'qty'			=> $qtys[$i],
				'status'		=> 'menunggu',
			]);
			$i++;
		}
	}


	public function clearPengajuanDetails($pengajuanID)
	{
		foreach($this->pengajuanDetails($pengajuanID) as $detail) {
			$this->M_Pengajuan_Detail->delete($detail->id);
		}
	}


	public function getUnitKerja($pengajuanID)
	{
		$pengajuan = $this->find($pengajuanID);
		if(empty($pengajuan->id_unit_kerja)) return false;

		$unitKerja = $this->M_Unit_Kerja->find($pengajuan->id_unit_kerja);
		return $unitKerja;
	}


	public function namaUnitKerja($pengajuanID)
	{
		$unitKerja =  $this->getUnitKerja($pengajuanID);

		return $unitKerja ? $unitKerja->nama_unit_kerja : '-';
	}


	public function kodeUnitKerja($pengajuanID)
	{
		$unitKerja =  $this->getUnitKerja($pengajuanID);

		return $unitKerja ? $unitKerja->kode_unit_kerja : '-';
	}


	public function pengajuanDetails($pengajuanID)
	{
		$details = $this->M_Pengajuan_Detail->getByWhere([ 'id_pengajuan' => $pengajuanID ]);

		return $details;
	}


	public function generateNoPengajuan($kodeUnitKerja = '')
	{
		$prefix = 'P-'.$kodeUnitKerja;

		$this->db->like('no_pengajuan', $prefix, 'after');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0) {
			$lastRecord = $query->row();
			$lastId = str_replace($prefix, '', $lastRecord->no_pengajuan);
			$lastId = (int) $lastId;
			$id = $lastId + 1;
			$id = (string) $id;
			$noPengajuan = $prefix.str_repeat('0', 5 - strlen($id)).$id;
			return $noPengajuan;
		}

		return $prefix.'00001';
	}


	public function getUser($pengajuanID)
	{
		$pengajuan = $this->find($pengajuanID);
		if(empty($pengajuan->id_user)) return false;

		$user = $this->M_User->find($pengajuan->id_user);
		return $user;
	}


	public function namaUser($pengajuanID)
	{
		$user = $this->getUser($pengajuanID);

		return $user ? $user->nama_user : '-';
	}


	public function penyetujuan($pengajuanID, $details)
	{
		$pengajuanDetails = $this->pengajuanDetails($pengajuanID);
		$setuju = array_key_exists('setuju', $details) ? $details['setuju'] : [];
		$catatan = $details['catatan'];
		$i = 0;

		foreach($pengajuanDetails as $detail)
		{
			$status = 'ditolak';
			if(in_array($detail->id, $setuju)) {
				$status = 'disetujui';
			}

			$this->M_Pengajuan_Detail->update($detail->id, [
				'catatan'	=> $catatan[$i] ?? null,
				'status'	=> $status,
			]);
			$i++;
		}

		$status = 'ditolak';
		if(count($setuju) > 0) {
			$status = 'disetujui';
		}

		$pengajuan = $this->update($pengajuanID, [
			'status'	=> $status
		]);

		return $pengajuan;
	}


	public function statusHtml($status)
	{
		if($status == 'menunggu') return '<span class="text-primary"> Menunggu </span>';
		if($status == 'disetujui') return '<span class="text-success"> Disetujui </span>';
		if($status == 'ditolak') return '<span class="text-danger"> Ditolak </span>';
		if($status == 'diterima') return '<span class="text-info"> Diterima </span>';
	}


	public function allByRole()
	{
		if($this->session->userdata('user')->role == 'unit_kerja') {
			return $this->getByWhere([
				'id_unit_kerja'	=> $this->session->userdata('user')->id_unit_kerja,
			]);
		}

		return $this->all();
	}


	public function penerimaan($pengajuanID)
	{
		$pengajuan = $this->find($pengajuanID);

		$config['upload_path']	= './uploads/';
		$config['file_name'] = $pengajuan->no_pengajuan;
		$config['allowed_types'] = '*';
		$config['overwrite'] = true;

		$this->load->library('upload', $config);

		if($this->upload->do_upload('tanda_terima'))
		{
			$data = $this->upload->data();
			$filename = $data['file_name'];
			$this->update($pengajuanID, [
				'tanda_terima'	=> $filename,
			]);
		}

		$this->update($pengajuanID, [
			'status'	=> 'diterima'
		]);
		$this->terimaDetails($pengajuanID);

		return $pengajuan;
	}


	public function terimaDetails($pengajuanID)
	{
		$pengajuan = $this->find($pengajuanID);
		$kodeUnitKerja = $this->kodeUnitKerja($pengajuanID);
		foreach($this->pengajuanDetails($pengajuanID) as $detail)
		{
			if($detail->status == 'disetujui')
			{
				$this->M_Barang->create([
					'no_barang'				=> $this->M_Barang->generateNoBarang($kodeUnitKerja),
					'nama_barang'			=> $detail->nama_barang,
					'qty'					=> $detail->qty,
					'kondisi'				=> 'baik',
					'id_detail_pengajuan'	=> $detail->id,
					'id_unit_kerja'			=> $pengajuan->id_unit_kerja,
				]);
			}
		}
	}


	public function jumlahPengajuanMenungguByRole()
	{
		if($this->session->userdata('user')->role == 'unit_kerja')
		{
			$pengajuan = $this->getByWhere([
				'id_unit_kerja'	=> $this->session->userdata('user')->id_unit_kerja,
				'status'		=> 'menunggu',
			]);

			return count($pengajuan);
		}
		else
		{
			$pengajuan = $this->getByWhere([
				'status'		=> 'menunggu',
			]);

			return count($pengajuan);
		}
	}

}