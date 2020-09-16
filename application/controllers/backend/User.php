<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
		$this->load->model('User_model', '', TRUE);
		$this->load->model('Role_model', '', TRUE);
	}

	public function index()
	{
		if($this->session->userdata('status') != "loginuser"){
			redirect("login");
		}else{
			$awal["base_url"] = base_url();
			$this->load->view('backend_html_awal', $awal);
			$menu["active_menu"] = 'user';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$content["datas"] = $this->User_model->get_all()->result();
			$this->load->view('backend/user/index', $content);
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
			$menu["active_menu"] = 'user';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);	
			$content["datas"] = $this->Role_model->get_all()->result();		
			$this->load->view('backend/user/add', $content);			
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
			$menu["active_menu"] = 'user';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		

			$this->form_validation->set_rules('FullName', 'Full Name', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('UserName', 'User Name', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('Password', 'Password', 'required', array('required' => 'You must complete %s.'));	
			$this->form_validation->set_rules('Password2', 'Re-Type Password', 'required|matches[Password]', array('required' => 'Anda harus melengkapi %s.', 'matches' => '%s tidak sama dengan %s'));		
			$this->form_validation->set_rules('Email', 'Email', 'required|valid_email', array('required' => 'You must complete %s.', 'valid_email' => 'Format %s tidak valid'));
			$this->form_validation->set_rules('Role', 'Role', 'required', array('required' => 'You must complete %s.'));
			
			if ($this->form_validation->run() == FALSE)
			{

				$content["datas"] = $this->Role_model->get_all()->result();		
				$this->load->view('backend/user/add', $content);	
			}else{
				$data = array(
					'fullname' => $this->input->post('FullName'),
					'role_id' => $this->input->post('Role'),
					'username' => $this->input->post('UserName'),
					'password' => md5($this->config->item('encryption_key').$this->input->post('Password') ),
					'email' => $this->input->post('Email')
				);

				//Transfering data to Model
				$this->User_model->insert($data);
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
				$this->load->view('backend/user/result',$content);
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
			$menu["active_menu"] = 'user';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$data = $this->User_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/user");
			$content["data"] = $data;
			$content["datas"] = $this->Role_model->get_all()->result();					
			$this->load->view('backend/user/edit', $content);			
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
			$menu["active_menu"] = 'user';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);	

			$this->form_validation->set_rules('FullName', 'Full Name', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('Email', 'Email', 'required', array('required' => 'You must complete %s.'));
			$this->form_validation->set_rules('Role', 'Role', 'required', array('required' => 'You must complete %s.'));						
			
			$id = $this->input->post('id');
			$data = $this->User_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/user");
			if ($this->form_validation->run() == FALSE)
			{
				$content["data"] = $data;
				$content["datas"] = $this->Role_model->get_all()->result();	
				$this->load->view('backend/user/edit', $content);		
			}else{
				$data = array(
					'fullname' => $this->input->post('FullName'),
					'role_id' => $this->input->post('Role'),
					'email' => $this->input->post('Email')
				);
				//Transfering data to Model
				$this->User_model->update($id, $data);
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
				$this->load->view('backend/user/result',$content);
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
			$menu["active_menu"] = 'user';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);
			$data = $this->User_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/user");
			$content["data"] = $data;
			$this->load->view('backend/user/delete', $content);			
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
			$menu["active_menu"] = 'user';
			$this->load->view('backend_header', $menu);
			$this->load->view('backend_menu', $menu);		

			$id = $this->input->post('id');
			$data = $this->User_model->get_by_id($id)->row();
			if(empty($data))
				redirect("backend/user");
				//Transfering data to Model
			$this->User_model->remove($id);
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
			$this->load->view('backend/user/result',$content);
			$this->load->view('backend_html_akhir');
		}
	}
}