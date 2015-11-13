<?php

if (!isset($_GET['898']))
    die;

require('lib/database.php');
require('lib/query.php');

$host = 'localhost';//114
$user = 'xoso'; //114
$pass = 'jGsCpNTfdjpBzwnj'; //114

//$host = '210.211.97.114'; //server cron
//$user = 'xoso229'; //server cron
//$pass = 'l8hu6ewbfqwe689'; //server cron

$db = 'xosov2';

//$user = 'root';
//$pass = '123465';
//$db = 'xosov2';
$_db = new database($host, $user, $pass, $db);
?>
