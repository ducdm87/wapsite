<?php

if (!isset($_GET['898']))
    die;

$lc	=	isset($_REQUEST['lc']) ? $_REQUEST['lc'] : 'mb';


error_reporting(0);

//header("Cache-Control: max-age=300");
//header_remove("Pragma");
//header_remove("Expires");
//
//$time = date('H:i');
//if ($time > '16:00' && $time < '19:00')
//    header("Cache-Control: max-age=3");

require('lib/simple_html_dom.php');
require('lib/Simple_cache.php');
require('crontxt.php');

set_time_limit(56);
ini_set('max_execution_time', 56);
//ignore_user_abort(false); //true = Script vẫn chạy dù Client request chạy script bị ngắt kết nối

$url = array();
$url[] = 'http://www.minhngoc.net.vn/';
//$url[] = 'http://minhngoc.net.vn/';

echo '<pre>';
$cron = new crontxt();
$cron->crawtxt($url, $lc);
$time = date('d/m/Y H:i:s');
echo $time . ' - Success...';
echo '</pre>';
//var_dump((get_defined_vars()));
die;
?>