<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

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
		$this->load->model('Services_model', '', TRUE);
	}

	public function index()
	{
		if($this->session->userdata('status') != "loginuser"){
			redirect("login");
		}else{
			$awal["base_url"] = base_url();
			$this->load->view('backend_html_awal', $awal);
			$menu["active_menu"] = 'services';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$content["datas"] = $this->Services_model->get_all()->result();
			$this->load->view('backend/services/index', $content);
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
			$menu["active_menu"] = 'services';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);			
			$this->load->view('backend/services/add');			
			$this->load->view('backend_html_akhir');
		}
	}
	
	public function insert()
	{echo "sini";
	if($this->session->userdata('status') != "loginuser"){
		redirect("login");
	}else{
		$awal["base_url"] = base_url();
		$this->load->view('backend_html_awal', $awal);
		$settings = $this->Setting_model->get_setting()->row();
		$menu["active_menu"] = 'services';
		$this->load->view('backend_header', $menu);
		$this->load->view('backend_menu', $menu);	

		$this->form_validation->set_rules('ServicesType', 'Services Type', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('RoleId', 'Role Id', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('CommodityId', 'Commodity Id', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('ServicesName', 'Services Name', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('URLServices', 'URL Services', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('Layer', 'Layer');
		$this->form_validation->set_rules('definition', 'definition', 'required', array('required' => 'You must complete %s.'));			
		$this->form_validation->set_rules('Resolution', 'Resolution', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('Coverage', 'Coverage', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('DataSource', 'DataSource', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('Year', 'Year', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('Frequency', 'Frequency', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('Limitation', 'Limitation', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('License', 'License', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('Citation', 'Citation', 'required', array('required' => 'You must complete %s.'));

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('backend/services/add');		
		}else{
			$data = array(
				'type' => $this->input->post('ServicesType'),
				'commodity_id' => $this->input->post('CommodityId'),
				'role_id' => $this->input->post('RoleId'),
				'name' => $this->input->post('ServicesName'),
				'url' => $this->input->post('URLServices'),
				'layer' => $this->input->post('Layer'),
				'definition' => $this->input->post('definition'),
				'resolution' => $this->input->post('Resolution'),
				'coverage' => $this->input->post('Coverage'),
				'data_source' => $this->input->post('DataSource'),
				'year' => $this->input->post('Year'),
				'frequency' => $this->input->post('Frequency'),
				'limitation' => $this->input->post('Limitation'),			
				'license' => $this->input->post('License'),
				'citation' => $this->input->post('Citation')
			);
				//Transfering data to Model
			$this->Services_model->insert($data);
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
			$this->load->view('backend/services/result',$content);
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
		$menu["active_menu"] = 'services';
		$this->load->view('backend_header', $menu);
		$this->load->view('backend_menu', $menu);
		$data = $this->Services_model->get_by_id($id)->row();
		if(empty($data))
			redirect("backend/services");
		$content["data"] = $data;
		$this->load->view('backend/services/edit', $content);			
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
		$menu["active_menu"] = 'services';
		$this->load->view('backend_header', $menu);
		$this->load->view('backend_menu', $menu);

		$this->form_validation->set_rules('ServicesType', 'Services Type', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('RoleId', 'Role Id', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('CommodityId', 'Commodity Id', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('ServicesName', 'Services Name', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('URLServices', 'URL Services', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('Layer', 'Layer');
		$this->form_validation->set_rules('definition', 'Definition', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('Resolution', 'Resolution', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('Coverage', 'Coverage', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('DataSource', 'Data Source', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('Year', 'Year', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('Frequency', 'Frequency', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('Limitation', 'Limitation', 'required', array('required' => 'You must complete %s.'));		
		$this->form_validation->set_rules('License', 'License', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('Citation', 'Citation', 'required', array('required' => 'You must complete %s.'));

		$id = $this->input->post('id');
		$data = $this->Services_model->get_by_id($id)->row();
		if(empty($data))
			redirect("backend/services");
		if ($this->form_validation->run() == FALSE)
		{
			$content["data"] = $data;
			$this->load->view('backend/services/edit', $content);		
		}else{
			$data = array(
				'type' => $this->input->post('ServicesType'),
				'commodity_id' => $this->input->post('CommodityId'),
				'role_id' => $this->input->post('RoleId'),
				'name' => $this->input->post('ServicesName'),
				'url' => $this->input->post('URLServices'),
				'layer' => $this->input->post('Layer'),
				'definition' => $this->input->post('definition'),
				'resolution' => $this->input->post('Resolution'),
				'coverage' => $this->input->post('Coverage'),
				'data_source' => $this->input->post('DataSource'),
				'year' => $this->input->post('Year'),
				'frequency' => $this->input->post('Frequency'),
				'limitation' => $this->input->post('Limitation'),				
				'license' => $this->input->post('License'),
				'citation' => $this->input->post('Citation')
			);
				//Transfering data to Model
			$this->Services_model->update($id, $data);
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
			$this->load->view('backend/services/result',$content);
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
		$menu["active_menu"] = 'services';
		$this->load->view('backend_header', $menu);
		$this->load->view('backend_menu', $menu);
		$data = $this->Services_model->get_by_id($id)->row();
		if(empty($data))
			redirect("backend/services");
		$content["data"] = $data;
		$this->load->view('backend/services/delete', $content);			
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
		$menu["active_menu"] = 'services';
		$this->load->view('backend_header', $menu);
		$this->load->view('backend_menu', $menu);		

		$id = $this->input->post('id');
		$data = $this->Services_model->get_by_id($id)->row();
		if(empty($data))
			redirect("backend/services");
				//Transfering data to Model
		$this->Services_model->remove($id);
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
		$this->load->view('backend/services/result',$content);
		$this->load->view('backend_html_akhir');
	}
}
}