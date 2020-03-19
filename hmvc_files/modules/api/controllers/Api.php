<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MX_Controller
{
    public function __construct($config = 'rest'){
        parent::__construct($config);
        $this->load->model('APIModel');
        $this->load->helper('custom_helper');
        $this->load->library('custom');

        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Expose-Headers: Content-Length, X-JSON");
        header('Content-Type: application/json');
        
        if($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
           die();
        }

        if(($this->input->get_request_header('Authorization'))!='4N6N8uKp6kFTuIykltvdBBY59eGa36hdPudu'){
        	$error = array('code'=>401,'message'=>'Unauthorized access...');
        	echo json_encode($error); die();
        }
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
    	if(($this->APIModel->countQuery('users',$where))>0){
    		$resp = array('code'=>201,'status'=>false,'message'=>'Mobile number is already registered...','response'=>array('data'=>$mobile));
        	response($resp);
    	}else{
    		return true;
    	}
    }

    public function emailCheck($email=''){
    	$where = array('email'=>$email);
    	if(($this->APIModel->countQuery('users',$where))>0){
    		$resp = array('code'=>201,'status'=>false,'message'=>'Email is already registered...','response'=>array('data'=>$email));
        	response($resp);
    	}else{
    		return true;
    	}
    }

    public function auth_tokenCheck($token,$user_id){
    	if($user_id<=0 || $token==''){
    		$resp = array('code'=>201,'status'=>false,'message'=>'Invalid user or token...');
        	response($resp);
    	}
    	$where = array('token'=>$token,'user_id'=>$user_id);
    	if(($this->APIModel->countQuery('users',$where))<=0){
    		$resp = array('code'=>201,'status'=>false,'message'=>'Invalid token...');
    		response($resp);
    	}else{
    		return true;
    	}
    }

    public function locationCheck($data=''){
    	if(!preg_match('/http(s?)\:\/\//i',$data)) {
	    	$resp = array('code'=>201,'status'=>false,'message'=>'Invalid location url...');
	    	@response($resp);
		}
    }

	public function ownerRegister()
	{
		$data  = $this->input->post();
		
		$required_parameter = array('name','mobile','email','password','location_url','fcm_token');
	    $chk_error = $this->custom->check_required_value($required_parameter,$data);		
		
	    
	    $this->locationCheck($data['location_url']);
	    
	    $this->modileCheck($data['mobile']);
	    $this->emailCheck($data['email']);	    
	    $password = passwordGenerate($data['password']);

		$insertData = array(
			'name'=>ucwords($data['name']),
			'mobile'=>$data['mobile'],
			'email'=>strtolower($data['email']),
			'location_url'=>$data['location_url'],
			'user_role'=>'owner',
			'password'=>$password,
			'fcm_token'=>$data['fcm_token']
		);

		if(!empty($_FILES['drawing_file']['name'])){
		    $fileName = $this->singleImage('drawing_file','uploads/');

		    $insertData['file_name1']= $fileName['file_name'];
		    $insertData['file_ext1']  = $fileName['file_ext']; 
		}

		if(!empty($_FILES['list_file']['name'])){
		    $fileName = $this->singleImage('list_file','uploads/');

		    $insertData['file_name2']= $fileName['file_name'];
		    $insertData['file_ext2']  = $fileName['file_ext'];
		}

		$resp_data = array(
			'name'=>$data['name'],
			'mobile'=>$data['mobile'],
			'email'=>strtolower($data['email']),
			'location_url'=>$data['location_url'],
			'user_role'=>'owner',
		);
		if(($lastId = $this->APIModel->insertQuery('users',$insertData))>0)
		{
			$resp = array('code'=>200,'status'=>true,'message'=>'Registration success...','response'=>array('user' =>$resp_data));
            
		}else{
			$resp = array('success'=>400,'status'=>false,'message' => 'Registration failed...','response'=>array('user'=>$insertData));            
		}

		@response($resp);

	}

	public function supplierRegister()
	{
		
		$data  = $this->input->post();
		$required_parameter = array('name','mobile','email','password','location_url','fcm_token');
	    $chk_error = $this->custom->check_required_value($required_parameter,$data);

	    $this->locationCheck($data['location_url']);	    
	    $this->modileCheck($data['mobile']);
	    $this->emailCheck($data['email']);
	    $password = passwordGenerate($data['password']);

		$insertData = array(
			'name'=>ucwords($data['name']),
			'mobile'=>$data['mobile'],
			'email'=>strtolower($data['email']),
			'location_url'=>$data['location_url'],
			'user_role'=>'supplier',//strtolower($data['user_role']),
			'password'=>$password,
			'fcm_token'=>$data['fcm_token']
		);

		if(!empty($_FILES['cr_file']['name'])){
		    $fileName = $this->singleImage('cr_file','uploads/');

		    $insertData['file_name1']= $fileName['file_name'];
		    $insertData['file_ext1']  = $fileName['file_ext']; 
		}

		if(!empty($_FILES['subscription_file']['name'])){
		    $fileName = $this->singleImage('subscription_file','uploads/');

		    $insertData['file_name2']= $fileName['file_name'];
		    $insertData['file_ext2']  = $fileName['file_ext'];
		}

		if(($lastId = $this->APIModel->insertQuery('users',$insertData))>0)
		{
			
			if(!empty($data['product'])){			    

			    $product = (json_decode($data['product']));

			    $new_arr=array();
			    foreach($product as $row)
				{
				    $new_arr[] = $row->id;
				}
				$res_arr = implode(',',$new_arr);
				
			    $record = array(
		    		'user_id'=>$lastId,
		    		'product_id'=>$res_arr
		    	);
		    	$this->APIModel->insertQuery('supplier_products',$record);			    
			}

			$resp_data = array(
				'name'=>$data['name'],
				'mobile'=>$data['mobile'],
				'email'=>strtolower($data['email']),
				'location_url'=>$data['location_url'],
				'user_role'=>'owner'
			);

			$resp = array('code'=>200,'status'=>true,'message'=>'Registration success...','response'=>array('user' =>$resp_data));
            
		}else{
			$resp = array('success'=>400,'status'=>false,'message' => 'Registration failed...','response'=>array('user'=>$insertData));            
		}

		@response($resp);

	}

	public function login()
	{
		$data  = $this->input->post();
	
		$required_parameter = array('email','password','role','fcm_token');
	    $chk_error = $this->custom->check_required_value($required_parameter,$data);
	    $password = passwordGenerate($data['password']);
	    $where = array(
	    	'password'=>$password,
	    	'email'=>$data['email'],
	    	'user_role'=>$data['role']
	    );

	    $selectUser = 'user_id,name,mobile,email,location_url,user_role';
	    $selectAdmin = 'name,mobile,email,location_url';
    	if(!empty($user = current($this->APIModel->fetchQuery($selectUser,'users',$where)))){
    		$whereActive = array('user_id'=>$user['user_id'],'user_status'=>1);
            if(($this->APIModel->countQuery('users',$whereActive))<=0){
                $resp = array('code'=>400,'status'=>false,'message'=>' Account is not activated...','response'=>array('user'=>new stdClass()));
                response($resp);
            }

    		$token = auth_token();
    		$user['auth_token']=$token;
    		
    		$admin = current($this->APIModel->fetchQuery($selectAdmin,'users',array('user_role'=>'admin')));
    		$adminData = array(
    			'name'=>$admin['name'],
    			'mobile'=>$admin['mobile'],
    			'email'=>$admin['email'],
    			'about'=>$admin['location_url']
    		);	
    		$holData= array(
    			'user_id'=>$user['user_id'],
    			'name'=>$user['name'],
    			'mobile'=>$user['mobile'],
    			'email'=>$user['email'],
    			'location_url'=>$user['location_url'],
    			'user_role'=>$user['user_role'],
    			'user_role'=>$user['user_role'],
    			'admin'=>$adminData
    		);
    		$this->APIModel->updateQuery('users',array('fcm_token'=>$data['fcm_token'],'token'=>$token),$where);
    		$resp = array('code'=>200,'status'=>true,'message'=>'Login success...','response'=>array('user'=>$holData));

    	}else{
    		$resp = array('code'=>400,'status'=>false,'message'=>'Invalid login details...','response'=>array('user'=>new stdClass()));
    	}
    	response($resp);
	}

	public function productList()
	{
		$data  = $this->input->post();
		
	    $where = array('product_status'=>1);
	    $select = 'product_id,product_name';
    	if(!empty($prd = $this->APIModel->fetchQuery($select,'products',$where))){    		
    		
    		foreach($prd as $row){
	    		$record[] = array(
	    			'product_id'  =>$row['product_id'],
	    			'product_name'=>$row['product_name']
	    		);
    		}    		
    		$resp = array('code'=>200,'status'=>true,'message'=>'Success...','response'=>array('products'=>$record));

    	}else{
    		$resp = array('code'=>400,'status'=>false,'message'=>'Product not found...','response'=>array('products'=>[]));
    	}
    	response($resp);
	}

	public function supplierRegisterMultiImage()
	{
		$data  = $this->input->post();
		$token = $this->input->get_request_header('Authorization');
		
		$required_parameter = array('name','mobile','email','password','location_url','user_role');
	    $chk_error = $this->custom->check_required_value($required_parameter,$data);		
		
	    $password = md5($data['password']);
	    $this->modileCheck($data['mobile']);
	    $this->emailCheck($data['email']);
	    $this->tokenCheck($token);

		$inserData = array(
			'name'=>$data['name'],
			'mobile'=>$data['mobile'],
			'email'=>strtolower($data['email']),
			'location_url'=>$data['location_url'],
			'user_role'=>strtolower($data['user_role']),
			'password'=>$password,
			'token'=>$token
		);

		if(($lastId = $this->APIModel->insertQuery('users',$inserData))>0){
			
			if(!empty($_FILES['doc_files']['name'])){
			    $fileName = $this->dynamicImageUploadMultiple('doc_files','uploads/');

			    foreach($fileName as $row){
			    	$record = array(
			    		'user_id'=>$lastId,
			    		'doc_files'=>$row['file_name'],
			    		'file_extension'=>$row['file_ext']
			    	);
			    	$this->APIModel->insertQuery('user_meta',$record);
			    }
			}

			$resp = array('code'=>200,'message'=>'Registration success...','response'=>array('data' =>$inserData));
            
		}else{
			$resp = array('success'=>400,'message' => 'Registration failed...','response'=>array('data'=>$inserData));            
		}

		@response($resp);

	}
	
}//class end
