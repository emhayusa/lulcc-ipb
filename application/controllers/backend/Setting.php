<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

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
		$this->load->library(array('pagination','form_validation','upload'));
	}

	public function index()
	{
		if($this->session->userdata('status') != "loginuser"){
			redirect("login");
		}else{
			$awal["base_url"] = base_url();
			$this->load->view('backend_html_awal', $awal);
			$menu["active_menu"] = 'setting';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$content["datas"] = $this->Setting_model->get_all()->result();
			$this->load->view('backend/setting/index', $content);
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
			$menu["active_menu"] = 'setting';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);			
			$this->load->view('backend/setting/add');			
			$this->load->view('backend_html_akhir');
		}
	}
	public function insert()
	{
		if($this->session->userdata('status') != "loginuser"){
			redirect("login");
		}else{
			$awal["base_url"] = base_url();
			$this->load->view('backend_html_awal', $awal);
			$settings = $this->Setting_model->get_setting()->row();
			$menu["active_menu"] = 'setting';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		

			$this->form_validation->set_rules('Logo', 'Logo', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('Title', 'Title', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('Footer', 'Footer', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('About', 'About', 'required', array('required' => 'You must complete %s.'));			
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('backend/setting/add');		
			}else{
				$data = array(
					'logo' => $this->input->post('Logo'),
					'title' => $this->input->post('Title'),
					'footer' => $this->input->post('Footer'),
					'about' => $this->input->post('About')
				);
				//Transfering data to Model
				$this->Setting_model->insert($data);
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
				$this->load->view('backend/setting/result',$content);
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
			$menu["active_menu"] = 'setting';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$data = $this->Setting_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/setting");
			$content["data"] = $data;
			$this->load->view('backend/setting/edit', $content);			
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
			$menu["active_menu"] = 'setting';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		

			$this->form_validation->set_rules('Title', 'Title', 'required', array('required' => 'You must complete %s.'));
			
			
			
			$id = $this->input->post('id');
			$data = $this->Setting_model->get_by_id($id)->row();
			
			if(empty($data)){
				redirect("backend/setting");
			}
			if ($this->form_validation->run() == FALSE)
			{
				$content["data"] = $data;
				$this->load->view('backend/setting/edit', $content);		
			}else{
				$Logo=$this->input->post('Logo');
				
				$config['upload_path'] = './assets/images/';
				$config['allowed_types'] = 'jpg|png|gif';
				$config['max_size']	= '100000';			
				 
        		$this->upload->initialize($config);				
        		if(!$this->upload->do_upload('Logo')){
            		$Logo="";
       			}else{
            		$Logo=$this->upload->file_name;
				}
				
				//Update
				if($Logo==""){
					$data = array(
						'title' => $this->input->post('Title'),
						'footer' => $this->input->post('Footer'),
						'about' => $this->input->post('About')					
					);		
				}else{
					$data = array(
						'logo' => $Logo,
						'title' => $this->input->post('Title'),
						'footer' => $this->input->post('Footer'),
						'about' => $this->input->post('About')					
					);
				}
				$this->Setting_model->update($id, $data);
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
				$this->load->view('backend/setting/result',$content);
			}
			$this->load->view('backend_html_akhir');
		}
	}	

	
}