<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bacaan extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Bacaan_model', 'Karyawan_model'));
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
        $Bacaan = $this->Bacaan_model->get_all_query();
        $data = array(
            'bacaan_data' => $Bacaan,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'baca/bacaan_list', $data);
        $this->load->view('template/datatables');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    

    public function data()
    {

        $this->output_json($this->Bacaan_model->getData(), false);
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
            'action' => site_url('bacaan/create_action'),
            'id_capai' => set_value('id_capai'),
            'id_karyawan' => set_value('id_karyawan'),
            'tglbaca' => set_value('tglbaca'),
            'ketbaca' => set_value('ketbaca'),
            'user' => $user, 
            'users'  => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'baca/bacaan_form', $data);
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
                'tglbaca' => date('Y-m-d'),
                'ketbaca' => ucwords($this->input->post('ketbaca', TRUE)),
            );
            $cek = $this->db->query("SELECT * FROM capaian where id_karyawan=".$this->input->post('id_karyawan')." AND tglbaca=".$this->input->post('tglbaca')."");
			if ($cek->num_rows()>=1){
            $this->session->set_flashdata('messageAlert', $this->messageAlert('info', 'Data sudah ada'));
            redirect('Bacaan','refresh');}
            else{
            $this->Bacaan_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan Bacaan'));
            redirect(site_url('Bacaan'));
        }
        }
    }

    public function update($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $user = $this->user;
        $row = $this->Bacaan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'box' => 'warning',
                'button' => 'Update',
                'action' => site_url('bacaan/update_action'),
                'id_capai' => set_value('id_capai', $row->id_capai),
                'id_karyawan' => set_value('id_karyawan', $row->id_karyawan),
                'tglbaca' => set_value('tglbaca', $row->tglbaca),
                'ketbaca' => set_value('ketbaca', $row->ketbaca),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'baca/bacaan_form_update', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('Bacaan'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_capai', TRUE));
        } else {
            $data = array(
                'id_karyawan' => ucwords($this->input->post('id_karyawan', TRUE)),
                'tglbaca' => ucwords($this->input->post('tglbaca', TRUE)),
                'ketbaca' => ucwords($this->input->post('ketbaca', TRUE)),
            );
            $this->Bacaan_model->update($this->input->post('id_capai', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data'));
            redirect(site_url('Bacaan'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Bacaan_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Bacaan_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data pencapaian santri'));
            redirect(site_url('Bacaan'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('Bacaan'));
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('ketbaca', 'ketbaca', 'trim|required');
        $this->form_validation->set_rules('tglbaca', 'tglbaca', 'trim|required');
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
