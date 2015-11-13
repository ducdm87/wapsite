<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function time_format($str, $type)
{
	$date = strtotime($str);
	switch($type)
	{
		case "day":
			{
				return date("d-m-Y", $date);
			}
		break;
		
		case "full":
			{
				return date("d-m-Y H:i:s", $date);
			}
		break;
	}
}

function convert_to_string($intmonth)
{
	switch($intmonth) 
	{ 
	    case "1" : 
	        $stringmonth = "January"; 
	        break;
	    case "2" : 
	        $stringmonth = "February"; 
	        break;
	    case "3" : 
	        $stringmonth = "March"; 
	        break;
	    case "4" : 
	        $stringmonth = "April";
	        break; 
	    case "5" : 
	        $stringmonth = "May";
	        break; 
	    case "6" : 
	        $stringmonth = "June";
	        break; 
	    case "7" : 
	        $stringmonth = "July";
	        break; 
	    case "8" : 
	        $stringmonth = "August";
	        break; 
	    case "9" : 
	        $stringmonth = "September";
	        break; 
	    case "10" : 
	        $stringmonth = "October";
	        break; 
	    case "11" : 
	        $stringmonth = "November";
	        break; 
	    case "12" : 
	        $stringmonth = "December";
	        break; 
	} 
	return $stringmonth;
	
}