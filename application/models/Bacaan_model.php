<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bacaan_model extends CI_Model
{

    public $table = 'capaian';
    public $id = 'id_capai';
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


    function get_all_query()
    {
        $sql = "SELECT a.id_capai,a.tglbaca,a.ketbaca,b.nama_karyawan
        from capaian as a,karyawan as b
        where a.id_karyawan=b.id_karyawan";
        return $this->db->query($sql)->result();
    }


    function get_by_id_query($id)
    {
        $sql = "SELECT a.id_capai,a.tglbaca,a.ketbaca,b.nama_karyawan
        from capaian as a,karyawan as b
        where a.id_karyawan=b.id_karyawan
        and id_capai=$id";
        return $this->db->query($sql)->row($id);
    }


    function getData()
    {
        $this->datatables->select('a.id_capai,a.tglbaca,a.ketbaca,b.nama_karyawan')
            ->from('capaian as a,karyawan as b')
            ->where('a.id_karyawan=b.id_karyawan');
        return $this->datatables->generate();
    }
    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
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
