<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prestasi extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Prestasi_model', 'Karyawan_model'));
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
        $Prestasi = $this->Prestasi_model->get_all_query();
        $data = array(
            'Prestasi_data' => $Prestasi,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'prestasi/Prestasi_list', $data);
        $this->load->view('template/datatables');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    

    public function data()
    {

        $this->output_json($this->Prestasi_model->getData(), false);
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
            'action' => site_url('prestasi/create_action'),
            'id_prestasi' => set_value('id_prestasi'),
            'id_karyawan' => set_value('id_karyawan'),
            'tgllomba' => set_value('tgllomba'),
            'jenislomba' => set_value('jenislomba'),
            'juara' => set_value('juara'),
            'penyelenggara' => set_value('penyelenggara'),
            'ketlomba' => set_value('ketlomba'),
            'user' => $user, 
            'users'  => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'prestasi/Prestasi_form', $data);
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
                'tgllomba' => date('Y-m-d'),
                'jenislomba' => ucwords($this->input->post('jenislomba', TRUE)),
                'juara' => ucwords($this->input->post('juara', TRUE)),
                'penyelenggara' => ucwords($this->input->post('penyelenggara', TRUE)),
                'ketlomba' => ucwords($this->input->post('ketlomba', TRUE)),
            );
            $this->Prestasi_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan Prestasi'));
            redirect(site_url('Prestasi'));
        
        }
    }

    

    public function update($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $user = $this->user;
        $row = $this->Prestasi_model->get_by_idq($id);

        if ($row) {
            $data = array(
                'box' => 'warning',
                'button' => 'Update',
                'action' => site_url('prestasi/update_action'),
                'id_prestasi' => set_value('id_prestasi',  $row->id_prestasi),
                'id_karyawan' => set_value('id_karyawan',  $row->id_karyawan),
                'tgllomba' => set_value('tgllomba', $row->tgllomba),
                'jenislomba' => set_value('jenislomba', $row->jenislomba),
                'juara' => set_value('juara',$row->juara),
                'penyelenggara' => set_value('penyelenggara',$row->penyelenggara),
                'ketlomba' => set_value('ketlomba', $row->ketlomba),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'prestasi/Prestasi_form_update', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('Prestasi'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_prestasi', TRUE));
        } else {
            $data = array(
                'id_karyawan' => ucwords($this->input->post('id_karyawan', TRUE)),
                'tgllomba' => ucwords($this->input->post('tgllomba', TRUE)),
                'jenislomba' => ucwords($this->input->post('jenislomba', TRUE)),
                'juara' => ucwords($this->input->post('juara', TRUE)),
                'penyelenggara' => ucwords($this->input->post('penyelenggara', TRUE)),
                'ketlomba' => ucwords($this->input->post('ketlomba', TRUE)),

            );
            $this->Prestasi_model->update($this->input->post('id_prestasi', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data'));
            redirect(site_url('Prestasi'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Prestasi_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Prestasi_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data pencapaian santri'));
            redirect(site_url('Prestasi'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('Prestasi'));
        }
    }


    public function _rules()
    {   
        $this->form_validation->set_rules('ketlomba', 'ketlomba', 'trim|required');
        $this->form_validation->set_rules('penyelenggara', 'penyelenggara', 'trim|required');
        $this->form_validation->set_rules('juara', 'juara', 'trim|required');$this->form_validation->set_rules('juara', 'juara', 'trim|required');
        $this->form_validation->set_rules('jenislomba', 'jenislomba', 'trim|required');
        $this->form_validation->set_rules('tgllomba', 'tgllomba', 'trim|required');
        $this->form_validation->set_rules('id_karyawan', 'id_karyawan', 'trim|required');
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
