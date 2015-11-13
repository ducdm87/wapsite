<?php
	function mosProcessImages($content,$slug)
	{	
		//find all href value in a tag (with ")
		$href	=	new href();
		
		if(preg_match_all('/(<img[^>]*(src="([^"]*)")[^>]*>)/ism', $content, $matches)){
			
			for ($i = 0; $i < count($matches[1]); $i++){
				
				$image_name = get_image($matches[3][$i],$slug.$i,'d:/tmp/Anh/','/images/game/news/content/');
				$_link_image	=	'/images/content/'.$image_name;
				if ($_link_image) {
					$content = str_replace($matches[2][$i], 'src="'. $_link_image .'"', $content);
				}
				else $content = str_replace($matches[1][$i], '', $content);
			}
		}
		return $content;
	}

	function get_image($url_item,$slug,$path_save,$path_view = ''){
		
		preg_match('/.*?\.(jpg|gif|png|jpeg|bmp)$/ism',$url_item,$matches);
//		$todir = $slug[0].'/'.$slug[1];
//		
//		$dirname = $slug[0];
//		$dirname2 = $slug[1];
//		$filename = "$path_save{$dirname}/";
//		$filename2 = "$path_save{$dirname}/{$dirname2}/";
		
		if  (!file_exists($path_save)) {
			mkdir("$path_save", 0755);
		} 
//		if  (!file_exists($filename2)) {
//			mkdir("$filename{$dirname2}", 0755);
//		} 
//		$path_save = $filename2;
		
		if (file_exists($path_save.$slug.'.'.$matches[1])) {
	       // echo $path_save.$slug.'.'.$matches[1];
			$image_name = $slug.$matches[1];
	    }
	    else {
	    	
	    	$downloadInfo = downloadFile($url_item,$path_save,$slug.'.'.$matches[1]);
	    	//echo "<pre>"; print_r($downloadInfo); echo "</pre>";
	    	if ($downloadInfo['http_code'] == 200){
				$image_name = "$slug.$matches[1]";
			}
			else {
				$image_name = '';
			}
	    }
		
		return $image_name;
	}
	function downloadFile( $url_to_download,$path_save,$filename_save) {
	    $url_to_download=str_replace(' ','%20',$url_to_download);
	    $url_to_download=str_replace('s128','s700',$url_to_download);
	  
	    $path = $path_save.$filename_save;
	    $ch = curl_init ($url_to_download);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	    $rawdata=curl_exec($ch);
	    curl_exec($ch);
	    $downloadInfo=curl_getinfo($ch);  
	    curl_close ($ch);
	    if(file_exists($path)){
	        return $downloadInfo;
	    }
	    $fp = fopen($path,'x');
	    fwrite($fp, $rawdata);
	    fclose($fp);
	    return $downloadInfo;
	}
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
	    curl_setopt($ch, CURLOPT_HEADER, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true ); 
		  
	    $result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	
		function curl_page2($url){
	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_HEADER, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);	    
	    $result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
?>
<?php 
//get default language
function defaultLang()
{
	
	global $db;	
	$sql = "SELECT LANGUAGE_ID "; 
	$sql.= "FROM ".PFX."_language ";
	$sql.= "WHERE ENABLED =1 AND _DEFAULT=1 ";
	$sql.= "ORDER BY LANGUAGE_ID ";
	$sql.= "LIMIT 1"; 
	//echo $sql;
	
	$r = $db->Query($sql);		
	while($row = $r->FetchArray()){
		$lang= $row['LANGUAGE_ID'];
	}
	//$lang= $row['LANGUAGE_ID'];	
	return $lang;
}
function asprint($array){
	print("<pre>");
		print_r($array);
	print("</pre>");	
}
function getContentFromUrl($strRemoteUrl)
{
	$resRemoteUrl = fopen($strRemoteUrl, "r");
	$strContent = '';
	if ($resRemoteUrl) {
		ob_start();
	    while (!feof($resRemoteUrl)) {
			$strContent .= fgets($resRemoteUrl, 1024);
	    }
		ob_flush();
		flush();
	    fclose($resRemoteUrl);
	}
	return $strContent;
}

