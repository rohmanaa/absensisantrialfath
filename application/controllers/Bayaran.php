<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bayaran extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Bayaran_model', 'Karyawan_model'));
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
        $Bayaran = $this->Bayaran_model->get_all_query();
        $data = array(
            'bayaran_data' => $Bayaran,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'bayaran/bayaran_list', $data);
        $this->load->view('template/datatables');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }


    public function data()
    {

        $this->output_json($this->Bayaran_model->getData(), false);
    }

    public function rd($id)
    {
        $user = $this->user;
        $row = $this->Bayaran_model->get_by_id_query($this->uri->segment(3));
        if ($row) {
            $uri = $this->uri->segment(3);
            $data = array(
                'id_bayar' => $row->id_bayar,
                'id_karyawan' => $row->id_karyawan,
                'statusbayar' => $row->statusbayar,
                'tglbayar' => $row->tglbayar,
                'jmlbyr' => $row->jmlbyr,
                'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'bayaran/bayaran_read', $data, $uri);
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Data tidak ditemukan!'));
            redirect(site_url('bayaran'));
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
            'action' => site_url('bayaran/create_action'),
            'id_bayar' => set_value('id_bayar'),
            'id_karyawan' => set_value('id_karyawan'),
            'tglbayar' => set_value('tglbayar'),
            'statusbayar' => set_value('statusbayar'),
            'jmlbyr' => set_value('jmlbyr'),
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'bayaran/bayaran_form', $data);
    }

    public function create_action()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'id_karyawan' => ucwords($this->input->post('id_karyawan', TRUE)),
                'tglbayar' => ucwords($this->input->post('tglbayar', TRUE)),
                'statusbayar' => ucwords($this->input->post('statusbayar', TRUE)),
                'jmlbyr' => ucwords($this->input->post('jmlbyr', TRUE)),
            );
            $this->Bayaran_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan Bank Hafalan'));
            redirect(site_url('Bayaran'));
        }
    }


    public function update($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $user = $this->user;
        $row = $this->Bayaran_model->get_by_id($id);

        if ($row) {
            $data = array(
                'box' => 'warning',
                'button' => 'Update',
                'action' => site_url('bayaran/update_action'),
                'id_bayar' => set_value('id_bayar', $row->id_bayar),
                'id_karyawan' => set_value('id_karyawan', $row->id_karyawan),
                'tglbayar' => set_value('tglbayar', $row->tglbayar),
                'statusbayar' => set_value('statusbayar', $row->statusbayar),
                'jmlbyr' => set_value('jmlbyr', $row->jmlbyr),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'bayaran/bayaran_form_update', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('Bayaran'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_bayar', TRUE));
        } else {
            $data = array(
                'id_karyawan' => ucwords($this->input->post('id_karyawan', TRUE)),
                'statusbayar' => ucwords($this->input->post('statusbayar', TRUE)),
                'jmlbyr' => ucwords($this->input->post('jmlbyr', TRUE)),
            );
            $this->Bayaran_model->update($this->input->post('id_bayar', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data'));
            redirect(site_url('bayaran'));
        }
    }

    

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Bayaran_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Bayaran_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data karyawan'));
            redirect(site_url('bayaran'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('bayaran'));
        }
    }


    public function _rules()
    {
               $this->form_validation->set_rules('jmlbyr', 'jmlbyr', 'trim|required');
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
