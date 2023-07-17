<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengumuman_model extends CI_Model
{

    public $table = 'pengumuman';
    public $id = 'id_peng';
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
        return $this->db->select('max(id_peng) as kode')
            ->from('pengumuman')->get()->result();
    }

    function get_all_query()
    {
        $sql = "SELECT a.id_peng,a.ketpeng,a.tglawal,a.tglakhir,b.nama_shift,b.ketkelas
        from pengumuman as a,shift as b
        where a.id_shift=b.id_shift";
        return $this->db->query($sql)->result();
    }


    function get_by_id_query($id)
    {
        $sql = "SELECT a.id_peng,a.ketpeng,a.tglawal,a.tglakhir,b.nama_shift,b.ketkelas
        from pengumuman as a,shift as b
        where a.id_shift=b.id_shift
        and id_peng=$id";
        return $this->db->query($sql)->row($id);
    }


    function getData()
    {
        $this->datatables->select('a.id_peng,a.ketpeng,a.tglawal,a.tglakhir,b.nama_shift,b.ketkelas')
            ->from('pengumuman as a,shift as b')
            ->where('a.id_shift=b.id_shift');
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