/**
 * Thực hiện phân trang để hiển thị một mảng các giá trị
 *
 * @param int $intNumRow Số lượng các phần tử của mảng cần chia trang
 * @param int $intRowPerPage Số dòng được hiển thị trên một trang
 * @param int $intCurrentPage Trang hiện tại
 * @param string $strCssClass Lớp css sử dụng để định nghĩa cho đường link
 * @param string $strCurrentURL URL được lưu lại thực hiện điều kiện tương tự khi nhảy qua trang mới
 * @param string $strPageName Tên biến được sử dụng để định nghĩa trang hiện tại trên URL
 * 
 * @return string
 */
 //upload video 
function UploadFileVideo($ParamfileName,$type_file="",&$errors,$fileSize,$pathUpload,&$file_upload){ 	
	if($_FILES[$ParamfileName]['error'] == 0) {
 		$filename = basename($_FILES[$ParamfileName]['name']);
		if($type_file!=""){
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$ext = strtolower($ext);
		}else{
			$ext = "";	
		}
		$file= $filename;
		//echo $ext;
		if($ext == $type_file && $_FILES[$ParamfileName]["size"]<$fileSize){
			//Determine the path to which we want to save this file
			$type_name_file = $_FILES[$ParamfileName]['tmp_name'];	 
			$file_upload = $file;     	        
	      	
	      	$newname = dirname(__FILE__).$pathUpload."\\".$file;
	        $newname = str_replace("common","",$newname);	
			copy($type_name_file,$newname);		
	        //echo $newname;
			$newnamefile = str_replace("common","",$newname);	
			//echo $newnamefile."<BR>";			
	      	move_uploaded_file($_FILES[$ParamfileName]['tmp_name'],$newnamefile);
		     	
		}else{
			$errors = "<font color='red'>Có lỗi xảy ra file upload quá lớn!</font>";
		}
 	}
 	return;
 } 

function _strPaging($intNumRow, $intRowPerPage, $intCurrentPage, $strCssClass, $strCurrentURL, $strPageName)
{
	global 
		$db, 
		$arrLangAdmin;

	$strStringReturn = '';
	$strURL = '';
	$strFirstSegmentInURL = '';
	$strLastURL = '';
	
	//	Thuc hien tim doan code tren URL theo tham so nhu sau: "&$strPageName=<con so>"
	$intPositionPageNameInURL = strpos($strCurrentURL, "&$strPageName=");
	if ($intPositionPageNameInURL <= 0)
	{
		$strURL .= $strCurrentURL;
	}
	else
	{
		$strFirstSegmentInURL .= substr($strCurrentURL, 0, $intPositionPageNameInURL);	//	Doan dau cua xau URL
		$intNextPosition = strpos($strCurrentURL, "&", $intPositionPageNameInURL + 1);
		$strLastURL .= substr($strCurrentURL, $intNextPosition + 1, strlen($strCurrentURL) - $intNextPosition);	//	Doan cuoi cua xau URL
	}
	$intNumPage = (($intNumRow % $intRowPerPage) == 0) ? $intNumRow / $intRowPerPage : floor($intNumRow / $intRowPerPage) + 1;
	if ($intCurrentPage > 1)
	{
		if ($strLastURL)
		{
			$strStringReturn .= '<a href="'. $strFirstSegmentInURL . $strURL . '&' . $strPageName . '=1&' . $strLastURL . '" class="' . $strCssClass . '">' . $arrLangAdmin['common_first'] . '</a> ';
		}
		else 
		{
			$strStringReturn .= '<a href="'. $strFirstSegmentInURL . $strURL . '&' . $strPageName . '=1" class="' . $strCssClass . '">' . $arrLangAdmin['common_first'] . '</a> ';
		}
	}
	
	if (($intCurrentPage - 1) > 0)
	{
		if ($strLastURL)
		{
			$strStringReturn .= '<a href="'. $strFirstSegmentInURL . $strURL . '&' . $strPageName . '=' . ($intCurrentPage - 1) . '&' . $strLastURL . '" class="' . $strCssClass . '">' . $arrLangAdmin['common_previous'] . '</a> ';
		}
		else 
		{
			$strStringReturn .= '<a href="'. $strFirstSegmentInURL . $strURL . '&' . $strPageName . '=' . ($intCurrentPage - 1) . '" class="' . $strCssClass . '">' . $arrLangAdmin['common_previous'] . '</a> ';
		}
	}
	
	for($i = 1; ($i <= $intRowPerPage) && ($i < $intNumPage); $i++)
	{
		if ($i == $intCurrentPage)
		{
			if ($strLastURL)
			{
				$strStringReturn .= '<a href="'. $strFirstSegmentInURL . $strURL . '&' . $strPageName . '=' . $i . '&' . $strLastURL . '" class="' . $strCssClass . '"><strong>' . $i . '</strong></a> ';
			}
			else 
			{
				$strStringReturn .= '<a href="'. $strFirstSegmentInURL . $strURL . '&' . $strPageName . '=' . $i . '" class="' . $strCssClass . '"><strong>' . $i . '</strong></a> ';
			}
		}
		else
		{
			if ($strLastURL)
			{
				$strStringReturn .= '<a href="'. $strFirstSegmentInURL . $strURL . '&' . $strPageName . '=' . $i . '&' . $strLastURL . '" class="' . $strCssClass . '" class="' . $strCssClass . '">' . $i . '</a> ';
			}
			else 
			{
				$strStringReturn .= '<a href="'. $strFirstSegmentInURL . $strURL . '&' . $strPageName . '=' . $i . '" class="' . $strCssClass . '" class="' . $strCssClass . '">' . $i . '</a> ';
			}
		}
	}
	
	if (($intCurrentPage + 1) <= $intNumPage)
	{
		if ($strLastURL)
		{
			$strStringReturn .= '<a href="'. $strFirstSegmentInURL . $strURL . '&' . $strPageName . '=' . ($intCurrentPage + 1) . '&' . $strLastURL . '" class="' . $strCssClass . '">' . $arrLangAdmin['common_next'] . '</a> ';
		}
		else 
		{
			$strStringReturn .= '<a href="'. $strFirstSegmentInURL . $strURL . '&' . $strPageName . '=' . ($intCurrentPage + 1) . '" class="' . $strCssClass . '">' . $arrLangAdmin['common_next'] . '</a> ';
		}
	}
	
	if (($intCurrentPage != $intNumPage) && ($intNumPage > 0))
	{
		if ($strLastURL)
		{
			$strStringReturn .= '<a href="'. $strFirstSegmentInURL . $strURL . '&' . $strPageName . '=' . ($intNumPage-1) . '&' . $strLastURL . '" class="' . $strCssClass . '">' . $arrLangAdmin['common_last'] . '</a>';
		}
		else 
		{
			$strStringReturn .= '<a href="'. $strFirstSegmentInURL . $strURL . '&' . $strPageName . '=' . ($intNumPage-1) . '" class="' . $strCssClass . '">' . $arrLangAdmin['common_last'] . '</a>';
		}
	}
	
	return $strStringReturn;
}

