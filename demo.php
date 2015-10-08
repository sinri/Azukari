<?php
/**
 * The demo about use Azukari.
 */

testAzukariUpload();
testAzukariValidate();
testAzukariDelete();
testAzukariValidate();

function postFields($url,$POST_DATA){
	$curl=curl_init($url);
	curl_setopt($curl,CURLOPT_POST, TRUE);
	// ↓はmultipartリクエストを許可していないサーバの場合はダメっぽいです
	// @DrunkenDad_KOBAさん、Thanks
	//curl_setopt($curl,CURLOPT_POSTFIELDS, $POST_DATA);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($POST_DATA));
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, FALSE);  // オレオレ証明書対策
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, FALSE);  // 
	curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
	// curl_setopt($curl,CURLOPT_COOKIEJAR,      'cookie');
	// curl_setopt($curl,CURLOPT_COOKIEFILE,     'tmp');
	curl_setopt($curl,CURLOPT_FOLLOWLOCATION, TRUE); // Locationヘッダを追跡
	//curl_setopt($curl,CURLOPT_REFERER,        "REFERER");
	//curl_setopt($curl,CURLOPT_USERAGENT,      "USER_AGENT"); 
	curl_setopt($curl, CURLOPT_HEADER, 1);

	$output= curl_exec($curl);
	return $output;
}

function testAzukari($act,$user,$filename,$timestamp,$checksum,$body){
	// Change it to your deployment
	$api_url="http://localhost/WebProjects/Azukari/api.php"; 
	
	$fields=array(
		'act'=>$act,
		'user'=>$user,
		'filename'=>$filename,
		'timestamp'=>$timestamp,
		'checksum'=>$checksum,
		'body'=>$body,
	);
	$response = postFields($api_url, $fields);

	echo "REQUEST".PHP_EOL;
	echo json_encode($fields).PHP_EOL;
	echo "RESPONSE".PHP_EOL;
	print_r($response);
	echo PHP_EOL."----".PHP_EOL;

	return $response;
}
function testAzukariUpload(){
	$act='upload';
	
	// Change it to your deployment
	$user='test_user';
	$key="test_key";

	$filename='user.php';
	$timestamp=time();
	
	$body=base64_encode(file_get_contents(__DIR__.'/'.$filename));

	$checksum=md5($user.$filename.$timestamp.$key.$body);

	return testAzukari($act,$user,$filename,$timestamp,$checksum,$body);
}
function testAzukariDelete(){
	$act='delete';

	// Change it to your deployment
	$user='test_user';
	$key="test_key";

	$filename='user.php';
	$timestamp=time();
	
	$body='';

	$checksum=md5($user.$filename.$timestamp.$key.$body);

	return testAzukari($act,$user,$filename,$timestamp,$checksum,$body);
}
function testAzukariValidate(){
	$act='validate';
	
	// Change it to your deployment
	$user='test_user';
	$key="test_key";

	$filename='user.php';
	$timestamp=time();

	$body='';

	$checksum=md5($user.$filename.$timestamp.$key.$body);

	return testAzukari($act,$user,$filename,$timestamp,$checksum,$body);
}
?>