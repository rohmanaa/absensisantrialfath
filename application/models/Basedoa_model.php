<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Basedoa_model extends CI_Model
{

    public $table = 'base_doa';
    public $id = 'id_doa';
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
      $sql = "SELECT id_doa,judul,arab,latin,arti,informasi from base_doa where id_doa=$id ";
      return $this->db->query($sql)->row($id);
    }

    // get total rows
    function total_rows($q = NULL) {
    $this->db->like('id_doa', $q);
	$this->db->or_like('judul', $q);
    
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_doa', $q);
	$this->db->or_like('judul', $q);
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