/**
 * Hàm thực hiện lấy địa chỉ IP thực của máy client
 *
 * @return string
 */
function _getIPRequest()
{
	global 
		$_SERVER;

	$strIP = '';

	if (!empty($_SERVER['HTTP_CLIENT_IP']))
	{
		$strIP = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$strIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$strIP = $_SERVER['REMOTE_ADDR'];
	}
	return $strIP;
}

/**
 * Thực hiện lưu lại quá trình log của người sử dụng
 *
 * @param obj $objCurrentUser Đối tượng chứa thông tin về người sử dụng ghi lại log
 * @param int $intLogLevel Cấp độ log
 * @param string $strLogDetail Chi tiết việc log
 * @param int $intLogUserType Loại user gây ra log
 * @param int $intLogUserID Mã người sử dụng gây ra log
 */
function _setLog($objCurrentUser, $intLogLevel, $strLogDetail, $intLogUserType, $intLogUserID)
{
	global 
		$db, 
		$CORE_DB_DBPREFIX;
	$strSql = "
		Insert into " . $CORE_DB_DBPREFIX . "_system_log 
			(
				SYSTEM_LOG_LEVEL, 
				SYSTEM_LOG_DETAIL, 
				SYSTEM_LOG_IP, 
				SYSTEM_LOG_USERTYPE, 
				SYSTEM_LOG_USERID
			)
		Values (
			$intLogLevel, 
			'" . _escapeBadCharacter($strLogDetail) . "', 
			'" . _getIPRequest() . "', 
			$intLogUserType, 
			$intLogUserID 
		)
	";
	@$db->Query($strSql);
}

/**
 * Thực hiện đưa ra dòng thông báo khi có lỗi về quyền xảy ra
 *
 * @param string $strTitleError Tiêu đề lỗi
 * @param string $strContentError Nội dung lỗi
 * @param object $objTplContent Thư viện template được sử dụng để in lỗi
 */
