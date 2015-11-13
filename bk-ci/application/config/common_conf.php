<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//Config number limit
$config['admin_num_limit'] = 10;
$config['admin_limit_20'] = 20;

$config['page_limit_20'] = 20;
$config['page_limit_10'] = 10;
$config['page_limit_5'] = 5;
$config['page_limit_2'] = 2;

//Config thumb image
$config['name_dir_upload'] = 'uploads';
$config['thumb_img_article'] = array('124-82');
//$config['thumb_img_crime'] = array('143-186');

$config['pages'] = array(
    'all' => 'Toàn trang',
    'home' => 'Trang chủ',
    'tructiep' => 'Trang TTTT',
    'xoso' => 'Trang kết quả xổ số',
    'statistics' => 'Trang thống kê',
    'news' => 'Tin tức',
    'member' => 'Thành viên',
);

$config['positions'] = array(
    'top' => 'Trên đầu',
    'left' => 'Bên trái',
    'middle' => 'Ở giữa',
    'right' => 'Bên phải',
    'bottom' => 'Phía dưới',
    'bottom_new' => 'Phía dưới tin mới',
    'bottom_right' => 'Phía dưới bên phải',
);

$config['share_email'] = 'info@xoso.com';

$config['mail']['protocol'] = 'smtp';
$config['mail']['smtp_host'] = 'ssl://smtp.googlemail.com';
$config['mail']['smtp_port'] = '465';
$config['mail']['smtp_timeout'] = '30';
$config['mail']['smtp_user'] = 'dev.xoso@gmail.com';
$config['mail']['smtp_pass'] = 'xoso2012';
$config['mail']['charset'] = 'utf-8';
$config['mail']['newline'] = "\r\n";