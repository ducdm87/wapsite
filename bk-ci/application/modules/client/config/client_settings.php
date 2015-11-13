<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Set all settings for client
 * 
 * @author  Tran Van Thanh
 * @email   thanhtran@vietnambiz.com
 * @date    30.08.2011
 */
/*
  |--------------------------------------------------------------------------
  | Limit items for each controller or method
  |--------------------------------------------------------------------------
 */
$config['limit'] = array(
    'home' => 20,
    'news' => 10,
);
$config['phpThumb_dir'] = dirname($_SERVER['SCRIPT_FILENAME']) . '/system/phpThumb/';
$config['thumb_logo'] = array('100-67');

$config['url_mienbac'] = 'xo-so-mien-bac';
$config['url_mientrung'] = 'xoso-mien-trung';
$config['url_miennam'] = 'xoso-mien-nam';
