<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SantriModel extends CI_Model {

	public function insert($data){
		$insert = $this->db->insert_batch('karyawan', $data);
		if($insert){
			return true;
		}
	}
	public function getData(){
		$this->db->select('*');
		return $this->db->get('karyawan')->result_array();
	}

}
