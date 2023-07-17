<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengumuman extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Pengumuman_model', 'Shift_model'));
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
        $Pengumuman = $this->Pengumuman_model->get_all_query();
        $data = array(
            'pengumuman_data' => $Pengumuman,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'pengumuman/pengumuman_list', $data);
        $this->load->view('template/datatables');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }


    public function data()
    {

        $this->output_json($this->Pengumuman_model->getData(), false);
    }

    public function rd($id)
    {
        $user = $this->user;
        $row = $this->Pengumuman_model->get_by_id_query($this->uri->segment(3));
        if ($row) {
            $uri = $this->uri->segment(3);
            $data = array(
                'id_peng' => $row->id_peng,
                'id_shift' => $row->id_shift,
                'ketpeng' => $row->ketpeng,
                'tglawal' => $row->tglawal,
                'tglakhir' => $row->tglakhir,
                'konfirmasi' => $row->konfirmasi,
                'stpeng' => $row->stpeng,
                'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'pengumuman/pengumuman_read', $data, $uri);
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Data tidak ditemukan!'));
            redirect(site_url('pengumuman'));
        }
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
            'action' => site_url('pengumuman/create_action'),
            'id_bayar' => set_value('id_bayar'),
            'id_karyawan' => set_value('id_karyawan'),
            'tglbayar' => set_value('tglbayar'),
            'statusbayar' => set_value('statusbayar'),
            'jmlbyr' => set_value('nmlbyr'),
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'pengumuman/pengumuman_form', $data);
    }

    public function create_action()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $this->_rules();
        $refer =  $this->agent->referrer();
        if ($this->agent->is_referral()) {
            $refer =  $this->agent->referrer();
        }
        $id = $this->input->post('id_bayar');
        $result = $this->Presensi_model->search_value($_POST['id_karyawan'], $id);
        $karyawan = $this->input->post('id_karyawan');
        if ($result != FALSE) {
            $data = array(
                'id_karyawan' => $result[0]->id_karyawan,
                'tglbayar' => date('Y-m-d'),
                'id_khd' => 1,
                'id_status' => 1,
            );
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Data Anggota tidak ditemukan'));
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        }
        $result_tgl = $data['tgl'];
        $result_id = $result[0]->id_karyawan;
        $cek_absen = $this->Presensi_model->cek_id($result_id, $result_tgl);
        if ($cek_absen !== FALSE  && $cek_absen->num_rows() == 1) {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('warning', 'Nama Anggota Sudah diabsen'));
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        } else {
            $kar_result = $result[0]->id_karyawan;
            if ($kar_result == NULL || $karyawan == "") {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('Error', 'Data tidak ditemukan'));
                redirect($_SERVER['HTTP_REFERER']);
                return false;
            } else {
                $tgl = date('Y-m-d');
                $id_krywn = $data['id_karyawan'];
                $this->Presensi_model->insert($data);
                $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan data presensi'));
                $referred_from = $this->session->userdata('referred_from');
                redirect($referred_from, 'refresh');
            }
        }
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
                'id_shift' => set_value('shift', $row->id_shift),
                'gedung_id' => set_value('gedung_id', $row->gedung_id),
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
            $kode = $this->Jabatan_model->get_by_id($this->input->post('jabatan'));
            $row = $this->Karyawan_model->get_by_id($this->input->post('id'));
            $id_karyawan = $row->id_karyawan;
            $kodejbt = $kode->nama_jabatan;
            $kodelama = substr($id_karyawan, 0, 1);
            $kodebaru = substr($kodejbt, 0, 1);
            $updatekode = str_replace($kodelama, $kodebaru, $id_karyawan);
            $data = array(
                'id_karyawan' => $updatekode,
                'nama_karyawan' => $this->input->post('nama_karyawan', TRUE),
                'jabatan' => $this->input->post('jabatan', TRUE),
                'id_shift' => $this->input->post('id_shift', TRUE),
                'gedung_id' => $this->input->post('gedung_id', TRUE),
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
        $row = $this->pengumuman_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->pengumuman_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data karyawan'));
            redirect(site_url('pengumuman'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('pengumuman'));
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
