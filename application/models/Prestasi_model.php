<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prestasi_model extends CI_Model
{

    public $table = 'prestasi';
    public $id = 'id_prestasi';
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
        $sql = "SELECT a.id_prestasi,a.tgllomba,a.ketlomba,a.jenislomba,a.juara,a.penyelenggara,b.id_karyawan,b.nama_karyawan
        from prestasi as a,karyawan as b
        where a.id_karyawan=b.id_karyawan";
        return $this->db->query($sql)->result();
    }


    function get_by_idq($id)
    {
        $sql = "SELECT a.id_prestasi,a.tgllomba,a.ketlomba,a.jenislomba,a.juara,a.penyelenggara,b.nama_karyawan,b.id_karyawan
        from prestasi as a,karyawan as b
        where a.id_karyawan=b.id_karyawan
        and id_prestasi=$id";
        return $this->db->query($sql)->row($id);
    }


    function getData()
    {
        $this->datatables->select('a.id_prestasi,a.tgllomba,a.ketlomba,a.jenislomba,a.juara,a.penyelenggara,b.nama_karyawan,b.id_karyawan')
            ->from('prestasi as a,karyawan as b')
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
