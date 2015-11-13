<?php
	$conn=mysql_connect("localhost","xoso","b03d1556f7") or die("cannot connect");;
	mysql_select_db("xosov2",$conn) or die("cannot select DB");
	
	mysql_set_charset('utf8',$conn);
	mysql_query("set names 'utf8'");
?>