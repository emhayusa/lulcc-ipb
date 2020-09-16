<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commodity extends CI_Controller {

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
		$this->load->model('Commodity_model', '', TRUE);
		$this->load->library(array('pagination','form_validation','upload'));
    }
    
	public function index()
	{
	    if($this->session->userdata('status') != "loginuser"){
	        redirect("login");
	    }else{
	        $awal["base_url"] = base_url();
	        $this->load->view('backend_html_awal', $awal);
			$menu["active_menu"] = 'commodity';
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);
			$content["datas"] = $this->Commodity_model->get_all()->result();
	        $this->load->view('backend/commodity/index', $content);
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
			$menu["active_menu"] = 'commodity';
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);			
	        $this->load->view('backend/commodity/add');			
	        $this->load->view('backend_html_akhir');
	    }
	}

	//uji coba testing
	public function inserto()
	{
		if($this->session->userdata('status') != "loginuser"){
			redirect("login");
		}else{
			$awal["base_url"] = base_url();
	        $this->load->view('backend_html_awal', $awal);
	        $settings = $this->Setting_model->get_setting()->row();
			$menu["active_menu"] = 'commodity';
	        $this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		
			
			$this->form_validation->set_rules('CommodityName', 'Commodity Name', 'required', array('required' => 'You must complete %s.'));
			//$this->form_validation->set_rules('Logo', 'Logo', 'required', array('required' => 'You must complete %s.'));

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('backend/commodity/add');		
			}else{
				//Config File Upload
				$config['upload_path'] = './assets/thumbnail/';
				$config['allowed_types'] = 'jpg|png|gif|jpeg|tiff';
				$config['max_size']	= '100000';			
					
				$Logo=$this->input->post('Logo');
				$this->upload->initialize($config);				
				if(!$this->upload->do_upload('Logo')){
					$Logo="";
				}else{
					$Logo=$this->upload->file_name;
				}

				//Tambahan
				$Logo_off=$this->input->post('Logo_off');
				$this->upload->initialize($config);				
				if(!$this->upload->do_upload('Logo_off')){
					$Logo_off="";
				}else{
					$Logo_off=$this->upload->file_name;
				}

				//die("$Logo.$Logo_off");
				$data = array(
					'commodity_name' => $this->input->post('CommodityName'),
					'thumbnail_on' => $Logo,
					'thumbnail_off' => $Logo_off  
					);
					//Transfering data to Model
					$this->Commodity_model->insert($data);
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
					$this->load->view('backend/commodity/result',$content);
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
			$menu["active_menu"] = 'commodity';
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);
			$data = $this->Commodity_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/commodity");
			$content["data"] = $data;
	        $this->load->view('backend/commodity/edit', $content);			
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
			$menu["active_menu"] = 'commodity';
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);		

			$this->form_validation->set_rules('CommodityName', 'Commodity Name', 'required', array('required' => 'You must complete %s.'));
			//$this->form_validation->set_rules('thumbnail', 'Thumbnail', 'required', array('required' => 'You must complete %s.'));			
			
			$id = $this->input->post('id');
			$data = $this->Commodity_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/commodity");
			if ($this->form_validation->run() == FALSE)
			{
				$content["data"] = $data;
				$this->load->view('backend/commodity/edit', $content);		
			}else{
				//Config File Upload
				$config['upload_path'] = './assets/thumbnail/';
				$config['allowed_types'] = 'jpg|png|gif|jpeg|tiff';
				$config['max_size']	= '100000';			
					
				$Logo=$this->input->post('Logo');
				$this->upload->initialize($config);				
				if(!$this->upload->do_upload('Logo')){
					$Logo="";
				}else{
					$Logo=$this->upload->file_name;
				}

				//Tambahan
				$Logo_off=$this->input->post('Logo_off');
				$this->upload->initialize($config);				
				if(!$this->upload->do_upload('Logo_off')){
					$Logo_off="";
				}else{
					$Logo_off=$this->upload->file_name;
				}
				//die("$Logo.$Logo_off");
				//Update
				if($Logo!="" && $Logo_off!=""){
					$data = array(
						'commodity_name' => $this->input->post('CommodityName'),
						'thumbnail_on' => $Logo,
						'thumbnail_off' => $Logo_off  
					);		
				}

				if($Logo=="" && $Logo_off!=""){
					$data = array(
						'commodity_name' => $this->input->post('CommodityName'),
						'thumbnail_off' => $Logo_off  
					);		
				}

				if($Logo!="" && $Logo_off==""){
					$data = array(
						'commodity_name' => $this->input->post('CommodityName'),
						'thumbnail_on' => $Logo
					);		
				}

				if($Logo=="" && $Logo_off==""){
					$data = array(
						'commodity_name' => $this->input->post('CommodityName')
					);		
				}
				
				
				//Transfering data to Model
				$this->Commodity_model->update($id, $data);
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
				$this->load->view('backend/commodity/result',$content);
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
			$menu["active_menu"] = 'commodity';
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);
			$data = $this->Commodity_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/commodity");
			$content["data"] = $data;
	        $this->load->view('backend/commodity/delete', $content);			
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
			$menu["active_menu"] = 'commodity';
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);		

			$id = $this->input->post('id');
			$data = $this->Commodity_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/commodity");
				//Transfering data to Model
			$this->Commodity_model->remove($id);
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
			$this->load->view('backend/commodity/result',$content);
	        $this->load->view('backend_html_akhir');
	    }
	}
}