<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Basedoa extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }
        $this->load->model('Basedoa_model');
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
        $doa = $this->Basedoa_model->get_all();

        $data = array(
            'doa_data' => $doa,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,

        );
        $this->template->load('template/template', 'basedoa/basedoa_list', $data);
        $this->load->view('template/datatables');
    }

    public function data()
    {

        $this->output_json($this->Basedoa_model->getData(), false);
    }


    public function rd($id)
    {
        $user = $this->user;
        $row = $this->Basedoa_model->get_by_id_query($this->uri->segment(3));
        if ($row) {
            $uri = $this->uri->segment(3);
            $data = array(

                'id_doa' => $row->id_doa,
                'judul' => $row->judul,
                'arab' => $row->arab,
                'latin' => $row->latin,
                'arti' => $row->arti,
                'informasi' => $row->informasi,
                'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'Basedoa/Basedoa_read', $data, $uri);
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Data tidak ditemukan!'));
            redirect(site_url('Basedoa'));
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
            'action' => site_url('Basedoa/create_action'),
            'id_doa' => set_value('id_doa'),
            'judul' => set_value('judul'),
            'arab' => set_value('arab'),
            'latin' => set_value('latin'),
            'arti' => set_value('arti'),
            'informasi' => set_value('informasi'),
            'user' => $user, 
            'users'  => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'Basedoa/Basedoa_form', $data);
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

                'judul' => ucwords($this->input->post('judul', TRUE)),
                'arab' => ucwords($this->input->post('arab', TRUE)),
                'latin' => ucwords($this->input->post('latin', TRUE)),
                'arti' => ucwords($this->input->post('arti', TRUE)),
                'informasi' => ucwords($this->input->post('informasi', TRUE)),
            );
            $this->Basedoa_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan Doa'));
            redirect(site_url('Basedoa'));
        }
    }

    public function update($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $user = $this->user;
        $row = $this->Basedoa_model->get_by_id($id);

        if ($row) {
            $data = array(
                'box' => 'warning',
                'button' => 'Update',
                'action' => site_url('Basedoa/update_action'),
                'id_doa' => set_value('id_doa', $row->id_doa),
                'judul' => set_value('judul', $row->judul),
                'arab' => set_value('arab', $row->arab),
                'latin' => set_value('latin', $row->latin),
                'arti' => set_value('arti', $row->arti),
                'informasi' => set_value('informasi', $row->informasi),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'Basedoa/Basedoa_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('Basedoa'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_doa', TRUE));
        } else {
            $data = array(

                'judul' => ucwords($this->input->post('judul', TRUE)),
                'arab' => ucwords($this->input->post('arab', TRUE)),
                'latin' => ucwords($this->input->post('latin', TRUE)),
                
                'arti' => ucwords($this->input->post('arti', TRUE)),
                'informasi' => ucwords($this->input->post('informasi', TRUE)),
            );
            $this->Basedoa_model->update($this->input->post('id_doa', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data'));
            redirect(site_url('Basedoa'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $row = $this->Basedoa_model->get_by_id($id);

        if ($row) {
            $this->Basedoa_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data'));
            redirect(site_url('Basedoa'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('Basedoa'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('judul', 'judul', 'trim|required');
        $this->form_validation->set_rules('arab', 'arab', 'trim|required');
        $this->form_validation->set_rules('latin', 'latin', 'trim|required');
       
        $this->form_validation->set_rules('arti', 'arti', 'trim|required');
        $this->form_validation->set_rules('informasi', 'informasi', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
