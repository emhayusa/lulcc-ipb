<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tutorial extends CI_Controller {

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
		$this->load->model('Tutorial_model', '', TRUE);
	}

	public function index()
	{
		if($this->session->userdata('status') != "loginuser"){
			redirect("login");
		}else{
			$awal["base_url"] = base_url();
			$this->load->view('backend_html_awal', $awal);
			$menu["active_menu"] = 'tutorial';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$content["datas"] = $this->Tutorial_model->get_all()->result();
			$this->load->view('backend/tutorial/index', $content);
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
			$menu["active_menu"] = 'tutorial';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);			
			$this->load->view('backend/tutorial/add');			
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
			$menu["active_menu"] = 'tutorial';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		

			$this->form_validation->set_rules('TutorialTitle', 'Tutorial Title', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('media_type', 'Type of Media', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('active', 'Active ?', 'required', array('required' => 'You must complete %s.'));			
			$this->form_validation->set_rules('Thumbnail', 'Thumbnail', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('URLTutorial', 'URL Tutorial', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('UploadFile', 'Upload File', 'required', array('required' => 'You must complete %s.'));
			
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('backend/tutorial/add');		
			}else{
				$data = array(
					'title' => $this->input->post('TutorialTitle'),
					'media_type' => $this->input->post('media_type'),
					'active' => $this->input->post('active'),
					'thumbnail' => $this->input->post('Thumbnail'),	
					'url' => $this->input->post('URLTutorial'),
					'file' => $this->input->post('UploadFile')
				);
				//Transfering data to Model
				$this->Tutorial_model->insert($data);
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
				$this->load->view('backend/tutorial/result',$content);
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
			$menu["active_menu"] = 'tutorial';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$data = $this->Tutorial_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/tutorial");
			$content["data"] = $data;
			$this->load->view('backend/tutorial/edit', $content);			
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
			$menu["active_menu"] = 'tutorial';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		

			$this->form_validation->set_rules('TutorialTitle', 'Tutorial Title', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('media_type', 'Media Type', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('active', 'Active', 'required', array('required' => 'You must complete %s.'));			
			$this->form_validation->set_rules('Thumbnail', 'Thumbnail', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('URLTutorial', 'URL Tutorial', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('UploadFile', 'Upload File', 'required', array('required' => 'You must complete %s.'));	
			
			$id = $this->input->post('id');
			$data = $this->Tutorial_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/tutorial");
			if ($this->form_validation->run() == FALSE)
			{
				$content["data"] = $data;
				$this->load->view('backend/tutorial/edit', $content);		
			}else{
				$data = array(
					'title' => $this->input->post('TutorialTitle'),
					'media_type' => $this->input->post('MediaType'),
					'active' => $this->input->post('active'),
					'thumbnail' => $this->input->post('Thumbnail'),	
					'url' => $this->input->post('URLTutorial'),
					'file' => $this->input->post('UploadFile')					
				);
				//Transfering data to Model
				$this->Tutorial_model->update($id, $data);
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
				$this->load->view('backend/tutorial/result',$content);
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
			$menu["active_menu"] = 'tutorial';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$data = $this->Tutorial_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/tutorial");
			$content["data"] = $data;
			$this->load->view('backend/tutorial/delete', $content);			
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
			$menu["active_menu"] = 'tutorial';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		

			$id = $this->input->post('id');
			$data = $this->Tutorial_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/tutorial");
				//Transfering data to Model
			$this->Tutorial_model->remove($id);
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
			$this->load->view('backend/tutorial/result',$content);
			$this->load->view('backend_html_akhir');
		}
	}
}