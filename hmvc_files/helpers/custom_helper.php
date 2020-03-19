<?php

function response($data=''){
	echo json_encode($data); die();
}

function printData($data=''){
	echo "<pre>"; print_r($data); echo "</pre>"; die();
}

function passwordGenerate($password='1234'){
	$str = base64_encode('81rt'.md5($password).'m');
	return str_replace('==','mkdr', $str);
}

function auth_token(){
	return str_shuffle("Ymk67dRak@MDlfNpp326ddg676AQ21ghqasert@yu0hgnkd8pXZ9i3K6kLGN2$5SQbvcbcJOJ1RWylk");
}


function checkImageExtension($imageExt){
	switch (strtolower($imageExt)) {
	    case ".jpeg":
	        return 'image';
	        break;
	    case ".png":
	        return 'image';
	        break;
	    case ".jpg":
	        return 'image';
	        break;
	    case ".gif":
	        return 'image';
	        break;
	    case ".gif":
	        return 'image';
	        break;    
	    default:
	        return false;
	}
}

function dateFormat($data){
	return date('d-M-Y',strtotime($data));
}

function stringReplace($data=''){
	$str = array("<p>","</p>","\"","\r\n","&nbsp;");
	return str_replace($str,'',$data);
}
?>