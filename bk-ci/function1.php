<?php
function curl_page($url,$canchong,$chivo,$p1,$p2){
//		$URL = 'http://thuocbietduoc.com.vn/nhom-thuoc-1-0/thuoc-gay-te-me.aspx';
		$fields = array($p1=>$canchong, $p2=>$chivo);
		$fields_string = '';
		
	    foreach($fields as $key=>$value) { $fields_string  .= $key.'='.$value.'&'; };

	    rtrim($fields_string,'&');
	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_POST,count($fields));
	    curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
	    curl_setopt($ch, CURLOPT_HEADER, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    
	    $result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	function curl_page3($url,$fields=array()){

		//$fields = array($p1=>$canchong, $p2=>$chivo);
		$fields_string = '';
		
	    foreach($fields as $key=>$value) { $fields_string  .= $key.'='.$value.'&'; };
	    rtrim($fields_string,'&');
	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_POST,count($fields));
	    curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true ); 
		  
	    $result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	
?>