<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chain extends CI_Controller
{
	public function __construct(){
	parent::__construct();
	$this->load->model('Setting_model', '', TRUE);
	}	

	// dijalankan saat provinsi di klik
	public function pilih_kabupaten(){
		$test=$this->uri->segment(3);
		$data['kabupaten']=$this->Setting_model->ambil_kabupaten($this->uri->segment(3));
		$this->load->view('backend/reporting/v_drop_down_kabupaten',$data);
	}

	// dijalankan saat kabupaten di klik
	public function pilih_kecamatan(){
		$data['kecamatan']=$this->Setting_model->ambil_kecamatan($this->uri->segment(3));
		$this->load->view('backend/reporting/v_drop_down_kecamatan',$data);
	}
	
	// dijalankan saat kecamatan di klik
	public function pilih_kelurahan(){
		$data['kelurahan']=$this->Setting_model->ambil_kelurahan($this->uri->segment(3));
		$this->load->view('backend/reporting/v_drop_down_kelurahan',$data);
	}
}
?>
