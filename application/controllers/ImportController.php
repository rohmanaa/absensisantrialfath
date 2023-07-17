<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImportController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library(array('excel','session'));
	}

	public function index()
	{
		$this->load->model('ImportModel');
		$data = array(
			'list_data'	=> $this->ImportModel->getData()
		);
		$this->load->view('Import/Import_Excel.php',$data);
	}

	public function import_excel(){
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();	
				for($row=2; $row<=$highestRow; $row++)
				{
					$bankhafalan = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$jumlahayat = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$tentangayat = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$keteranganayat = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$id_kategori = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

					$temp_data[] = array(
						'bankhafalan'	=> $bankhafalan,
						'jumlahayat'	=> $jumlahayat,
						'tentangayat'	=> $tentangayat,
						'keteranganayat'	=> $keteranganayat,
						'id_kategori'	=> $id_kategori
					); 	
				}
			}
			$this->load->model('ImportModel');
			$insert = $this->ImportModel->insert($temp_data);
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