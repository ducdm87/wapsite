<?php
	require_once('SOAPClient.class.php');
	$url = 'http://123.30.172.185:8080/webservice/TelcoAPI?wsdl';
	$pass = "bihaco@payment";
    $username = "bihaco";
    $mpin = "bihaco.vn.mpin";
    $parnerid = 65;
	
	$Client = new VMS_Soap_Client($url, $username, $pass, $parnerid, $mpin);
	var_dump($Client);
	
	//$return = $Client->doCardCharge($username, '123456789', 'mail@xxx.com', '0912345678');
	//var_dump($return);
?>