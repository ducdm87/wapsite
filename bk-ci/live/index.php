<?php

if (!isset($_GET['898']))
    die;

error_reporting(0);

require('config.php');
require('lib/Simple_cache.php');
require('lib/simple_html_dom.php');
require('include/cron.php');

$time_start = time();

set_time_limit(56);
ini_set('max_execution_time', 56);
//ignore_user_abort(false); //true = Script vẫn chạy dù Client request chạy script bị ngắt kết nối
//ob_end_clean();
//
//if (ob_get_level() == 0) {
//    ob_start();
//}

echo '<pre>';
$i = 0;
$n = 30;

if (isset($_GET['n']))
    $n = $_GET['n'];

$cron = new cron();
while ($i < $n) {
    $rs = $cron->craw();
    $time = date('d/m/Y H:i:s');
    echo '<p>' . $i . '=>' . $time . '</p>';
//    ob_flush();
//    flush();

    if ($rs == true) {
        if ($n > 1) {
            sleep(3);
        }
        $i++;
    }

    $time_end = time();
    $time = $time_end - $time_start;
    if ($time >= 56) {
        echo $time . ' - Success...';
        echo '</pre>';
        $_db->close();
//        ob_end_flush();
        die;
    }
}

echo $time . ' - Success...';
echo '</pre>';
$_db->close();
//var_dump((get_defined_vars()));
//ob_end_flush();
die;
?>
