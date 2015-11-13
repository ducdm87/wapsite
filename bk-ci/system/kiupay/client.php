<?php
	//die("�sa");
	require_once('nusoap/nusoap.php');
	echo "<pre>";
	$username = "bihaco";
	$password = "bihaco@payment";
    $mpin = "bihaco.vn.mpin";
    $parnerid = 65;
	
	
	$client = new nusoap_client('http://123.30.172.185:8080/webservice/TelcoAPI?wsdl',true);
	$arg=array(
        'arg0' => $username, 
        'arg1' =>base64_encode(sha1($password,true)), 
        'arg2' => $parnerid
      );
	print_r($arg);
	
	$result_login   = $client->call('logIn', $arg);
	
	print_r($result_login);
	
	$session_id=$result_login['return']['sessionid'];
	
	$pincard="123456789012";// ma the
	$serial="1231434234234"; // so serial cua the
	$encrypt_mpin=getEncrypt($mpin,$session_id);
	$encypt_pincard=getEncrypt($pincard.":VMS:".$serial,$session_id);
	$target_email="manhnv2k7@gmail.com";
	$target_mobile="0972156337";
	$arg=array(
        'arg0' => $username, 
        'arg1' => $parnerid, 
        'arg2' => $encrypt_mpin,
        'arg3' => $encypt_pincard,
    	'arg4' => $target,
		'arg5' => $target_email,
		'arg6' => $target_mobile
      );
	  
	  print_r($arg);
	$result_CardCharge   = $client->call('CardCharge',$arg);
	
	var_dump($result_CardCharge);
	//////////////////////////////////////////////////////////////
	
	
	function getEncrypt($input, $key_seed){  
    $input    = trim($input);  
    $block    = mcrypt_get_block_size('tripledes', 'ecb');  
    $len      = strlen($input);  
    $padding  = $block - ($len % $block);  
    
    $input   .= str_repeat(chr($padding),$padding);    
    
    $key = substr(md5($key_seed),0,24);  
    
    $iv_size  = mcrypt_get_iv_size(MCRYPT_TRIPLEDES, MCRYPT_MODE_ECB);  
    $iv       = mcrypt_create_iv($iv_size, MCRYPT_RAND);  
    
    $encrypted_data = mcrypt_encrypt(MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB, $iv);  
    
    return base64_encode($encrypted_data);  
  } 
  
 
  function getDecrypt($input, $key_seed) {  
    $input  = base64_decode($input);  
    $key    = substr(md5($key_seed),0,24);  
    $text   = mcrypt_decrypt(MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB,'12345678');  
    $block  = mcrypt_get_block_size('tripledes', 'ecb');
      
    $packing = ord($text{strlen($text) - 1});  
    if($packing and ($packing < $block)){  
      for($P = strlen($text) - 1; $P >= strlen($text) - $packing; $P--){  
        if(ord($text{$P}) != $packing){  
          $packing = 0;  
        }  
      }  
    }  
    
    $text = substr($text,0,strlen($text) - $packing);  
    return $text;  
  }  
?>