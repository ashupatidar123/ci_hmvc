<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View extends MY_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('AdminModel');
        $this->load->helper('custom_helper');
        $this->load->library('admin/validation');
        $this->load->library('comman_controller'); 
    }

    public function changePassword(){
        $this->adminHeader();
        $this->load->view('changePassword');
        $this->adminFooter();       
    }

    public function adminProfile(){

        $admin_id = $this->session->userdata('admin_id');
        $where = array('user_id'=>$admin_id);
        $select = 'name,mobile,email,location_url';
        $data['record'] = current($this->AdminModel->fetchQuery($select,'users',$where));
            
        $this->adminHeader();
        $this->load->view('adminProfile',$data);
        $this->adminFooter();       
    }

    public function ownerList(){

        $admin_id = $this->session->userdata('admin_id');
        $where = array('user_role'=>'owner');
        $select = 'user_id,name,mobile,email,location_url,user_status,file_name1,file_name2,file_ext1,file_ext2,register_date';
        $data['record'] = $this->AdminModel->fetchQuery($select,'users',$where,'user_id','DESC');
        $this->adminHeader();
        $this->load->view('ownerList',$data);
        $this->adminFooter();       
    }

    public function supplierList(){

        $admin_id = $this->session->userdata('admin_id');
        $where = array('user_role'=>'supplier');
        $select = 'user_id,name,mobile,email,location_url,user_status,file_name1,file_name2,file_ext1,file_ext2,register_date';
        $data['record'] = $this->AdminModel->fetchQuery($select,'users',$where,'user_id','DESC');
        $this->adminHeader();
        $this->load->view('supplierList',$data);
        $this->adminFooter();       
    }

    public function productList(){

        $admin_id = $this->session->userdata('admin_id');
        $where = array('user_role'=>'owner');
        $select = 'user_id,name,mobile,email,location_url,user_status,file_name1,file_name2,file_ext1,file_ext2,register_date';
        $data['record'] = $this->AdminModel->fetchQuery($select,'users',$where,'user_id','DESC');
        $this->adminHeader();
        $this->load->view('productList',$data);
        $this->adminFooter();       
    }


}//class end
