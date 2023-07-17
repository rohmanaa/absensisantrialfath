<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImSantri extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library(array('excel','session'));
	}

	public function index()
	{
		$this->load->model('SantriModel');
		$data = array(
			'list_data'	=> $this->SantriModel->getData()
		);
		$this->load->view('Import/Import_Santri.php',$data);
	}

	public function import_santri(){
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();	
				for($row=0; $row<=$highestRow; $row++)
				{
					$id_karyawan = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$nama_karyawan = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$jabatan = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$id_shift = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$gedung_id = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$nohp= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$password = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$foto= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$tempat_lahir = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
					$tgl_lahir = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
					$ayah = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
					$ibu = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
					$nowa = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
					$jeniskelamin = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
					$alamat = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
					$statussantri = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
					$pesan = $worksheet->getCellByColumnAndRow(16, $row)->getValue();

					$temp_data[] = array(
						'id_karyawan'	=> $id_karyawan,
						'nama_karyawan'	=> $nama_karyawan,
						'jabatan'	=> $jabatan,
						'id_shift'	=> $id_shift,
						'gedung_id'	=> $gedung_id,
						'nohp'	=> $nohp,
						'password'	=> $password,
						'foto'	=> $foto,
						'tempat_lahir'	=> $tempat_lahir,
						'tgl_lahir'	=> $tgl_lahir,
						'ayah'	=> $ayah,
						'ibu'	=> $ibu,
						'nowa'	=> $nowa,
						'jeniskelamin'	=> $jeniskelamin,
						'alamat'	=> $alamat,
						'statussantri'	=> $statussantri,
						'pesan'	=> $pesan
						

					); 	
				}
			}
			$this->load->model('SantriModel');
			$insert = $this->SantriModel->insert($temp_data);
			if($insert){
				$this->session->set_flashdata('status', '<span class="glyphicon glyphicon-ok"></span> Data Berhasil di Import ke Database');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			echo "Tidak ada file yang masuk";
		}
	}

}