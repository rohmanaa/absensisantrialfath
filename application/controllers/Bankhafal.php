<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bankhafal extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }
        $this->load->model('Bankhafal_model');
        $this->load->library('form_validation');
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
        $hafalan = $this->Bankhafal_model->get_all();

        $data = array(
            'hafalan_data' => $hafalan,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,

        );
        $this->template->load('template/template', 'bankhafal/bankhafal_list', $data);
        $this->load->view('template/datatables');
    }

    public function data()
    {

        $this->output_json($this->bankhafal_model->getData(), false);
    }


    public function rd($id)
    {
        $user = $this->user;
        $row = $this->bankhafal_model->get_by_id_query($this->uri->segment(3));
        if ($row) {
            $uri = $this->uri->segment(3);
            $data = array(
                'id_hafal' => $row->id_hafal,
                'id_kategori' => $row->id_kategori,
                'bankhafalan' => $row->bankhafalan,
                'jumlahayat' => $row->jumlahayat,
                'tentangayat' => $row->tentangayat,
                'keteranganayat' => $row->keteranganayat,
                'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'bankhafal/bankhafal_read', $data, $uri);
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Data tidak ditemukan!'));
            redirect(site_url('bankhafal'));
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
            'action' => site_url('bankhafal/create_action'),
            'id_hafal' => set_value('id_hafal'),
            'bankhafalan' => set_value('bankhafalan'),
            'jumlahayat' => set_value('jumlahayat'),
            'tentangayat' => set_value('tentangayat'),
            'keteranganayat' => set_value('keteranganayat'),
            'id_kategori' => set_value('id_kategori'),
            'user' => $user, 
            'users'  => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'bankhafal/bankhafal_form', $data);
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

                'bankhafalan' => ucwords($this->input->post('bankhafalan', TRUE)),
                'jumlahayat' => ucwords($this->input->post('jumlahayat', TRUE)),
                'tentangayat' => ucwords($this->input->post('tentangayat', TRUE)),
                'keteranganayat' => ucwords($this->input->post('keteranganayat', TRUE)),
                'id_kategori' => ucwords($this->input->post('id_kategori', TRUE)),
            );
            $this->bankhafal_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan Bacaan'));
            redirect(site_url('bankhafal'));
        }
    }

    public function update($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $user = $this->user;
        $row = $this->bankhafal_model->get_by_id($id);

        if ($row) {
            $data = array(
                'box' => 'warning',
                'button' => 'Update',
                'action' => site_url('bankhafal/update_action'),
                'id_hafal' => set_value('id_hafal', $row->id_hafal),
                'bankhafalan' => set_value('bankhafalan', $row->bankhafalan),
                'tentangayat' => set_value('tentangayat', $row->tentangayat),
                'jumlahayat' => set_value('jumlahayat', $row->jumlahayat),
                'keteranganayat' => set_value('keteranganayat', $row->keteranganayat),
                'id_kategori' => set_value('id_kategori', $row->id_kategori),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'bankhafal/bankhafal_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('bankhafal'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_hafal', TRUE));
        } else {
            $data = array(

                'bankhafalan' => ucwords($this->input->post('bankhafalan', TRUE)),
                'jumlahayat' => ucwords($this->input->post('jumlahayat', TRUE)),
                'tentangayat' => ucwords($this->input->post('tentangayat', TRUE)),
                'keteranganayat' => ucwords($this->input->post('keteranganayat', TRUE)),
                'id_kategori' => ucwords($this->input->post('id_kategori', TRUE)),
            );
            $this->bankhafal_model->update($this->input->post('id_hafal', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data'));
            redirect(site_url('bankhafal'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $row = $this->bankhafal_model->get_by_id($id);

        if ($row) {
            $this->bankhafal_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data'));
            redirect(site_url('bankhafal'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('bankhafal'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('bankhafalan', 'bankhafalan', 'trim|required');
        $this->form_validation->set_rules('jumlahayat', 'jumlahayat', 'trim|required');
        $this->form_validation->set_rules('tentangayat', 'tentangayat', 'trim|required');
        $this->form_validation->set_rules('keteranganayat', 'keteranganayat', 'trim|required');
        $this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
