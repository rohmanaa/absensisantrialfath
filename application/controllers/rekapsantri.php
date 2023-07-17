<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class rekapsantri extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('rekapsantri_model', 'Jabatan_model'));
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
        $karyawan = $this->rekapsantri_model->get_all_query();
        $data = array(
            'karyawan_data' => $karyawan,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'rekapsantri/karyawan_rekap', $data);
        $this->load->view('template/datatables');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }


    public function data()
    {

        $this->output_json($this->rekapsantri_model->getData(), false);
    }

   

    public function bcn($id)
    {
        $user = $this->user;
        $baca = $this->rekapsantri_model->get_by_id_bcn($id);

        $data = array(
            'baca_data' => $baca,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),

        );
        $this->template->load('template/template', 'rekapsantri/bacaanrekap', $data);
        $this->load->view('template/datatables');
    }

    public function byr($id)
    {
        $user = $this->user;
        $bayar = $this->rekapsantri_model->get_by_id_byr($id);

        $data = array(
            'bayar_data' => $bayar,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),

        );
        $this->template->load('template/template', 'rekapsantri/bayarrekap', $data);
        $this->load->view('template/datatables');
    }

    public function hfl($id)
    {
        $user = $this->user;
        $hafalan = $this->rekapsantri_model->get_by_id_hfl($id);

        $data = array(
            'hafalan_data' => $hafalan,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),

        );
        $this->template->load('template/template', 'rekapsantri/hafalanrekap', $data);
        $this->load->view('template/datatables');
    }
  

    public function koin($id)
    {
        $user = $this->user;
        $bayar = $this->rekapsantri_model->get_by_id_koin($id);

        $data = array(
            'bayar_data' => $bayar,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),

        );
        $this->template->load('template/template', 'karyawan/koin', $data);
        $this->load->view('template/datatables');
    }

    


    function formatNbr($nbr)
    {
        if ($nbr == 0)
            return "001";
        else if ($nbr < 10)
            return "00" . $nbr;
        elseif ($nbr >= 10 && $nbr < 100)
            return "0" . $nbr;
        else
            return strval($nbr);
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
