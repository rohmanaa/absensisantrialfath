<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{

    public $table = 'karyawan';
    public $id = 'id';
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
        return $this->db->select('max(id) as kode')
            ->from('karyawan')->get()->result();
    }

    function get_all_query()
    {
        $sql = "SELECT a.id_karyawan,a.nama_karyawan,b.nama_jabatan,c.nama_shift,a.gedung_id,a.password,a.jeniskelamin,a.nohp,a.tempat_lahir,a.tgl_lahir,a.ayah,a.ibu,a.alamat,a.statussantri,a.nowa
                from karyawan as a,jabatan as b,shift as c
                where b.id_jabatan=a.jabatan
                and a.id_shift=c.id_shift";
        return $this->db->query($sql)->result();
    }


    function get_by_id_query($id)
    {
        $sql = "SELECT a.id_karyawan,a.nama_karyawan,b.nama_jabatan,d.nama_shift,c.nama_gedung,a.password,a.jeniskelamin,a.nohp,a.tempat_lahir,a.tgl_lahir,a.ayah,a.ibu,a.alamat,a.statussantri,a.nowa
        from karyawan as a,jabatan as b,gedung as c,shift as d
        where b.id_jabatan=a.jabatan
        and a.gedung_id=c.gedung_id
        and d.id_shift=a.id_shift
        and id=$id";
        return $this->db->query($sql)->row($id);
    }

    function get_by_id_bcn($id)
    {
        $bcn = "SELECT a.id_karyawan,a.nama_karyawan,b.ketbaca,b.tglbaca,b.id_capai
        from karyawan as a,capaian as b
        where a.id_karyawan=b.id_karyawan
        and id=$id";
  return $this->db->query($bcn)->result();
    }

    function get_by_id_byr($id)
    {
        $byr = "SELECT a.id_karyawan,a.nama_karyawan,b.statusbayar,b.tglbayar,b.id_bayar,b.jmlbyr
        from karyawan as a,bayaran as b
        where a.id_karyawan=b.id_karyawan
        and id=$id";
  return $this->db->query($byr)->result();
    }

    function get_by_id_hfl($id)
    {
        $hfl = "SELECT a.id_lapor,a.id_hafal,a.id_karyawan,a.tglhafal,a.nilaihafal,a.kethafalan,b.nama_karyawan,c.bankhafalan,c.tentangayat,c.jumlahayat,c.keteranganayat,c.id_kategori
        from hafallapor as a,karyawan as b,hafalan as c
        where b.id_karyawan=a.id_karyawan
        and c.id_hafal=a.id_hafal
        and id=$id";
  return $this->db->query($hfl)->result();
    }


    function getData()
    {
        $this->datatables->select('a.id,a.id_karyawan,a.nama_karyawan,b.nama_jabatan,d.nama_shift,c.nama_gedung,a.password,a.jeniskelamin,a.nohp,a.tempat_lahir,a.tgl_lahir,a.ayah,a.ibu,a.alamat,a.statussantri,a.nowa')
            ->from('karyawan as a,jabatan as b,gedung as c,shift as d')
            ->where('b.id_jabatan=a.jabatan')
            ->where('a.gedung_id=c.gedung_id')
            ->where('d.id_shift=a.id_shift');
        return $this->datatables->generate();
    }
    // get data by id

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        $this->db->order_by($this->id, $this->order);
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