function _getError($strTitleError, $strContentError, &$objTplContent)
{
	global 
		$db, 
		$arrLangAdmin, 
		$tplAdmin, 
		$objCurrentUser, 
		$strLangCharset;

	$objTplTemp = new Smarty();
	$objTplTemp->template_dir = _STRBASEDIR . 'templates/admin/' . _STR_ADMIN_THEME . '/';
	$objTplTemp->compile_dir = _STRBASEDIR . 'templates/admin/' . _STR_ADMIN_THEME . '/template_c/';
	
	$objTplTemp->assign('strTitleError', $strTitleError);
	$objTplTemp->assign('strContentError', $strContentError);
	$objTplTemp->assign('strAdminTheme', _STR_ADMIN_THEME);
	$objTplTemp->assign('strAdminCharset', $strLangCharset);
	$objTplTemp->assign('LANG', $arrLangAdmin);

	$strContent = $objTplTemp->fetch('error/perm_error.tpl');

	$objTplContent->assign('objCurrentUser', $objCurrentUser);
	$objTplContent->assign('content', $strContent);
	$objTplContent->display('main/main_template.tpl');
}

/**
 * function check validate
 * para string "yyyy-mm-dd" or "yyyy/mm/dd" or yyyy.mm.dd
 * return true
 * CuongPH
 * */
function Checkvalidate($strDate){
 	list($year,$month, $day) = split('[/.-]', $strDate);
 	if(!checkdate($month,$day,$year)){
 		return false;
 	}
 	return true;
 }
 /**
  *Function resize image using GD lib - Resize image to propertly size
  @param string file name
  @param string $newfilename name of new image
  @param string path to save new file
  @param int maxwidth is width of new image after resize 
  @param int maxheight is height of new image after resize
  @return new file image
  @author CuongPH
 */
