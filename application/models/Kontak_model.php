<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kontak_model extends CI_Model
{

    public $table = 'kontak';
    public $id = 'id_pesan';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_by_id_query($id)
    {
    $sql = "SELECT id_pesan,karyawan,pesan,tglkontak from kontak where id_pesan=$id ";
      return $this->db->query($sql)->row($id);
    }

    // get total rows
    function total_rows($q = NULL) {
    $this->db->like('id_pesan', $q);
	$this->db->or_like('kontak', $q);
    
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_pesan', $q);
	$this->db->or_like('kontak', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}