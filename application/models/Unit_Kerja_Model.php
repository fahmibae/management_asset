<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_Kerja_Model extends MY_Model {

	protected $table = 'unit_kerja';
	protected $softDeletes = true;

	public function __construct()
	{
		parent::__construct();
	}


	public function createUnitKerja($data)
	{
		$unitKerja = $this->create($data);

		return $unitKerja;
	}


	public function updateUnitKerja($id, $data)
	{
		$unitKerja = $this->update($id, $data);

		return $unitKerja;
	}


	public function deleteUnitKerja($id)
	{
		return $this->delete($id);
	}

}