function resizeImage($filename,$newfilename,$path,$maxwidth,$maxheight) {
	//file extension
	$image_type = substr($filename, -4);
	$image_type = strtolower($image_type);
    switch($image_type) {
		case '.jpg':
			$source = imagecreatefromjpeg($filename);
			break;
		case '.png':
			$source = imagecreatefrompng($filename);
			break;
		case '.gif':
			$source = imagecreatefromgif($filename);
			break;
		default:
			return false;
			die;
		break;
	}
	
	//new file name
	$nfile = $newfilename . $image_type;
	//full new file path
	$fullpath = $path . $nfile;
	//original file size
	list($width, $height) = getimagesize($filename);
	
	//calculate new image size
	$newwidth = $width;
	$newheight = $height;
	
	$xratio = $maxwidth/$width;
	$yratio = $maxheight/$height;
	if (($xratio >=1) && ($yratio >=1)) {
		$newwidth = $width;
		$newheight = $height;
	}else {
		$minratio = min($xratio,$yratio);
		$newwidth = $minratio * $width;
		$newheight = $minratio * $height;
	}
	//create new images with new size
	$newimage = imagecreatetruecolor($newwidth, $newheight);
	//rewsize
	imagecopyresized($newimage, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	//set quality
	imagejpeg($newimage, $fullpath, 80);
	
	imagedestroy($source);
    imagedestroy($newimage);
    //return full path of new image
	//return $fullpath;
	return $nfile;
}

// function get  crypt blow fish string 
//return string
//by Cuongph
function get_crypt_blowfish()
{
    static $singleton;
    global $INCLUDE_CYRP;

    if (empty($singleton)) {
        if (OPENPNE_USE_OLD_CRYPT_BLOWFISH) {
           
            include_once ($INCLUDE_CYRP.'BlowfishOld.php');          
            $singleton = new Crypt_BlowfishOld(ENCRYPT_KEY);
        } else {
            include_once ($INCLUDE_CYRP.'Blowfish.php');
            $singleton = new Crypt_Blowfish(ENCRYPT_KEY);
        }
    }
    return $singleton;
}

/*
 * function encode string by crypt
 * by Cuongph
 * */
function t_encrypt	($str)
{
    
    if (!$str) return '';

    $bf = get_crypt_blowfish();

    $str = $bf->encrypt($str);
	
    //base64
    $str = base64_encode($str);

    return $str;
}

/*
 * function decode string by crypt
 * by Cuongph
 * */
function t_decrypt($str)
{
    if (!$str) return '';

    //base64
    $str = base64_decode($str);

    $bf = get_crypt_blowfish();
    return rtrim($bf->decrypt($str));
}
//Get list season 

/**
 * function getDBlist 
 * return array
 * by Cuongph
 * */
function getDBlist($table_name,$fields_list = "",$where="",$order="",$limit="",$debug=false){
	global $db;
	$i=0;$array=array();
	if($fields_list == "") $fields_list = "DISTINCT *";
	$sql = "SELECT $fields_list FROM $table_name ";
	if($where !=""){
		$sql .= "WHERE ".$where;
	}	
	if($order !=""){
		$sql .= " ORDER BY ".$order;
	}
	
	if($limit != ""){
		$sql .= " LIMIT ".$limit;
	}
	//echo $sql."<br>";
	if($debug == true){
		echo $sql."<br>";
	}
	$rsQuery = mysql_query($sql);
	while ($row = mysql_fetch_array($rsQuery, MYSQL_ASSOC)) {
		$array[$i] = $row;
		$i++;
	}
	return $array;
}

//get dblist sql
function getDBSQLlist($sql,$debug=false){
	global $db;
	$i=0;$array=array();
	if($debug == true){
		echo $sql."<br>";
	}
	$rsQuery = mysql_query($sql);
	while ($row = mysql_fetch_array($rsQuery, MYSQL_ASSOC)) {
		$array[$i] = $row;
		$i++;
	}
	return $array;
}
//get DBRow
function getDBRow($table_name,$fields_list = "",$where="",$order="",$limit="",$debug=false){
	global $db;
	$i=0;$array=array();
	if($fields_list == "") $fields_list = "DISTINCT *";
	$sql = "SELECT $fields_list FROM $table_name ";
	if($where !=""){
		$sql .= "WHERE ".$where;
	}	
	if($order !=""){
		$sql .= " ORDER BY ".$order;
	}
	
	if($limit != ""){
		$sql .= " LIMIT ".$limit;
	}
	//echo $sql."<br>";
	if($debug == true){
		echo $sql."<br>";
	}
	$rsQuery = mysql_query($sql);
	$array = mysql_fetch_array($rsQuery);	
	return $array;
}
function ExecuteSql($sql,$debug=0)
{
	if($debug == 1) echo $sql."<br>";
	mysql_query($sql) or die (mysql_error());
	return;
}

function getRowsql($sql,$debug=false)
{
	$rsQuery = mysql_query($sql);
	$array = mysql_fetch_array($rsQuery);	
	if($debug == true){
		echo $sql."<br>";
	}
	return $array;
}

/**
Function update table
@param array Field need update
@param string pKey is Primary key
@param string value of PK
@param array arrayvalue is valiable of each fiedl correlative
return true if ok, else false
CuongPH
*/
function UpdateFields($tablename,$uFields=array(),$pkey="",$pvalue,$arrayvalue=array(),$debug=false){
	global $db;
	$where = "";
	$updateSt = "";
	for($i=0;$i<count($uFields);$i++){
		$fname = $uFields[$i];
		$value = $arrayvalue[$i];
		if($value===null){
			$updateSt .= "$id = null,";
		}else $updateSt .= "$fname = '$value',";
	}
	$updateSt = substr($updateSt,0,strlen($updateSt)-1);
	
	if ($where == "") {
		$where .= $pkey." = '$pvalue'";
	}else $where .= "AND ".$pkey." = '$pvalue'";
	$query = "UPDATE $tablename SET $updateSt ";
	
    if ($where !="") {
      $query .= " WHERE $where ";
     // echo $query."<br>";
	if($debug == true){
		echo $query."<br>";
	}
      $rs = mysql_query($sql); 
	  if (!$rs) {
  	    return false;
       }
    }
	return true;
}
/**
 * Function delete field
 * @param $field_cond field name for condition delete
 * @param $value_del is validate of del field
 * */ 
 function DelelteField($tablename,$field_cond,$value_del,$dg=false)
 {
 	global $db;
	$where = "";
 	$sql = "DELETE FROM $tablename WHERE $field_cond = $value_del";
 	if($dg ==true)
	{
	echo $sql;
	}
	if(!mysql_query($sql)){
 		return false;
 	}else{
 		mysql_query($sql);
 		 return true;
 	}
 }
 /**
  * function insert new field for table
  * */
  function insertnew_table($table_name,$field_list,$field_list_val,$dg = false){
 	global $db;
 	$field_list_val = str_replace(",","','",$field_list_val);
 	$field_list_val = "'".$field_list_val."'";
 	$sql = "INSERT INTO $table_name ($field_list) values($field_list_val)";
 	
	//echo $sql;
	if($dg == true){ echo $sql;}
 	mysql_query($sql);
 	return ;
 }

/** function  sendmailToAdd ($from,$to, $subject, $array, $tplfile , $mail_server) 
	 * @param string $from,$to, $subject, $array, $tplfile , $mail_server
	 * @return function mail() SMTP
	 * @author huycuong
	 * */	
function sendmailToAdd($from,$to, $subject, $array, $tplfile , $mail_server){	
	
		define(Mail_Server, $mail_server);
		ini_set("SMTP",Mail_Server);	
		
		if (!$to) return false;
		if(is_array($to)){
			$eachto = "";
			foreach($to as $eachto){
				if ($eachto) $eachto.= ",".$eachto; 
			  	else $eachto=$eachto;
			}
		}elseif(!is_array($to)){
			$to = $to;
		}
		$headers .= 'From:'.$from. "\r\n" .
		'Reply-To:'.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();
		$headers .= "MIME-Version: 1.0"."\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
		$headers .= "Content-Transfer-Encoding: 7bit\r\n";	
		//$subject = "=?utf-8";	
		
		$contents = readMailTemplate($tplfile); 
		$arr_pat = array(); 
		$arr_pat = array();
		
		while (list($pat, $val) = each($array))
		{
			$arr_pat[] = $pat; 
			$arr_val[] = $val; 
		}	  		
		$message = str_replace($arr_pat, $arr_val, $contents);	
		//asprint($subject);
		preg_replace("/\n/", "\r\n", $message);
		return mail($to, $subject, $message, $headers);
	}
	//Read file
	function readMailTemplate($filename)
	 {	  
		 $fp = fopen($filename, "r");
		 $contents = fread($fp, filesize($filename));
		 fclose($fp);
		 return $contents;
	 }
	//Author: CuongPH
 	function random_character( $count = 6 )
	{
		$random_char = "";
		$char_base = explode( " ", "a b c d e f g h i j k l m n o p q r s t u v w x y z 0 1 2 3 4 5 6 7 8 9");
	
		for( $i = 0; $i < $count; $i++ )
		{
			$radom_char = $radom_char.$char_base[rand(9, count($char_base))];
		}	
		return $radom_char;
	}
	function create_image()
{
    //Let's generate a totally random string using md5
    $md5_hash = md5(rand(0,9999));
    //We don't need a 32 character long string so we trim it down to 4
    $security_code = substr($md5_hash, 15, 4);
	//echo $security_code;
    //Set the session to store the security code
  //  $_SESSION["security_code"] = $security_code;
	_CORESessionSet("security_code",$security_code);
	//$_SESSION['security_code'] = $security_code;
    //Set the image width and height
    $width = 50;
    $height = 20;

    //Create the image resource
    $image = ImageCreate($width, $height);  

    //We are making three colors, white, black and gray
    $white = ImageColorAllocate($image,  255, 101, 0);
    $black = ImageColorAllocate($image, 200, 200, 200);
    $grey = ImageColorAllocate($image, 255, 255, 255);

    //Make the background black
    ImageFill($image, 0, 0, $black);

    //Add randomly generated string in white to the image
    ImageString($image, 80, 10, 1, $security_code, $white);

    //Throw in some lines to make it a little bit harder for any bots to break
    ImageRectangle($image,0,30,$width-1,$height-1,$grey);
    imageline($image, 110, $height/2, $width, $height/2, $grey);
    imageline($image, $width/2, 100, $width/2, $height, $grey);

    //Tell the browser what kind of file is come in
    header("Content-Type: image/jpeg");

    //Output the newly created image in jpeg format
    ImageJpeg($image);

    //Free up resources
    ImageDestroy($image);
}
/*
upload file tham bien $tenfile
*/
function UploadFile($ParamfileName,$type_file="",&$errors,$fileSize,$pathUpload,&$file_upload){ 	
	//echo $pathUpload;
	if($_FILES[$ParamfileName]['error'] == 0) {
 		$filename = basename($_FILES[$ParamfileName]['name']);
		if($type_file!=""){
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$ext = strtolower($ext);
		}else{
			$ext = "";	
		}
		
		//$filename = str_replace(".jpg","",$filename);
		//$filename = str_replace(".gif","",$filename);
		if($ext !=""){
			$file= $filename.".".$ext;
		}else{
			$file= $filename;
		}
		
		
		//echo $ext;
		if($ext == $type_file && $_FILES[$ParamfileName]["size"]<$fileSize){
			//Determine the path to which we want to save this file
			$type_name_file = $_FILES[$ParamfileName]['tmp_name'];	 
			$file_upload = $file;     	        
	      
	      	$newname = dirname(__FILE__).$pathUpload."/".$file;
			copy($type_name_file,$newname);		
	        $newnamefile = str_replace("common","",$newname);	
			echo $newnamefile."<BR>";			
	      	move_uploaded_file($_FILES[$ParamfileName]['tmp_name'],$newnamefile);
		     	
		}else{
			$errors = "<font color='red'>Có lỗi xảy ra, file không đúng định dạng hoặc file quá lớn</font>";
		}
 	}
 	return;
 }
 /*upload many images*/
function UploadFiles($ParamfileName,$type_file="",&$errors,$fileSize,$pathUpload,&$file_upload){ 	
	//echo $pathUpload;
	$cnt = count($_FILES[$ParamfileName]['name']);
	for($i=0;$i<$cnt;$i++)
	{
		if($_FILES[$ParamfileName]['error'][$i] == 0) {
			$filename = basename($_FILES[$ParamfileName]['name'][$i]);
			if($type_file!=""){
				$ext = substr($filename, strrpos($filename, '.') + 1);
				$ext = strtolower($ext);
			}else{
				$ext = "";	
			}
			
		//	$filename = str_replace(".jpg","",$filename);
		//	$filename = str_replace(".gif","",$filename);
			if($ext !=""){
				$file= $filename.$ext;
			}else{
				$file= $filename;
			}
			
			//$file= $filename;
			//echo $ext;
			if($ext == $type_file && $_FILES[$ParamfileName]["size"][$i]<$fileSize){
				//Determine the path to which we want to save this file
				$type_name_file = $_FILES[$ParamfileName]['tmp_name'][$i];	 
				$file_upload = $file;    	        
				
				$newname = dirname(__FILE__).$pathUpload."/".$file;	
				copy($type_name_file,$newname);			
				$newnamefile = str_replace("common","",$newname);
//echo $newnamefile;	
				echo $newnamefile."<BR>";			
				move_uploaded_file($_FILES[$ParamfileName]['tmp_name'][$i],$newnamefile);
					
			}else{
				$errors = "<font color='red'>CÃ³ lá»—i xáº£y ra, file khÃ´ng Ä‘Ãºng Ä‘á»‹nh dáº¡ng hoáº·c file quÃ¡ lá»›n</font>";
			}
		}
	}
 	return;
 }
/*modifiedby: DucND*/
//CuongPH
function addtime($sy,$sm,$sd,$num=0){
		//echo $sy;
		$time_bofere_five_year =  date("d-m-Y", mktime(0, 0, 0, $sm+$num, $sd, $sy));	
		
		$time_begin = str_replace("-","",$time_bofere_five_year);		
		$time = substr($time_begin,4,4)."-".substr($time_begin,2,2)."-".substr($time_begin,0,2);
		return $time;
	}
function addtime_day($sy,$sm,$sd,$num=0){
		//echo $sy;
		$time_bofere_five_year =  date("d-m-Y", mktime(0, 0, 0, $sm, $sd+$num, $sy));	
		
		$time_begin = str_replace("-","",$time_bofere_five_year);		
		$time = substr($time_begin,4,4)."-".substr($time_begin,2,2)."-".substr($time_begin,0,2);
		return $time;
	}	
function getWeekRange(&$start_date, &$end_date, $offset=0) {
        $start_date = '';
        $end_date = '';   
        $week = date('W');
        $week = $week - $offset;
        $date = date('Y-m-d');
       
        $i = 0;
        while(date('W', strtotime("-$i day")) >= $week) {                       
            $start_date = date('Y-m-d', strtotime("-$i day"));
            $i++;       
        }   
           
        list($yr, $mo, $da) = explode('-', $start_date);   
        $end_date = date('Y-m-d', mktime(0, 0, 0, $mo, $da + 6, $yr));
}

function getWeekRange2(&$start_date, &$end_date, $week_offset=0) { 
    $start_date = ''; 
    $end_date = ''; 
    
    // todays information 
    list($yr, $mo, $da, $word) 
= explode('-', date("Y-m-d-l", strtotime("+".abs($week_offset)." week"))); 

    // 0 (for Sunday) through 6 (for Saturday) 
    $day_of_current_week = date('w', strtotime("+".abs($week_offset)." week")); 

    // on sunday, they want last week through today. 
    if ($day_of_current_week == 0){ 
        $day_of_current_week = 7; 
    } 
    
    // calculate day offset to monday and sunday 
    $days_to_monday = 1 - $day_of_current_week; 
    $days_to_sunday = 7 - $day_of_current_week; 

    // set the start and end dates for this week 
    $start_date = date('Y-m-d', mktime(0, 0, 0, $mo, ($da + ($days_to_monday)), $yr)); 
    $end_date   = date('Y-m-d', mktime(0, 0, 0, $mo, ($da + ($days_to_sunday)), $yr)); 
} 
//kiem tra cac loai dien thoai
function beforeFilter() {
   $mobile = array();
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $mobileDevice = array("SonyEricsson", "Nokia", "BlackBerry", "SAMSUNG", "LG", "Motorola","Philip",
                            "Apple", "HP", "Siemens", "Vertu", "Panasonic", "O2", "Mozilla", "Opera", "NokiaN8", "NokiaN9","Alcatel","MOT","SAGEM");
        $charset = array("utf8", "utf8", "ascii", "utf8", "utf8", "ascii", "ascii",
                            "ascii", "ascii", "ascii", "ascii", "ascii", "ascii",
                            "utf8", "ascii", "ascii", "ascii", "utf8", "utf8", "utf8");
        for ($i = 0;$i < count($mobileDevice);++$i)
        {
            if (strpos($user_agent, $mobileDevice[$i]) !== false)
            {
                $mobile[0] = $mobileDevice[$i];
                $mobile[1] = $charset[$i];
            }
        }
		return $mobile;
    }
/**
getMax ID
**/ 

function getMaxID($table,$id)
{
	global $db;
	$sql = "select MAX($id) as MAXID from $table";
	$result1 = mysql_query($sql);
	$row1 = mysql_fetch_row($result1);
	return $row1[0];
}	



/*Chuyen font chu sang Unicode*/
function stripUnicode($str){
    if(!$str) return false;
        $unicode = array(
            'a'=>'á|à|?|ã|?|a|?|?|?|?|?|â|?|?|?|?|?',
            'd'=>'d', 
			'D'=> 'Ð',          
            'e'=>'é|è|?|?|?|ê|?|?|?|?|?',
            'i'=>'í|ì|?|i|?',
            'o'=>'ó|ò|?|õ|?|ô|?|?|?|?|?|o|?|?|?|?|?|ò',
            'u'=>'ú|ù|?|u|?|u|?|?|?|?|?',
            'y'=>'ý|?|?|?|?',            
        );
        foreach($unicode as $nonUnicode=>$uni)
         $str = preg_replace("/($uni)/i",$nonUnicode,$str);
	return strtolower($str);
}

function postPage($url,$pvars,$referer,$timeout){
    if(!isset($timeout))
        $timeout=30;
    $curl = curl_init();
    $post = http_build_query($pvars);
    if(isset($referer)){
        curl_setopt ($curl, CURLOPT_REFERER, $referer);
    }
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
    curl_setopt ($curl, CURLOPT_HEADER, 0);
//    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt ($curl, CURLOPT_POST, 1);
    curl_setopt ($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt ($curl, CURLOPT_HTTPHEADER,
        array("Content-type: application/x-www-form-urlencoded"));
    $html = curl_exec ($curl);
    curl_close ($curl);
    return $html;
}

function refreshpage($param, $time = 4000,$page )
	{
		ob_start();
		?>
		<html>
			<script type="text/javascript">
			function submit()
			{
				setTimeout("document.form_refresh_getcontent.submit();", <?php echo $time; ?>);
			}				
			</script>
			<body onLoad="submit();">
			<center>
				<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="333333">
					<h3 name="title">
						
					</h3>
				
					<h4><?php  // e cho $_REQUEST['task']; ?></h4>
					<h4>(<i><?php echo date('Y-m-d H:i:s') ?></i>)</h4>
					</font>
				</center>
				<form name="form_refresh_getcontent" action="<?php echo $page;?>.php" method="GET">
					<?php
						foreach ($param as $k=>$value)
						{
							?>
								<input type="hidden" name="<?php echo $k; ?>" value="<?php echo $value; ?>" />
							<?php
						}
					?>
				</form>
			</body>
		</html>
		<?php		
		$str	=	ob_get_contents();
		ob_clean();	
		return $str;
	}
	
?>