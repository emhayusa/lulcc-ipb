<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Basemap extends CI_Controller {

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
		$this->load->model('Basemap_model', '', TRUE);
	}

	public function index()
	{
		if($this->session->userdata('status') != "loginuser"){
			redirect("login");
		}else{
			$awal["base_url"] = base_url();
			$this->load->view('backend_html_awal', $awal);
			$menu["active_menu"] = 'basemap';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$content["datas"] = $this->Basemap_model->get_all()->result();
			$this->load->view('backend/basemap/index', $content);
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
			$menu["active_menu"] = 'basemap';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);			
			$this->load->view('backend/basemap/add');			
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
			$menu["active_menu"] = 'basemap';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		

			$this->form_validation->set_rules('BasemapName', 'Basemap Name', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('URLBasemap', 'URL Basemap', 'required', array('required' => 'You must complete %s.'));
			//$this->form_validation->set_rules('Thumbnail', 'File input', 'required', array('required' => 'You must complete %s.'));

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('backend/basemap/add');		
			}else{
				$data = array(
					'basemap_name' => $this->input->post('BasemapName'),
					'url' => $this->input->post('URLBasemap'),
					'main' => 0,
					'active' => 0,
					'thumbnail' => $this->input->post('Thumbnail')		      
				);
				//Transfering data to Model
				$this->Basemap_model->insert($data);
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
				$this->load->view('backend/basemap/result',$content);
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
			$menu["active_menu"] = 'basemap';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$data = $this->Basemap_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/basemap");
			$content["data"] = $data;
			$this->load->view('backend/basemap/edit', $content);			
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
			$menu["active_menu"] = 'basemap';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		

			$this->form_validation->set_rules('BasemapName', 'Basemap Name', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('URLBasemap', 'URL Basemap', 'required', array('required' => 'You must complete %s.'));			
			$this->form_validation->set_rules('Thumbnail', 'File input', 'required', array('required' => 'You must complete %s.'));	
			
			$id = $this->input->post('id');
			$data = $this->Basemap_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/basemap");
			if ($this->form_validation->run() == FALSE)
			{
				$content["data"] = $data;
				$this->load->view('backend/basemap/edit', $content);		
			}else{
				$data = array(
					'basemap_name' => $this->input->post('BasemapName'),
					'url' => $this->input->post('URLBasemap'),					
					'thumbnail' => $this->input->post('Thumbnail')
				);
				//Transfering data to Model
				$this->Basemap_model->update($id, $data);
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
				$this->load->view('backend/basemap/result',$content);
			}

			$this->load->view('backend_html_akhir');
		}
	}

	public function update_config()
	{
		//$paket = $this->input->post();
		//var_dump($paket);
		//print_r($paket);
		//die('dsadsad');
		if($this->session->userdata('status') != "loginuser"){
			redirect("login");
		}else{
			//print_r();
			//$this->db->where('name',$key);
			$this->Basemap_model->reset();
			$active = $this->input->post('active');
			foreach ($active as $id) {
				# code...
				$data = array(
					'active' => 1
				);
				//Transfering data to Model
				$this->Basemap_model->update($id, $data);
			}

			$id =  $this->input->post('main');
			
			$data = array(
				'main' => 1
			);
				//Transfering data to Model
			//print_r($data);
			
			$this->Basemap_model->update($id, $data);
			if ($this->db->error()['message']) {
					//$content["alert"] = 'alert-danger';
					//$content["heading"] = 'Error';
				echo $this->db->error()['message'];
			} else if (!$this->db->affected_rows()) {
				echo "No affected rows";
			} else {
				echo "Sukses";
			}
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
			$menu["active_menu"] = 'basemap';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$data = $this->Basemap_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/basemap");
			$content["data"] = $data;
			$this->load->view('backend/basemap/delete', $content);			
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
			$menu["active_menu"] = 'basemap';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		

			$id = $this->input->post('id');
			$data = $this->Basemap_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/basemap");
				//Transfering data to Model
			$this->Basemap_model->remove($id);
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
			$this->load->view('backend/basemap/result',$content);
			$this->load->view('backend_html_akhir');
		}
	}
}