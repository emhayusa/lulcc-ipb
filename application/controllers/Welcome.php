<?php    
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	
	function __construct(){
        parent::__construct();
    }
    
	public function index()
	{
		redirect('frontend/home');
	}
/*
require_once(APPPATH.'controllers/frontend/Home.php');    

class Welcome extends home {    
    public function index() {
        $this->index();
    }    
}

*/

}