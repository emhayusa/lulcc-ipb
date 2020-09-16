<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Contact extends CI_Controller {
    
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
       // $this->load->model('service_model');
        //$this->load->model('jign_model');        
    }
    
    public function index()
	{	
	    //$setting= $this->Setting_model->get_setting()->row();
		//die("test");
		$awal["base_url"] = base_url();
		$awal["controller"] = 'Contact';
	    $this->load->view('frontend/html_awal', $awal);
	    $menu["active_menu"] = 'contact';
	    $this->load->view('frontend/header', $menu);
	    $this->load->view('frontend/contact/index');
		$this->load->view('frontend/footer');
		$this->load->view('frontend/html_akhir');
	}
}
    