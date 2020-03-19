<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller
{
    public function __construct(){
        parent::__construct();  
        $this->load->model('AdminModel');
        $this->load->helper('custom_helper');
        $this->load->library('admin/validation'); 

        if(($this->session->userdata('admin_id'))>0){
			//redirect(base_url('webpanel/'));
		}

    }

    public function index(){
    	$this->load->view('login');
    }

    public function login_auth()
    {
    	$data  = $this->input->post();
	
		$required_parameter = array('email','password');
	    $chk_error = $this->validation->check_required_value($required_parameter,$data);
	    $password = passwordGenerate($data['password']);
	    $where = array(
	    	'password'=>$password,
	    	'email'=>$data['email'],
	    	'user_role'=>'admin'
	    );

	    $select = 'user_id,name,mobile,email,user_role';
    	if(!empty($data = current($this->AdminModel->fetchQuery($select,'users',$where)))){
    		$whereActive = array('user_id'=>$data['user_id'],'user_status'=>1);
            if(($this->AdminModel->countQuery('users',$whereActive))<=0){
                $msg = array('message'=>'<strong>Opps!</strong> Account is not activated...','alert'=>'alert alert-danger');
                $this->session->set_flashdata('response',$msg);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $this->session->set_userdata('admin_id',$data['user_id']);
    		redirect(base_url('webpanel/'));
    		
    	}else{
    		$msg = array('message'=>'<strong>Opps!</strong> Invalid login details...','alert'=>'alert alert-danger');
	    	$this->session->set_flashdata('response',$msg);
	    	redirect($_SERVER['HTTP_REFERER']);
    	}
    }

}//class end
