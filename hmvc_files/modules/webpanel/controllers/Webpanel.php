<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webpanel extends MY_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('AdminModel');
        $this->load->helper('custom_helper');
        $this->load->library('admin/validation');
    }

    public function index(){
    	
    	$data['totalOwner'] = $this->AdminModel->countQuery('users',array('user_role'=>'owner'));
    	$data['totalSupplier'] = $this->AdminModel->countQuery('users',array('user_role'=>'supplier'));

    	$this->adminHeader();
    	$this->load->view('dashboard',$data);
    	$this->adminFooter();    	
    }

    public function singleImage($name,$path,$url='')
	{
	    $config['allowed_types'] = '*';
	    $config['upload_path']   = $path;        

	    $this->load->library('upload', $config);
	    $this->upload->initialize($config);

	    if($this->upload->do_upload($name)){
	        $data = $this->upload->data();	        
	        return array("file_name"=>$data['file_name'],"file_ext"=>$data['file_ext']);	       
	    }
	    else
	    {
	        $error = $this->upload->display_errors();
	        $str = array("<p>","</p>");
	        $error = str_replace($str,'',$error);
	        $resp = array('code'=>201,'status'=>false,'message'=>$error,'response'=>array('data'=>$error));
        	response($resp);           
	    }
	}

	public function dynamicImageUploadMultiple($name,$folder)
	{         
	    $imageArray = array();
	    $ImageCount = count($_FILES[$name]['name']);

	    for($i=0;$i<$ImageCount; $i++)
	    {
	        $_FILES['file']['name']       = $_FILES[$name]['name'][$i];
	        $_FILES['file']['type']       = $_FILES[$name]['type'][$i];
	        $_FILES['file']['tmp_name']   = $_FILES[$name]['tmp_name'][$i];
	        $_FILES['file']['error']      = $_FILES[$name]['error'][$i];
	        $_FILES['file']['size']       = $_FILES[$name]['size'][$i];

	        $config['allowed_types']  = '*';
	        $config['upload_path'] = $folder;

	        $this->load->library('upload',$config);
	        $this->upload->initialize($config);

	        if($this->upload->do_upload('file'))
	        {                
	            $data = $this->upload->data();                
	            //$uploadImgData[$i][$name] = $data['file_name'];
	            $uploadImgData[$i][$name] = array("file_name"=>$data['file_name'],"file_ext"=>$data['file_ext']);	            
	            $imageArray[] = $uploadImgData[$i][$name];	            

	        }else{	            
	            $error = $this->upload->display_errors();
		        $str = array("<p>","</p>");
		        $error = str_replace($str,'',$error);
		        $resp = array('code'=>201,'status'=>false,'message'=>$error,'response'=>array('data'=>$error));
	        	response($resp); 
	        }
	    }
	    return $imageArray;	    

	}

    public function modileCheck($mobile=''){
    	$where = array('mobile'=>$mobile);
    	if(($this->AdminModel->countQuery('users',$where))>0){
    		$msg = array('message'=>'<strong>Opps!</strong> Mobile number is already registered...','alert'=>'alert alert-danger');
	    	$this->session->set_flashdata('response',$msg);
	    	redirect($_SERVER['HTTP_REFERER']);
    	}else{
    		return true;
    	}
    }

    public function emailCheck($email=''){
    	$where = array('email'=>$email);
    	if(($this->AdminModel->countQuery('users',$where))>0){    		
        	$msg = array('message'=>'<strong>Opps!</strong> Email is already registered...','alert'=>'alert alert-danger');
	    	$this->session->set_flashdata('response',$msg);
	    	redirect($_SERVER['HTTP_REFERER']);
    	}else{
    		return true;
    	}
    }

	public function ownerRegister()
	{
		$data  = $this->input->post();
		
		$required_parameter = array('name','mobile','email','password','location_url','fcm_token');
	    $chk_error = $this->custom->check_required_value($required_parameter,$data);		
		
	    $password = passwordGenerate($data['password']);
	    $this->modileCheck($data['mobile']);
	    $this->emailCheck($data['email']);	    

		$insertData = array(
			'name'=>$data['name'],
			'mobile'=>$data['mobile'],
			'email'=>strtolower($data['email']),
			'location_url'=>$data['location_url'],
			'user_role'=>'owner',
			'password'=>$password,
			'fcm_token'=>$data['fcm_token']
		);


		if(($lastId = $this->AdminModel->insertQuery('users',$insertData))>0)
		{
			
			if(!empty($_FILES['drawing_file']['name'])){
			    $fileName = $this->singleImage('drawing_file','uploads/');

			    $record = array(
		    		'user_id'=>$lastId,
		    		'file_name'=>$fileName['file_name'],
		    		'file_ext'=>$fileName['file_ext']
		    	);
		    	$this->AdminModel->insertQuery('user_meta',$record);
			    
			}

			if(!empty($_FILES['list_file']['name'])){
			    $fileName = $this->singleImage('list_file','uploads/');

			    $record = array(
		    		'user_id'=>$lastId,
		    		'file_name'=>$fileName['file_name'],
		    		'file_ext'=>$fileName['file_ext']
		    	);
		    	$this->AdminModel->insertQuery('user_meta',$record);			    
			}

			$resp = array('code'=>200,'message'=>'Registration success...','response'=>array('data' =>$insertData));
            
		}else{
			$resp = array('success'=>400,'message' => 'Registration failed...','response'=>array('data'=>$insertData));            
		}

		@response($resp);

	}

	public function productList()
	{
		$data  = $this->input->post();
		
	    $where = array('product_status'=>1);
	    $select = 'product_id,product_name';
    	if(!empty($data = $this->AdminModel->fetchQuery($select,'products',$where))){    		
    		
    		foreach($data as $row){
	    		$record[] = array(
	    			'product_id'  =>$row['product_id'],
	    			'product_name'=>$row['product_name']
	    		);
    		}    		
    		$resp = array('code'=>200,'status'=>true,'message'=>'Success...','response'=>array('products'=>$record));

    	}else{
    		$resp = array('code'=>400,'status'=>false,'message'=>'Product not found...','response'=>array('products'=>$token));
    	}
    	response($resp);
	}

	public function logout(){
    	$this->session->sess_destroy();
    	redirect(base_url('webadmin/'));

    }
}//class end
