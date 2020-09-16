<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Province extends CI_Controller {

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
		$this->load->model('Province_model', '', TRUE);
	}

	public function index()
	{
		if($this->session->userdata('status') != "loginuser"){
			redirect("login");
		}else{
			$awal["base_url"] = base_url();
			$this->load->view('backend_html_awal', $awal);
			$menu["active_menu"] = 'province';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$content["datas"] = $this->Province_model->get_all()->result();
			$this->load->view('backend/province/index', $content);
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
			$menu["active_menu"] = 'province';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);			
			$this->load->view('backend/province/add');			
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
			$menu["active_menu"] = 'province';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		

			$this->form_validation->set_rules('ProvinceName', 'Province Name', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('ProvinceCode', 'Province Code', 'required', array('required' => 'You must complete %s.'));			
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('backend/province/add');		
			}else{
				$data = array(
					'nama_provinsi' => $this->input->post('ProvinceName'),
					'id_provinsi' => $this->input->post('ProvinceCode')						      
				);
				//Transfering data to Model
				$this->Province_model->insert($data);
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
				$this->load->view('backend/province/result',$content);
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
			$menu["active_menu"] = 'province';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$data = $this->Province_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/province");
			$content["data"] = $data;
			$this->load->view('backend/province/edit', $content);			
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
			$menu["active_menu"] = 'province';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		

			$this->form_validation->set_rules('ProvinceName', 'Province Name', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('ProvinceCode', 'Province Code', 'required', array('required' => 'You must complete %s.'));	
			
			$id = $this->input->post('id');
			$data = $this->Province_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/province");
			if ($this->form_validation->run() == FALSE)
			{
				$content["data"] = $data;
				$this->load->view('backend/province/edit', $content);		
			}else{
				$data = array(
					'nama_provinsi' => $this->input->post('ProvinceName'),
					'id_provinsi' => $this->input->post('ProvinceCode')	
				);
				//Transfering data to Model
				$this->Province_model->update($id, $data);
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
				$this->load->view('backend/province/result',$content);
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
			$menu["active_menu"] = 'province';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$data = $this->Province_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/province");
			$content["data"] = $data;
			$this->load->view('backend/province/delete', $content);			
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
			$menu["active_menu"] = 'province';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		

			$id = $this->input->post('id');
			$data = $this->Province_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/province");
				//Transfering data to Model
			$this->Province_model->remove($id);
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
			$this->load->view('backend/province/result',$content);
			$this->load->view('backend_html_akhir');
		}
	}
}