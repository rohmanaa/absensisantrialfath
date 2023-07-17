<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Karyawan extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Karyawan_model', 'Jabatan_model'));
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
        $karyawan = $this->Karyawan_model->get_all_query();
        $data = array(
            'karyawan_data' => $karyawan,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'karyawan/karyawan_list', $data);
        $this->load->view('template/datatables');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }


    public function data()
    {

        $this->output_json($this->Karyawan_model->getData(), false);
    }

    public function rd($id)
    {
        $user = $this->user;
        $row = $this->Karyawan_model->get_by_id_query($this->uri->segment(3));
        if ($row) {
            $uri = $this->uri->segment(3);
            $data = array(
               
                'id_karyawan' => $row->id_karyawan,
                'nama_karyawan' => $row->nama_karyawan,
                'password' => $row->password,
                'jeniskelamin' => $row->jeniskelamin,
                'nohp' => $row->nohp,
                'tempat_lahir' => $row->tempat_lahir,
                'tgl_lahir' => $row->tgl_lahir,
                'ayah' => $row->ayah,
                'ibu' => $row->ibu,
                'nowa' => $row->nowa,
                'alamat' => $row->alamat,
                'nama_jabatan' => $row->nama_jabatan,
                'nama_gedung' => $row->nama_gedung,
                'nama_shift' => $row->nama_shift,
                'statussantri' => $row->statussantri,
                'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'karyawan/karyawan_read', $data, $uri);
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Data tidak ditemukan!'));
            redirect(site_url('karyawan'));
        }
    }

    public function bcn($id)
    {
        $user = $this->user;
        $baca = $this->Karyawan_model->get_by_id_bcn($id);

        $data = array(
            'baca_data' => $baca,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),

        );
        $this->template->load('template/template', 'karyawan/bacaanrekap', $data);
        $this->load->view('template/datatables');
    }

    public function byr($id)
    {
        $user = $this->user;
        $bayar = $this->Karyawan_model->get_by_id_byr($id);

        $data = array(
            'bayar_data' => $bayar,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),

        );
        $this->template->load('template/template', 'karyawan/bayarrekap', $data);
        $this->load->view('template/datatables');
    }

    public function hfl($id)
    {
        $user = $this->user;
        $hafalan = $this->Karyawan_model->get_by_id_hfl($id);

        $data = array(
            'hafalan_data' => $hafalan,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),

        );
        $this->template->load('template/template', 'karyawan/hafalanrekap', $data);
        $this->load->view('template/datatables');
    }
  


    public function create()
    {
        $chek = $this->ion_auth->is_admin();
        if (!$chek) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
            $hasil = 0;
        } else {
            $hasil = 1;
        }
        $user = $this->user;
        $data = array(
            'box' => 'info',
            'button' => 'Create',
            'action' => site_url('karyawan/create_action'),
            'id_karyawan' => set_value('id_karyawan'),
            'nama_karyawan' => set_value('nama_karyawan'),
            'jabatan' => set_value('jabatan'),
            'id_shift' => set_value('id_shift'),
            'gedung_id' => set_value('gedung_id'),
            'statussantri' => set_value ('statussantri'),
            
            'id' => set_value('id'),
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'karyawan/karyawan_form', $data);
    }
    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $kode = $this->Jabatan_model->get_by_id($this->input->post('jabatan'));
            $kodejbt = $kode->nama_jabatan;
            $kodeagt = substr($kodejbt, 2, 2);
            $tgl = 4;
            $var = $this->Karyawan_model->get_max();
            $getvar = $var[0]->kode;
            $nilai = $this->formatNbr($var[0]->kode);
            $nourut = $kodeagt . $tgl . $nilai;
            $data = array(
                'nama_karyawan' => ucwords($this->input->post('nama_karyawan', TRUE)),
                'id_karyawan' => $nourut,
             	'jabatan' => $this->input->post('jabatan', TRUE),
                'password' => $this->input->post('password', TRUE),
                'id_shift' => $this->input->post('id_shift', TRUE),
                'gedung_id' => $this->input->post('gedung_id', TRUE),
                'statussantri' => $this->input->post('statussantri', TRUE),
            );
            $this->Karyawan_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan Santri'));
            redirect(site_url('karyawan'));
        }
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


    public function update($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $user = $this->user;
        $row = $this->Karyawan_model->get_by_id($id);
        if ($row) {
            $data = array(
                'box' => 'danger',
                'button' => 'Update',
                'action' => site_url('karyawan/update_action'),
                'id_karyawan' => set_value('id_karyawan', $row->id_karyawan),
                'nama_karyawan' => set_value('nama_karyawan', $row->nama_karyawan),
                'jabatan' => set_value('jabatan', $row->jabatan),
                'id_shift' => set_value('id_shift', $row->id_shift),
                'gedung_id' => set_value('gedung_id', $row->gedung_id),
                'statussantri' => set_value('statussantri', $row->statussantri),

                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
                'id' => set_value('id', $row->id),
            );
            $this->template->load('template/template', 'karyawan/karyawan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('karyawan'));
        }
    }

    public function update_action()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_karyawan', TRUE));
        } else {
            $row = $this->Karyawan_model->get_by_id($this->input->post('id'));
            $id_karyawan = $row->id_karyawan;
            $data = array(
                'id_karyawan' => $id_karyawan,
                'nama_karyawan' => $this->input->post('nama_karyawan', TRUE),
                'jabatan' => $this->input->post('jabatan', TRUE),
                'id_shift' => $this->input->post('id_shift', TRUE),
                'gedung_id' => $this->input->post('gedung_id', TRUE),
                'statussantri' => $this->input->post('statussantri', TRUE),
            );

            $this->Karyawan_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data karyawan'));
            redirect(site_url('karyawan'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Karyawan_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Karyawan_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data karyawan'));
            redirect(site_url('karyawan'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('karyawan'));
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('nama_karyawan', 'nama karyawan', 'trim|required');
        $this->form_validation->set_rules('jabatan', 'jabatan', 'trim|required');
        $this->form_validation->set_rules('id_shift', 'id_shift', 'trim|required');
        $this->form_validation->set_rules('id_karyawan', 'id_karyawan', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
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
