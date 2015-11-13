<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Set all settings for admin in here
 * 
 * @author  Nguyen Viet Manh
 * @email   manhnv85@gmial.com
 * @date    30.08.2011
 */
/*
  |--------------------------------------------------------------------------
  | Limit items for each controller in admin cp
  |--------------------------------------------------------------------------
 */
$config['limit'] = array(
    'user' => 30,
    'products' => 30,
    'product_type' => 30,
    'company' => 30,
    'questions' => 30,
    'articles' => 30,
    'html' => 30,
    'booking' => 30
);

$config['thumb_size'] = array('100-67', '80-80');
$config['phpThumb_dir'] = dirname($_SERVER['SCRIPT_FILENAME']) . '/system/phpThumb/';

$config['base_url']	= 'http://alpha.benhvien.com/';
$config['html_url']	= 'http://alpha.benhvien.com/';
