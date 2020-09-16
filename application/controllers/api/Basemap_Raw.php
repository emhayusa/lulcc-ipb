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
        $this->load->model('api/basemap_model', 'model_basemap');   
    }

    function index(){
		$response = array(
		  'data' => 'api/basemap/data/<page>/<size>',
		  'id' => 'api/basemap/id/<id>');
		
		$this->output
		  ->set_status_header(200)
		  ->set_content_type('application/json', 'utf-8')
		  ->set_output(json_encode($response, JSON_PRETTY_PRINT))
		  ->_display();
		  exit;		  
	}
	
	function data($page = 1, $size = 10){
		$count = $this->model_basemap->count_all();
		$response = array(
		  'count' => $count,
		  'page' => intval($page),
		  'size' => intval($size),
		  'totalPages' => ceil($count/ $size),
		  'data' => $this->model_basemap->get_page(($page - 1) * $size, $size)->result());
		
		$this->output
		  ->set_status_header(200)
		  ->set_content_type('application/json', 'utf-8')
		  ->set_output(json_encode($response, JSON_PRETTY_PRINT))
		  ->_display();
		  exit;
	}
	
	
	function id($id){
		$row = $this->model_basemap->get_by_id($id)->row();
		if(!empty($row))
			$response['data'] = $row;
		else
			$response['message'] = 'no data found';
		$this->output
		  ->set_status_header(200)
		  ->set_content_type('application/json', 'utf-8')
		  ->set_output(json_encode($response, JSON_PRETTY_PRINT))
		  ->_display();
		  exit;
	}
	
    
}
    