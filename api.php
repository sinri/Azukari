<?php
/*
 * API of Azukari. Accept request and process.
 */

include_once(__DIR__.'/init.php');

$available_act_list=array('upload','delete','validate');

$act=Azukari::readPost('act');
if(!in_array($act, $available_act_list)){
	response('',-1,'Unavailable Act ['.$act.']');
}

$user=Azukari::readPost('user');
$timestamp=Azukari::readPost('timestamp');
$checksum=Azukari::readPost('checksum');
$filename=Azukari::readPost('filename');

$body = Azukari::readPost('body','');

$authed=Azukari::reqAuth($user,$filename,$timestamp,$checksum,$body);
if(!$authed){
	response('',-2,'Incorrect Identity');
}

if($act=='upload'){
	if(file_exists(Azukari::pathInStore($filename))){
		response('',-3,'Filename Existed');
	}else{
		$r1=file_put_contents(Azukari::pathInStore($filename), 'RESERVED');
		if($r1===false){
			response('',-5,'Failed to save file in [Step 1]');
		}
		$decoded = ""; 
		for ($i=0; $i < ceil(strlen($body)/256); $i++) {
			$part=base64_decode(substr($body,$i*256,256),true);
			if($part===false){
				response('',-4,'Body contains char not in base64 set.');
			}
   			$decoded = $decoded . $part;
		}
		$r2=file_put_contents(Azukari::pathInStore($filename), $decoded);
		if($r2===false){
			response('',-5,'Failed to save file in [Step 2]');
		}else{
			response(Azukari::urlInStore($filename));
		}
	}
}
elseif($act=='delete'){
	if(file_exists(Azukari::pathInStore($filename))){
		$r=unlink(Azukari::pathInStore($filename));
		if($r===false){
			response('',-6,'Failed to delete file.');
		}else{
			response('Deleted');
		}		
	}else{
		response('',-7,'Filename Not Existed');
	}
}
elseif ($act=='validate') {
	if(file_exists(Azukari::pathInStore($filename))){
		response('Existed');
	}else{
		response('',-7,'Filename Not Existed');
	}
}

////////

function response($object,$code=0,$msg=''){
	$json=json_encode(array(
		'code'=>$code,
		'object'=>$object,
		'msg'=>$msg,
	));
	echo $json;
	exit();
}

?>