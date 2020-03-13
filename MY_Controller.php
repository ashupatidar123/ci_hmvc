<?php
if(!defined('BASEPATH')){
    exit('No direct script access allowed');
}

require APPPATH . "third_party/MX/Controller.php";

class MY_Controller extends MX_Controller
{	
	public static $instance=NULL;	
	function __construct(){
		parent::__construct();
		//$this->_hmvc_fixes();
		self::$instance || self::$instance =& $this;
	}

	function _hmvc_fixes()
	{		
		//fix callback form_validation		
		//https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
	}

	public function print($data){
		echo "<pre>";
		print_r($data);
		echo "</pre>"; exit;
	}

	public function string_replace($item_search,$change,$original){
		return str_replace($item_search,$change,$original);
	}

	public function adminHeader(){
		$this->load->view('header');
	}

	public function adminFooter(){
		$this->load->view('footer');
	}

	public function encryptID($id='',$url=''){		
		$str_start = str_shuffle("252acf0tD1349kHCn58639966");
		$str_end   = str_shuffle("252M1K3D4lt9puHYn02571230");
		return $str_start.$id.$str_end;		
	}

	public function decryptID($id='',$url=''){		
		
		$originalId = substr($id,25,-25);
		//$str_start = str_shuffle("212acf0tD1349kHCn5863");
		//$str_end   = str_shuffle("212M1K3D4lt9puHYn0257");
		//return $str_start.$id.$str_end;		
	}

}

