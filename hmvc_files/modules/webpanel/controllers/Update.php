<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends MY_Controller
{
    public function __construct(){
        parent::__construct();  
        $this->load->model('AdminModel');
        $this->load->helper('custom_helper');
        $this->load->library('admin/validation'); 
    }

    public function updatePassword()
    {
    	$data  = $this->input->post();
		$required_parameter = array('old_password','new_password','confirm_password');
	    $chk_error = $this->validation->check_required_value($required_parameter,$data);
	    $old_password = passwordGenerate($data['old_password']);
        $new_password = passwordGenerate($data['new_password']);
        if($data['confirm_password']!=$data['new_password']){
            $msg = array('message'=>'<strong>Opps!</strong> Confirm password is wrong...','alert'=>'alert alert-danger');
            $this->session->set_flashdata('response',$msg);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $admin_id = $this->session->userdata('admin_id');
	    $where = array(
	    	'password'=>$old_password,
            'user_id'=>$admin_id,
	    	'user_role'=>'admin'
	    );

    	if(($this->AdminModel->countQuery('users',$where))>0){
    		$this->AdminModel->updateQuery('users',array('password'=>$new_password),$where);
            $msg = array('message'=>'<strong>Congratulations!</strong> Password changed successfully...','alert'=>'alert alert-success');
            $this->session->set_flashdata('response',$msg);
    		
    	}else{
    		$msg = array('message'=>'<strong>Opps!</strong> Old password is wrong...','alert'=>'alert alert-danger');
	    	$this->session->set_flashdata('response',$msg);	    	
    	}
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function updateProfile()
    {
        $data  = $this->input->post();
        $required_parameter = array('name','email','mobile','about');
        $chk_error = $this->validation->check_required_value($required_parameter,$data);

        $admin_id = $this->session->userdata('admin_id');
        $where = array('user_id'=>$admin_id);

        $updateData = array(
            'name'=>$data['name'],
            'email'=>$data['email'],
            'mobile'=>$data['mobile'],
            'location_url'=>$data['about'],
        );

        if(!empty($this->AdminModel->updateQuery('users',$updateData,$where))){
            $msg = array('message'=>'<strong>Congratulations!</strong> Profile updated successfully...','alert'=>'alert alert-success');
            $this->session->set_flashdata('response',$msg);
            
        }else{
            $msg = array('message'=>'<strong>Opps!</strong> Profile updation problem...','alert'=>'alert alert-danger');
            $this->session->set_flashdata('response',$msg);         
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}//class end
