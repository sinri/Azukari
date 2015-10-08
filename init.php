<?php
include_once(__DIR__.'/config.php');
include_once(__DIR__.'/user.php');

/**
* Initialization and Main Class for Azukari
*/
class Azukari
{
	
	function __construct()
	{
		# code...
	}

	public static function readGet($name,$default=null){
		return Azukari::readRequest($name,$default,'get');
	}
	public static function readPost($name,$default=null){
		return Azukari::readRequest($name,$default,'post');
	}

	public static function readRequest($name,$default=null,$target='request'){
		if($target=='request'){
			return (isset($_REQUEST[$name])?$_REQUEST[$name]:$default);
		}
		elseif($target=='get'){
			return (isset($_GET[$name])?$_GET[$name]:$default);
		}
		elseif($target=='post'){
			return (isset($_POST[$name])?$_POST[$name]:$default);
		}
	}

	public static function pathInStore($filename){
		return AzukariConfig::storeBasePath().$filename;
	}

	public static function urlInStore($filename){
		return AzukariConfig::storeBaseUrl().$filename;
	}

	public static function reqAuth($user,$title,$timestamp,$checksum,$body=''){
		$key=AzukariUser::keyOfUser($user);
		if(empty($key)){
			return false;
		}else{
			if(md5($user.$title.$timestamp.$key.$body)==$checksum){
				return true;
			}else{
				return false;
			}
		}
	}

}

?>