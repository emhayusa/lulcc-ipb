<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
    
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        setlocale(LC_ALL,'id_ID');
        $this->load->model('Login_model', '', TRUE);
        $this->load->model('Setting_model', '', TRUE);
    }
    
    
	public function index()
	{	
	    $setting= $this->Setting_model->get_setting()->row();
		$awal["base_url"] = base_url();
	    $awal["title"] = $setting->title;
	    $awal["logo"] = $setting->logo;
	    $this->load->view('html_awal', $awal);
	    $menu["active_menu"] = 'login';
	    $this->load->view('header', $menu);
		
		$this->form_validation->set_rules('username', 'Username', 'required', array('required' => 'You must complete %s.'));
		$this->form_validation->set_rules('password', 'Password', 'required', array('required' => 'You must complete %s.'));
		if ($this->form_validation->run() == FALSE)
		{
		    $this->load->view('frontend/login/index');
		}else{
		    $username = $this->input->post('username');
		    $password = $this->input->post('password');
		    $where = array(
		        'username' => $username,
		        'password' => md5($this->config->item('encryption_key').$password)
		    );
		    $cek = $this->Login_model->cek_data($where)->num_rows();
		    
		    if($cek > 0){
		        
		        $data_session = array(
		            'nama' => $username,
		            'status' => "loginuser"
		        );
		        
		        $this->session->set_userdata($data_session);
		        
		        redirect("backend/dashboard");
		        
		    }else{
		        $message =  "Invalid username and password!";
		        // Set flash data
		        $this->session->set_flashdata('message_name', $message);
		        $this->session->set_flashdata('class', 'alert alert-danger');
		        $this->load->view('frontend/login/index');
		    }
		}
		$footer["footer"] = $setting->footer;
		$this->load->view('footer', $footer);
		$this->load->view('html_akhir');
	}
	
	public function forgot()
	{
	    $setting= $this->Setting_model->get_setting()->row();
	    $awal["base_url"] = base_url();
	    $awal["title"] = $setting->title;
	    $awal["logo"] = $setting->logo;
	    $this->load->view('html_awal', $awal);
	    $menu["active_menu"] = 'login';
	    $this->load->view('header', $menu);
	    
	    $this->form_validation->set_rules('email', 'Email', 'required|valid_email', array('required' => 'Anda harus melengkapi %s.', 'valid_email' => 'Format %s harus valid.'));
	    
	    if ($this->form_validation->run() == FALSE)
	    {  
	        $this->load->view('frontend/login/forgot');
	    }else{
	        $email= $this->input->post('email');
	        $where = array(
	            'email' => $email
	        );
	        $cek = $this->User_model->cek_data($where)->num_rows();
	        
	        if($cek > 0){
	            
	            //email dikirimkan
	            //echo "email ditemukan";
	            if($this->kirim_email($email) == 'terkirim'){
	                $content["alert"] = 'alert-success';
	                $content["message"] = "Email anda ditemukan. Link reset password berhasil terkirim ke email Anda.";
	            }else{
	                $content["alert"] = 'alert-danger';
	                $content["message"] = "Email anda ditemukan. Link reset password gagal terkirim ke email Anda.";
    	        }
	            $this->load->view('frontend/login/forgot_result', $content);
	            
	        }else{
	            $message =  "Email tidak diketemukan";
	            // Set flash data
	            $this->session->set_flashdata('email', $email);
	            $this->session->set_flashdata('message_name_forgot', $message);
	            $this->session->set_flashdata('class_forgot', 'alert alert-danger');
	            $this->load->view('frontend/login/forgot');
	        }
	    }
	    
	    $footer["footer"] = $setting->footer;
	    $this->load->view('footer', $footer);
	    $this->load->view('html_akhir');
	}
	
	public function reset($token)
	{
	    $setting= $this->Setting_model->get_setting()->row();
	    $awal["base_url"] = base_url();
	    $awal["title"] = $setting->title;
		$awal["logo"] = $setting->logo;
	    $this->load->view('html_awal', $awal);
	    $menu["active_menu"] = 'login';
	    $this->load->view('header', $menu);
	    
	    //cek token dan expired
	    $cek_token = $this->Reset_password_model->cek_token($token)->num_rows();
	    if($cek_token > 0){
	   	  
	    $this->form_validation->set_rules('token', 'Token', 'required', array('required' => '%s tidak ada.'));
	    $this->form_validation->set_rules('password', 'Password', 'required', array('required' => 'Anda harus melengkapi %s.'));
	    $this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]', array('required' => 'Anda harus melengkapi %s.', 'matches' => '%s tidak sama dengan %s'));
	    
	    
	    if ($this->form_validation->run() == FALSE)
	    {
	        $content["token"] = $token;
	        $this->load->view('frontend/login/reset', $content);
	    }else{
	        $tokens =  $this->Reset_password_model->get_reset_password_by_token($this->input->post('token'))->row();
	        $data = array(
	            'password' => md5($this->input->post('password').$this->config->item('encryption_key'))
	        );
	        //Transfering data to Model
	        $this->Registrasi_model->update($tokens->registrasi_id,$data);
	        if ($this->db->error()['message']) {
	            $content["alert"] = 'alert-danger';
	            $content["heading"] = 'Error';
	            $content["message"] = '['.$this->db->error()['message'].']';
	        } else if (!$this->db->affected_rows()) {
	            $content["alert"] = 'alert-danger';
	            $content["heading"] = 'Error';
	            $content["message"] = "No affected rows";
	        } else {
	            if($this->kirim_email_reset($tokens->registrasi_id) == 'terkirim'){
	                $content["alert"] = 'alert-success';
	                $content["heading"] = 'Well Done!';
	                $content["message"] = "Password Anda sudah berhasil diubah. Notifikasi ke email berhasil terkirim.";	                
	            }else{
	                $content["alert"] = 'alert-danger';
	                $content["heading"] = 'Error';
	                $content["message"] = "Password Anda sudah berhasil diubah. Notifikasi ke email gagal terkirim.";
	            }
	        }
	        $this->load->view('frontend/login/reset_result', $content);
	    }
	   }else{
	        $content["cek_token"] = false;
	        $this->load->view('login_reset', $content);
	   }
	    
	   $footer["footer"] = $setting->footer;
	   $this->load->view('footer', $footer);
	    $this->load->view('html_akhir');
	}
	
	private function kirim_email($email){
	    //ambil row id
	        //$email = "emhayusa@gmail.com";
	        $registrasi = $this->Registrasi_model->get_registrasi_by_email($email)->row();
	        //var_dump($registrasi);
	        if(!empty($registrasi)){
	            $email= $registrasi->email;
	            $current_date = date('Y-m-d H:i:s');
	            $newTime = date("Y-m-d H:i:s",strtotime("+15 minutes", strtotime($current_date)));
	            $token = md5($newTime.'emh4b1g');
	            $link = base_url("login/reset/".$token);
	            //echo $link;
	            
	            $this->load->config('email');
	            
	            $from = $this->config->item('smtp_user');
	            $alias = $this->config->item('smtp_user_alias');
	            
	            $this->load->library('email');
	            $this->email->set_newline("\r\n");
	            $this->email->from($from,$alias);
	            $this->email->to($email);
	            //$CI->email->bcc('pansel@big.go.id');
	            $body = "
        		<p>Yth. Bapak/ibu,</p>
                <p>Silahkan klik link berikut untuk melakukan reset password: <a href='".$link."'>".$link."</a></p>
                <p>Link tersebut hanya berlaku selama 15 menit ke depan.</p>    
                <p>Abaikan email ini jika Anda merasa tidak melakukan permintaan reset password.</p>   
                    
        		<p>Terimakasih.</p>
        		";
	            $subject = "[Portal Marina] Reset Password";
	            
	            // echo $subject;
	            
	            $this->email->subject($subject);
	            $this->email->message($body);
	            
	            if($this->email->send())
	            {
	                $data = array(
	                    'registrasi_id' => $registrasi->id_registrasi,
	                    'expired_time' => $newTime,
	                    'token' => $token
	                );
	                //Transfering data to Model
	                $this->Reset_password_model->insert($data);
	                if ($this->db->error()['message']) {
                        return  '['.$this->db->error()['message'].']';
	                } else if (!$this->db->affected_rows()) {
	                    return "error no affected rows";
	                } else {
	                    return "terkirim";
	                }
	                
	
	            }
	            else
	            {
	                return $this->email->print_debugger();
	                
	            }
	        }
	}
	
	private function kirim_email_reset($id){
	    //ambil row id
	    //$email = "emhayusa@gmail.com";
	    $registrasi = $this->Registrasi_model->get_registrasi_by_id($id)->row();
	    //var_dump($registrasi);
	    if(!empty($registrasi)){
	        $email= $registrasi->email;
	        
	        $this->load->config('email');
	        
	        $from = $this->config->item('smtp_user');
	        $alias = $this->config->item('smtp_user_alias');
	        
	        $this->load->library('email');
	        $this->email->set_newline("\r\n");
	        $this->email->from($from,$alias);
	        $this->email->to($email);
	        //$CI->email->bcc('pansel@big.go.id');
	        $body = "
        		<p>Yth. Bapak/ibu,</p>
                <p>Perubahan password akun Portal KGI Anda berhasil dilakukan.</p>
                    
        		<p>Terimakasih.</p>
        		";
	        $subject = "[Portal KGI] Password Berubah";
	        
	        // echo $subject;
	        
	        $this->email->subject($subject);
	        $this->email->message($body);
	        
	        if($this->email->send())
	        {
	                return "terkirim";   
	        }
	        else
	        {
	            return $this->email->print_debugger();
	            
	        }
	    }
	}
	    
	public function logout(){
	    $this->session->sess_destroy();
	    redirect('login');
	}
}
