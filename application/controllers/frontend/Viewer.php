<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Viewer extends CI_Controller {
    
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
        $this->load->model('Setting_model', '', TRUE);
        $this->load->model('api/basemap_model', 'model_basemap', TRUE);   
        $this->load->model('api/subheader_model', 'model_subheader', TRUE);   
        $this->load->model('api/commodity_model', 'model_commodity', TRUE);   
        //$this->load->model('jign_model');        
    }
    
    public function index()
	{	
	    //$setting= $this->Setting_model->get_setting()->row();
		//die("test");
		$content["base_url"] = base_url();
		$setting= $this->Setting_model->get_setting()->row();
		//var_dump($setting);
		//die();
		$content["title"] = $setting->title;
		$content["about"] = $setting->about;
		$basemaps = $this->model_basemap->get_all()->result();
		$content["basemaps"] = $basemaps;
		$subheaders = $this->model_subheader->get_all()->result();
		$content["subheaders"] = $subheaders;
		
		$services_subheader = $this->model_commodity->get_all_service_subheader()->result();
		$content["services_subheaders"] = $services_subheader;
		$services_no_subheader = $this->model_commodity->get_all_service_no_subheader()->result();
		//var_dump($services_no_subheader);
		//die();
		$content["services_no_subheader"] = $services_no_subheader;
	
		$this->load->view('frontend/viewer/index', $content);
		
	}
}
    