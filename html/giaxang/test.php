<?php

//$response = file_get_contents("http://news.zing.vn/Dong-mon-duoc-moi-sang-La-Liga-Thai-Sung-van-let-det-post557687.html");
$response = fetchLink("http://news.zing.vn/Dong-mon-duoc-moi-sang-La-Liga-Thai-Sung-van-let-det-post557687.html");
//$response = get_content("http://news.zing.vn/Dong-mon-duoc-moi-sang-La-Liga-Thai-Sung-van-let-det-post557687.html");

echo htmlspecialchars($response);

function fetchLink($link, $referer = '', & $header = array()) {
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $link );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_ENCODING,'');
	
    if ($referer)
        curl_setopt($ch, CURLOPT_REFERER, $referer);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20120403211507 Firefox/32.0");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION , 1);
    curl_setopt($ch, CURLOPT_TIMEOUT , 3);
    curl_setopt($ch,CURLOPT_MAXREDIRS,3); 
    $result = curl_exec($ch);
    $header = curl_getinfo($ch);
    curl_close($ch);
   
    if (200 == (int) $header['http_code'] AND trim($result) != "")
        return $result;
    else{
        $result = file_get_contents($link);
        if(trim($result) != ""){ $head['http_code'] = 200; }
        else $head['http_code'] = 404;
        return $result;
    }
    return false;
} 

function get_content($link,$referer = '', & $header = array()){
    $header = array();
    $header[] = "Host: $link";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link );
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION , 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4');
    curl_setopt($ch, CURLOPT_REFERER, $referer);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_ENCODING,'');
    $content = curl_exec( $ch );
    $curl_info = curl_getinfo($ch);
    curl_close($ch);
    return $content;
}