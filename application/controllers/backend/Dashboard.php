<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
    }
    
	public function index()
	{
	    if($this->session->userdata('status') != "loginuser"){
	        redirect("login");
	    }else{
	        $awal["base_url"] = base_url();
	        $this->load->view('backend_html_awal', $awal);
	        $settings = $this->Setting_model->get_setting()->row();
	        $menu["active_menu"] = 'dashboard';
	        $this->load->view('backend_header', $menu);
	        $this->load->view('backend_menu', $menu);			
	        $this->load->view('backend/dashboard/index');
	        $this->load->view('backend_html_akhir');
	    }
	}	
}