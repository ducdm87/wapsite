<?php

if (!isset($_GET['898']))
    die;

error_reporting(0);
session_start();

require('config.php');
require('lib/Simple_cache.php');
require('include/update.php');

$time_start = time();

set_time_limit(56);
ini_set('max_execution_time', 56);

echo '<pre>';
$i = 0;
$n = 90;

if (isset($_GET['n']))
    $n = $_GET['n'];

$cron = new update();
while ($i < $n) {
    $rs = $cron->update();
    $time = date('d/m/Y H:i:s');
    echo '<p>' . $i . '=>' . $time . '</p>';
 
    if ($rs == true) {
        if ($n > 1) {
            sleep(1);
        }
        $i++;
    }

    $time_end = time();
    $time = $time_end - $time_start;
    if ($time >= 56) {
        echo $time . ' - Success...';
        echo '</pre>';
        $_db->close();
        die;
    }
}

echo $time . ' - Success...';
echo '</pre>';
$_db->close();
die;
?>
