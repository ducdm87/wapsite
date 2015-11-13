<?php
include "config.php";
$now = $_REQUEST['layout'];
$date = isset($_REQUEST['date'])?$_REQUEST['date']:date('d-m-Y');
$mang	=	array(
	array('a0','Giải Đặc Biệt'),
	array('a1','Giải Nhất'),
	array('a2','Giải Nhì'),
	array('a3','Giải Ba'),
	array('a4','Giải Tư'),
	array('a5','Giải Năm'),
	array('a6','Giải Sáu'),
	array('a7','Giải Bảy'),
	array('a8','Giải Tám')
);

	
$tmp = explode("-",$date);
$ngay = $tmp[0];
$thang = $tmp[1];
$nam = $tmp[2];

$getdate = $nam."-".$thang."-".$ngay;
$jd=cal_to_jd(CAL_GREGORIAN,$thang,$ngay,$nam);
$day=jddayofweek($jd,0);


$time = date('H:i');
if ($time < "12:00") {
	$date = $day;
} else {
	$date = $day+1;
}
	
	
//$date = strval(date('w') + 1);
$sql = "select id,name,code, area from xs_location where  lich like '%".$date."%' order by ordering asc";

//die;
$result1 = mysql_query($sql);
while($row2 = mysql_fetch_array($result1))
{
	
	if($row2[3]=='MB')
	{
		$items['MB'][] = array('id'=>$row2['id'],'name'=>$row2['name'],'code'=>$row2['code']);
	}
	if($row2[3]=='MN')
	{
		$items['MN'][] = array('id'=>$row2['id'],'name'=>$row2['name'],'code'=>$row2['code']);
	}
	if($row2[3]=='MT')
	{
		$items['MT'][] = array('id'=>$row2['id'],'name'=>$row2['name'],'code'=>$row2['code']);
	}
}

getItemsByLocation();


function getItemsByLocation()
{
	$start_date = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('d-m-Y');
	$end_date = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('d-m-Y');
	$location = isset($_REQUEST['idLocation'])?$_REQUEST['idLocation']:'MB';
	$location	=	strtoupper($location);
	$start_date			= date('Y-m-d',strtotime(str_replace('/','-',"$start_date")));
	$end_date			= date('Y-m-d',strtotime(str_replace('/','-',"$end_date")));
	
	$sql = "select r.*,l.name,l.code, l.alias, l.area from xs_result as r left join xs_location as l on r.lid = l.id where date='".$start_date."' and l.code='".$location."'";
	echo $sql;
	$result1 = mysql_query($sql);
	while($row2 = mysql_fetch_array($result1))
	{
		$list[] = $row2;
	}
	
	if(!$list)
	{
		echo "<pre>";
		print_r($row2);
		
	}
	
	if(!$list)
	{
		$sql = "select r.*,l.name,l.code, l.alias, l.area from xs_result as r left join xs_location as l on r.lid = l.id where 1=1 and l.code='".$location."' order by date DESC";
		$result1 = mysql_query($sql);
		$row2 = mysql_fetch_array($result1);
		
	}
	
	$arr	=	array();
	$arr['list']	=	$list;
	echo "<pre>";
	print_r($arr);
/*
	if($list)
	{
		$query = $db->getQuery(true);
	
		// Truy vấn dữ liệu bản kết quả xổ số
		$query->select('r.*');
		$query->from('#__xs_result AS r');
		$query->select('l.name,l.code, l.alias, l.area');
		$query->join('LEFT', '#__xs_location AS l on r.lid = l.id');
		$query->where("date < ".$db->Quote($list[0]->date)."");
		$query->where("code = ".$db->Quote($location)."");
		$query->where("r.id <> ".$db->Quote($list[0]->id)."");
		$query->order('date DESC');
		$db->setQuery($query,0,10);
		$list_other	=	$db->loadObjectList();
		$arr['other']	=	$list_other;
	}
	
	*/	
		//return $arr;
	
}