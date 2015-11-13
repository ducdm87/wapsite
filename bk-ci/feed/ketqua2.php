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
 getItemsDate();
function getItemsDate()
    {
    	//die('++');
    	$time	=	date('H:i');
		$start_date = isset($_GET['startDate'])?$_GET['startDate']:date('d-m-Y');
		$end_date = isset($_GET['endDate'])?$_GET['endDate']:date('d-m-Y');
		$location = isset($_GET['idlocation'])?$_GET['idlocation']:"MB";
		$location	=	strtoupper($location);

		$sql = "select r.*,l.name,l.code, l.alias, l.area from xs_result as r left join xs_location as l on r.lid = l.id where date>='".$start_date."' and l.code='".$location."' order by date DESC limit 10";
		$result2 = mysql_query($sql);
		while($row3 = mysql_fetch_array($result2))
		{
			$lists[] = $row3;
			//echo "a";echo "<br>";
		}		
		echo "<pre>";
		print_r($lists);	
		

}
//getItemsNow();
	/*
	 * Lay ket qua xo so trong ngay hom nay
	 * Du lieu tra ve dang xml
	 */
	function getItemsNow()
    {
    	//die('++');
    	$time	=	date('H:i');
    	$start_date = isset($_REQUEST['date'])?$_REQUEST['date']:date('d-m-Y');
		$location = isset($_REQUEST['idLocation'])?$_REQUEST['idLocation']:'MB';
		$location	=	strtoupper($location);
		$start_date			= date('Y-m-d',strtotime(str_replace('/','-',"$start_date")));
		$getDate	=	$_REQUEST['date'];
		$arr	=	array();
		$lists = array();
		$areaList = array(
			'MB' => 'Miền Bắc',
			'MT' => 'Miền Trung',
			'MN' => 'Miền Nam',
		);
		
		
			
			$date = date('Y-m-d',strtotime('-1 day'));
			foreach($areaList as $ka => $va)
			{
				
				if($getDate == '')
				{
					//$sql = "select r.*,l.name,l.code, l.alias, l.area from xs_result as r left join xs_location as l on r.lid = l.id where date='".$start_date."' and l.area='".$ka."' and r.id=(SELECT id FROM xs_result WHERE lid=l.id AND date='".$date."') order by date DESC";
					
					$sql = "select r.*,l.name,l.code, l.alias, l.area from xs_result as r left join xs_location as l on r.lid = l.id where date='".$start_date."' and area='".$ka."'  and r.id=(SELECT id FROM xs_result WHERE lid=l.id AND date='".$start_date."') order by date DESC";
					//echo $sql;
					$result1 = mysql_query($sql);
					while($row2 = mysql_fetch_array($result1))
					{
						$lists[$ka][] = $row2;
					}
				
			
					if(!$row2 = mysql_fetch_array($result1))
					{
						$sql2 = "select r.*,l.name,l.code, l.alias, l.area from xs_result as r left join xs_location as l on r.lid = l.id where date='".$date."' and area='".$ka."'  and r.id=(SELECT id FROM xs_result WHERE lid=l.id AND date='".$date."') order by date DESC";
						//echo $sql;
							
						$result2 = mysql_query($sql2);
						//$row2 = mysql_fetch_array($result2);
						while($row3 = mysql_fetch_array($result2))
						{
							$lists[$ka][] = $row3;
							//echo "a";echo "<br>";
						}						
					}					
				}else{
					$sql = "select r.*,l.name,l.code, l.alias, l.area from xs_result as r left join xs_location as l on r.lid = l.id where date='".$start_date."' and area='".$ka."'  and r.id=(SELECT id FROM xs_result WHERE lid=l.id AND date='".$start_date."') order by date DESC";
						echo $sql;
						$result1 = mysql_query($sql);
						while($row2 = mysql_fetch_array($result1))
						{
							$lists[$ka][] = $row2;
						}
				}
				
			}
		
			echo "<pre>";
			print_r($lists);
			
		//return $arr;
	}
	
