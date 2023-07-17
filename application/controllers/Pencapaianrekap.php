<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pencapaianrekap extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Pencapaianrekap_model'));
        $this->load->model(array('Karyawan_model'));
        $this->load->model(array('Hafalan_model'));
        $this->load->library('form_validation', 'ion_auth');
        $this->load->helper('url');
        $this->user = $this->ion_auth->user()->row();
    }

    public function messageAlert($type, $title)
    {
        $messageAlert = "
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000
      });
      Toast.fire({
          type: '" . $type . "',
          title: '" . $title . "'
      });
      ";
        return $messageAlert;
    }

    public function index()
    {
        $chek = $this->ion_auth->is_admin();
        if (!$chek) {
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        $karyawan = $this->Karyawan_model->get_all();

        $data = array(
            'karyawan_data' => $karyawan,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'pencapaianrekap/pencapaianrekap_list', $data);
        $this->load->view('template/datatables');
    }



    public function bcr($id)
    {
        $user = $this->user;
        $Pencapaianrekap = $this->Pencapaianrekap_model->get_by_id_bcr($id);

        $data = array(
            'pencapaianrekap_data2' => $Pencapaianrekap,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),

        );
        $this->template->load('template/template', 'pencapaianrekap/bacaanrekap', $data);
        $this->load->view('template/datatables');
    }
    public function byr($id)
    {
        $user = $this->user;
        $Pencapaianrekap= $this->Pencapaianrekap_model->get_by_id_bcr($id);
        $data = array(

            'id_karyawan' => set_value('id_karyawan'),
            'tgl' => set_value('tgl'),
            'jam_msk' => set_value('jam_msk'),
            'jam_klr' => set_value('jam_klr'),
            'id_khd' => set_value('id_khd'),
            'ket' => set_value('ket'),
            'id_status' => set_value('id_status'),
            'Pencapaianrekap_data' => $Pencapaianrekap,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
        );
        $this->template->load('template/template', 'pencapaianrekap/bacaanrekap', $data);
        $this->load->view('template/datatables');
    }

    public function hfl($id)
    {
        $user = $this->user;
        $Pencapaianrekap= $this->Pencapaianrekap_model->get_by_id_bcr($id);
        $data = array(
            'button' => 'INPUT',
            'action' => site_url('pencapaian/bcr'),
            'id_absen' => set_value('id_absen'),
            'id_karyawan' => set_value('id_karyawan'),
            'tgl' => set_value('tgl'),
            'jam_msk' => set_value('jam_msk'),
            'jam_klr' => set_value('jam_klr'),
            'id_khd' => set_value('id_khd'),
            'ket' => set_value('ket'),
            'id_status' => set_value('id_status'),
            'Pencapaianrekap_data' => $Pencapaianrekap,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
        );
        $this->template->load('template/template', 'pencapaianrekap/bacaanrekap', $data);
        $this->load->view('template/datatables');
    }
    

    function _set_useragent()
    {
        if ($this->agent->is_mobile('iphone')) {
            $this->agent = 'iphone';
        } elseif ($this->agent->is_mobile()) {
            $this->agent = 'mobile';
        } else {
            $this->agent = 'desktop';
        }
    }
}
