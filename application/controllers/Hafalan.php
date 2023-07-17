<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hafalan extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }

        $this->load->library('user_agent');
        $this->load->model(array('Hafalan_model', 'Karyawan_model'));
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
        $Hafalan = $this->Hafalan_model->get_all_query();
        $data = array(
            'hafalan_data' => $Hafalan,
            'user' => $user, 'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'hafalan/hafalan_list', $data);
        $this->load->view('template/datatables');
    }

    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }


    public function data()
    {

        $this->output_json($this->Hafalan_model->getData(), false);
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
            'action' => site_url('hafalan/create_action'),
            'id_lapor' => set_value('id_lapor'),
            'id_hafal' => set_value('id_hafal'),
            'id_karyawan' => set_value('id_karyawan'),
            'tglhafal' => set_value('tglhafal'),
            'nilaihafal' => set_value('nilaihafal'),
            'kethafalan' => set_value('kethafalan'),
            'user' => $user, 
            'users'  => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'hafalan/hafalan_form', $data);
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
                'id_hafal' => ucwords($this->input->post('id_hafal', TRUE)),
                'tglhafal' => ucwords($this->input->post('tglhafal', TRUE)),
                'nilaihafal' => ucwords($this->input->post('nilaihafal', TRUE)),
                'kethafalan' => ucwords($this->input->post('kethafalan', TRUE)),
            );
            
            $cek = $this->db->query("SELECT * FROM hafallapor where id_hafal=".$this->input->post('id_hafal')." AND id_karyawan=".$this->input->post('id_karyawan')."");
			if ($cek->num_rows()>=1){
            $this->session->set_flashdata('messageAlert', $this->messageAlert('info', 'Data sudah ada'));
            redirect('hafalan','refresh');}
            else{
            $this->Hafalan_model->insert($data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan Bacaan'));
            redirect(site_url('Hafalan'));
        }
    }}
   
       
    

    public function update($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $user = $this->user;
        $row = $this->Hafalan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'box' => 'warning',
                'button' => 'Update',
                'action' => site_url('hafalan/update_action'),
                'id_lapor' => set_value('id_lapor', $row->id_lapor),
                'id_karyawan' => set_value('id_karyawan', $row->id_karyawan),
                'id_hafal' => set_value('id_hafal', $row->id_hafal),
                'tglhafal' => set_value('tglhafal', $row->tglhafal),
                'nilaihafal' => set_value('nilaihafal', $row->nilaihafal),
                'kethafalan' => set_value('kethafalan', $row->kethafalan),
                'user' => $user,
                'users'     => $this->ion_auth->user()->row(),
            );
            $this->template->load('template/template', 'hafalan/hafalan_form_update', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hafalan'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_lapor', TRUE));
        } else {
            $data = array(
                'id_hafal' => $this->input->post('id_hafal', TRUE),
                'id_karyawan' => $this->input->post('id_karyawan', TRUE),
                'tglhafal' => $this->input->post('tglhafal', TRUE),
                'nilaihafal' => $this->input->post('nilaihafal', TRUE),
                'kethafalan' => $this->input->post('kethafalan', TRUE),
            );
            $this->Hafalan_model->update($this->input->post('id_lapor', TRUE), $data);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil merubah data'));
            redirect(site_url('hafalan'));
        }
    }

    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Dilarang!');
        }
        $row = $this->Hafalan_model->get_by_id($this->uri->segment(3));
        if ($row) {
            $this->Hafalan_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data karyawan'));
            redirect(site_url('Hafalan'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('Hafalan'));
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('id_karyawan', 'id_karyawan', 'trim|required');
        $this->form_validation->set_rules('id_hafal', 'id_hafal', 'trim|required');
        $this->form_validation->set_rules('tglhafal', 'tglhafal', 'trim|required');
        $this->form_validation->set_rules('nilaihafal', 'nilaihafal', 'trim|required');
        $this->form_validation->set_rules('kethafalan', 'kethafalan', 'trim|required');
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
