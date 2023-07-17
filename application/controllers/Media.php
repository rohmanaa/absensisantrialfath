<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Media extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth');
        }
        $this->load->model('Media_model');
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
            'action' => site_url('media/create_action'),
            'id' => set_value('id'),
            'nama_foto' => set_value('nama_foto'),
            'ktr' => set_value('ktr'),
            'user' => $user, 
            'users'  => $this->ion_auth->user()->row(),
            'result' => $hasil,
        );
        $this->template->load('template/template', 'media/upload_view', $data);
    }

    public function create_action()
	{
		$data = [
			'ktr'=>$this->input->post('ktr', true),
		];
		$config['upload_path']          = 'uploads/media/';
		$config['allowed_types']        = 'jpg|jpeg|png|bmp';
		$config['max_size']             = 2024000;
		$config['overwrite']             = TRUE;
		$config['file_name']             = '';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('nama_foto')){
			// $this->toastr->error($this->upload->display_errors());
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Gagal menambahkan Foto'));
            redirect(site_url('upload_view'));
		}else{
			$gbr = $this->upload->data();
			$data['nama_foto'] = $gbr['file_name'];
		}
        $this->Media_model->insert($data);
        $this->session->set_flashdata('messageAlert', $this->messageAlert('susccess', 'Berhasil menambahkan Foto'));
        redirect(site_url('Media'));
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
        $media = $this->Media_model->get_all();

        $data = array(
            'media_data' => $media,
            'user' => $user,
            'users'     => $this->ion_auth->user()->row(),
            'result' => $hasil,

        );
        $this->template->load('template/template', 'media/media_list', $data);
        $this->load->view('template/datatables');
    }

    public function data()
    {

        $this->output_json($this->Media_model->getData(), false);
    }



    public function delete($id)
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
        $row = $this->Media_model->get_by_id($id);

        if ($row) {
            $this->Media_model->delete($id);
            $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menghapus data'));
            redirect(site_url('Media'));
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('danger', 'data tidak ditemukan'));
            redirect(site_url('Media'));
        }
    }

}
