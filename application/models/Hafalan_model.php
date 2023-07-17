<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hafalan_model extends CI_Model
{

    public $table = 'hafallapor';
    public $id = 'id_lapor';
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


    function get_max()
    {
        return $this->db->select('max(id_lapor) as kode')
            ->from('hafallapor')->get()->result();
    }

    function get_all_query()
    {
    $sql = "SELECT a.id_lapor,a.id_hafal,a.id_karyawan,a.tglhafal,a.nilaihafal,a.kethafalan,b.nama_karyawan,c.bankhafalan,c.id_kategori
    from hafallapor as a,karyawan as b,hafalan as c
    where b.id_karyawan=a.id_karyawan
    and c.id_hafal=a.id_hafal";
     return $this->db->query($sql)->result();
    }

    function get_by_id_query($id)
    {
        $sql = "SELECT a.id_lapor,a.id_hafal,a.id_karyawan,a.tglhafal,a.nilaihafal,a.kethafalan,b.nama_karyawan,c.bankhafalan,c.id_kategori
        from hafallapor as a,karyawan as b,hafalan as c
        where b.id_karyawan=a.id_karyawan
        and c.id_hafal=a.id_hafal
        and id_lapor=$id";
        return $this->db->query($sql)->row($id);
    }


    function getData()
    {
        $this->datatables->select('a.id_lapor,a.id_hafal,a.id_karyawan,a.tglhafal,a.nilaihafal,a.kethafalan,b.nama_karyawan,c.bankhafalan,c.id_kategori')
            ->from('hafallapor as a,karyawan as b,hafalan as c')
            ->where('b.id_karyawan=a.id_karyawan')
            ->where( 'c.id_hafal=a.id_hafal');
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
