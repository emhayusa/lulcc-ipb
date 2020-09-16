<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporting extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    
    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        setlocale(LC_ALL,'id_ID');
        $this->load->model('Setting_model', '', TRUE);
		$this->load->model('Reporting_model', '', TRUE);
    }
    
	public function index()
	{
	    if($this->session->userdata('status') != "loginuser"){
	        redirect("login");
	    }else{
	        $awal["base_url"] = base_url();
	        $this->load->view('backend_html_awal', $awal);
			$menu["active_menu"] = 'reporting';
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);
			$content["datas"] = $this->Reporting_model->get_all_view()->result();
	        $this->load->view('backend/reporting/index', $content);
	        $this->load->view('backend_html_akhir');
	    }
	}	

	public function add()
	{
	    if($this->session->userdata('status') != "loginuser"){
	        redirect("login");
	    }else{
	        $awal["base_url"] = base_url();
	        $this->load->view('backend_html_awal', $awal);
	        $settings = $this->Setting_model->get_setting()->row();
			$menu["active_menu"] = 'reporting';
			$data['provinsi']=$this->Setting_model->ambil_provinsi();
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);			
	        $this->load->view('backend/reporting/add',$data);			
	        $this->load->view('backend_html_akhir');
	    }
	}

	// dijalankan saat provinsi di klik
	public function pilih_kabupaten(){
		$data['kabupaten']=$this->Setting_model->ambil_kabupaten($this->uri->segment(3));
		$this->load->view('backend/reporting/v_drop_down_kabupaten',$data);
	}

	// dijalankan saat kabupaten di klik
	public function pilih_kecamatan(){
		$data['kecamatan']=$this->Setting_model->ambil_kecamatan($this->uri->segment(3));
		$this->load->view('v_drop_down_kecamatan',$data);
	}
	
	// dijalankan saat kecamatan di klik
	public function pilih_kelurahan(){
		$data['kelurahan']=$this->Setting_model->ambil_kelurahan($this->uri->segment(3));
		$this->load->view('v_drop_down_kelurahan',$data);
	}

	public function insert()
	{
	    if($this->session->userdata('status') != "loginuser"){
	        redirect("login");
	    }else{
	        $awal["base_url"] = base_url();
	        $this->load->view('backend_html_awal', $awal);
	        $settings = $this->Setting_model->get_setting()->row();
			$menu["active_menu"] = 'reporting';
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);			   

			//$this->form_validation->set_rules('provinsi_id', 'provinsi_id', 'required', array('required' => 'You must complete %s.'));
			//$this->form_validation->set_rules('kabupaten_id', 'kabupaten_id', 'required', array('required' => 'You must complete %s.'));
			//$this->form_validation->set_rules('kecamatan_id', 'kecamatan_id', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('forest_gain', 'Forest Gain', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('oil_palm', 'Oil Palm', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('Rubber', 'Rubber', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('Coccoa', 'Coccoa', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('Coffe', 'Coffe', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('Others', 'Others', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('forest_loss', 'Forest Loss', 'required', array('required' => 'You must complete %s.'));
			//$this->form_validation->set_rules('Year', 'Year', 'required|exact_length[4]|integer', array('required' => 'You must complete %s.', 'exact_length' => 'The %s is four number', 'integer' => 'The %s must integer' ));
			
			
			if ($this->form_validation->run() == FALSE)
			{
				$data['provinsi']=$this->Setting_model->ambil_provinsi();
				$this->load->view('backend/reporting/add',$data);		
			}else{
				
				 $data = array(
		        'province_id' => $this->input->post('provinsi_id'),
		        'kabupaten_id' => $this->input->post('kabupaten_id'),
		        'kecamatan_id' => $this->input->post('kecamatan_id'),
		        'forest_gain' => $this->input->post('forest_gain'),	
		        'forest_loss' => $this->input->post('forest_loss'),
		        'oil_palm' => $this->input->post('oil_palm'),
		        'paddy' => $this->input->post('Paddy'),
		        'rubber' => $this->input->post('Rubber'),	
		        'coccoa' => $this->input->post('Coccoa'),
		        'coffe' => $this->input->post('Coffe'),	
		        'others' => $this->input->post('Others'),		        
		        'time' => $this->input->post('Year')		        			      
		        );
				//Transfering data to Model
				$this->Reporting_model->insert($data);
				if ($this->db->error()['message']) {
					$content["alert"] = 'alert-danger';
					$content["heading"] = 'Error';
					$content["message"] = '['.$this->db->error()['message'].']';
				} else if (!$this->db->affected_rows()) {
					$content["alert"] = 'alert-danger';
					$content["heading"] = 'Error';
					$content["message"] = "No affected rows";
				} else {
					$content["alert"] = 'alert-success';
					$content["heading"] = 'Well Done!';
					$content["message"] = "Data successfully inserted.";
				}
				$this->load->view('backend/reporting/result',$content);
			}
					
	        $this->load->view('backend_html_akhir');
	    }
	}
	
	public function edit($id)
	{
	    if($this->session->userdata('status') != "loginuser"){
	        redirect("login");
	    }else{
	        $awal["base_url"] = base_url();
	        $this->load->view('backend_html_awal', $awal);
	        $settings = $this->Setting_model->get_setting()->row();
			$menu["active_menu"] = 'reporting';
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);
			//if(empty($data))
			//	redirect("backend/reporting");
			$content["data"] = $this->Reporting_model->get_all_view_by_id($id)->row();
			$content["provinsi"] = $this->Setting_model->ambil_provinsi();
	        $this->load->view('backend/reporting/edit', $content);			
	        $this->load->view('backend_html_akhir');
	    }
	}
	
	public function update()
	{
	    if($this->session->userdata('status') != "loginuser"){
	        redirect("login");
	    }else{
	        $awal["base_url"] = base_url();
	        $this->load->view('backend_html_awal', $awal);
	        $settings = $this->Setting_model->get_setting()->row();
			$menu["active_menu"] = 'reporting';
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);		

			//$this->form_validation->set_rules('Province', 'Province', 'required', array('required' => 'You must complete %s.'));
			//$this->form_validation->set_rules('Kabupaten', 'Kabupatem', 'required', array('required' => 'You must complete %s.'));
			//$this->form_validation->set_rules('Kecamatan', 'Kecamatan', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('forest_gain', 'Forest Gain', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('oil_palm', 'Oil Palm', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('Rubber', 'Rubber', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('Coccoa', 'Coccoa', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('Coffe', 'Coffe', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('Others', 'Others', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('forest_loss', 'Forest Loss', 'required', array('required' => 'You must complete %s.'));
			//$this->form_validation->set_rules('Year', 'Year', 'required|exact_length[4]|integer', array('required' => 'You must complete %s.', 'exact_length' => 'The %s is four number', 'integer' => 'The %s must integer' ));			
			
			//$cekprovid=trim($this->input->post('province_id'));
			$cekprov= trim($this->input->post('provinsi_id'));
			$cekkab= trim($this->input->post('kabupaten_id'));
			$cekkec=trim($this->input->post('kecamatan_id'));
	
			
			if($cekprov=='-'){
				//die("MASUK");
				$id = $this->input->post('id');
				$data = $this->Reporting_model->get_by_id($id)->row();
				if(empty($data))
					redirect("backend/reporting");
				if ($this->form_validation->run() == FALSE)
				{
					$content["data"] = $data;
					$this->load->view('backend/reporting/edit', $content);		
				}else{			
					$data = array(
					'forest_gain' => $this->input->post('forest_gain'),	
					'forest_loss' => $this->input->post('forest_loss'),
					'oil_palm' => $this->input->post('oil_palm'),
					'paddy' => $this->input->post('Paddy'),
					'rubber' => $this->input->post('Rubber'),	
					'coccoa' => $this->input->post('Coccoa'),
					'coffe' => $this->input->post('Coffe'),	
					'others' => $this->input->post('Others'),		        
					'time' => $this->input->post('Year')
					);
					//Transfering data to Model
					$this->Reporting_model->update($id, $data);
					if ($this->db->error()['message']) {
						$content["alert"] = 'alert-danger';
						$content["heading"] = 'Error';
						$content["message"] = '['.$this->db->error()['message'].']';
					} else if (!$this->db->affected_rows()) {
						$content["alert"] = 'alert-warning';
						$content["heading"] = 'Warning';
						$content["message"] = "No affected rows";
					} else {
						$content["alert"] = 'alert-success';
						$content["heading"] = 'Well Done!';
						$content["message"] = "Data successfully updated.";
					}
					$this->load->view('backend/reporting/result',$content);
				}

			}else{
				$id = $this->input->post('id');
				$data = $this->Reporting_model->get_by_id($id)->row();
				if(empty($data))
					redirect("backend/reporting");
				if ($this->form_validation->run() == FALSE)
				{
					$content["data"] = $data;
					$this->load->view('backend/reporting/edit', $content);		
				}else{			
					$data = array(
					'province_id' => $this->input->post('provinsi_id'),
					'kabupaten_id' => $this->input->post('kabupaten_id'),
					'kecamatan_id' => $this->input->post('kecamatan_id'),
					'forest_gain' => $this->input->post('forest_gain'),	
					'forest_loss' => $this->input->post('forest_loss'),
					'oil_palm' => $this->input->post('oil_palm'),
					'paddy' => $this->input->post('Paddy'),
					'rubber' => $this->input->post('Rubber'),	
					'coccoa' => $this->input->post('Coccoa'),
					'coffe' => $this->input->post('Coffe'),	
					'others' => $this->input->post('Others'),		        
					'time' => $this->input->post('Year')
					);
					//Transfering data to Model
					$this->Reporting_model->update($id, $data);
					if ($this->db->error()['message']) {
						$content["alert"] = 'alert-danger';
						$content["heading"] = 'Error';
						$content["message"] = '['.$this->db->error()['message'].']';
					} else if (!$this->db->affected_rows()) {
						$content["alert"] = 'alert-warning';
						$content["heading"] = 'Warning';
						$content["message"] = "No affected rows";
					} else {
						$content["alert"] = 'alert-success';
						$content["heading"] = 'Well Done!';
						$content["message"] = "Data successfully updated.";
					}
					$this->load->view('backend/reporting/result',$content);
				}
			}				
	        $this->load->view('backend_html_akhir');
	    }
	}
	
	public function delete($id)
	{
	   if($this->session->userdata('status') != "loginuser"){
	        redirect("login");
	    }else{
	        $awal["base_url"] = base_url();
	        $this->load->view('backend_html_awal', $awal);
	        $settings = $this->Setting_model->get_setting()->row();
			$menu["active_menu"] = 'reporting';
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);
			$data = $this->Reporting_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/reporting");
			$content["data"] = $data;
	        $this->load->view('backend/reporting/delete', $content);			
	        $this->load->view('backend_html_akhir');
	    }
	}
	
	public function remove()
	{
	    if($this->session->userdata('status') != "loginuser"){
	        redirect("login");
	    }else{
	        $awal["base_url"] = base_url();
	        $this->load->view('backend_html_awal', $awal);
	        $settings = $this->Setting_model->get_setting()->row();
			$menu["active_menu"] = 'reporting';
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);		

			$id = $this->input->post('id');
			$data = $this->Reporting_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/reporting");
				//Transfering data to Model
			$this->Reporting_model->remove($id);
			if ($this->db->error()['message']) {
				$content["alert"] = 'alert-danger';
				$content["heading"] = 'Error';
				$content["message"] = '['.$this->db->error()['message'].']';
			} else if (!$this->db->affected_rows()) {
				$content["alert"] = 'alert-danger';
				$content["heading"] = 'Error';
				$content["message"] = "No affected rows";
			} else {
				$content["alert"] = 'alert-success';
				$content["heading"] = 'Well Done!';
				$content["message"] = "Data successfully deleted.";
			}
			$this->load->view('backend/reporting/result',$content);
	        $this->load->view('backend_html_akhir');
	    }
	}
}