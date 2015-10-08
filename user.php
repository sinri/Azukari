<?php
/**
* User Information Agent for Azukari
*/
class AzukariUser
{
	
	function __construct()
	{
		# code...
	}

	public static function keyOfUser($user){
		$users=array(
			'test_user'=>'test_key',
		);
		if(isset($users[$user])){
			return $users[$user];
		}else{
			return null;
		}
	}  
}
?>