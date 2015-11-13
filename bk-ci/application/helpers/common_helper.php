<?php

/*
 * @author: Nguyen Viet Manh
 * @email: manhnv85@gmail.com
 * @date: 03.03.2012
 */

//function get config web site
function get_sys_config() {
    $CI = & get_instance();
    $CI->load->model('config_model');
    return $CI->config_model->get_one_array();
}

//function get directory image
function get_dir_name($item_name = '') {
    $CI = & get_instance();
    $dir_name = $CI->config->item('name_dir_upload');
    return $dir_name . ($item_name == '' ? '' : '/' . $item_name ) . '/';
}

//function get directory image
//function get image 
function get_image_url($img_name = '', $dir = '', $size = '60-40') {
    if ($size) {
        return get_dir_name($dir) . 'thumb_' . $size . '/' . $img_name;
    } else {
        return get_dir_name($dir) . $img_name;
    }
}

//function get image
//function convert from object to array
function convert_object_array($object = null) {
    $array = array();
    foreach ($object as $k => $v) {
        $array[$k] = $v;
    }
    return $array;
}

//function convert from object to array

function get_pages() {
    $CI = & get_instance();
    $CI->load->config('common_conf');
    return $CI->config->item('pages');
}

function mang_so() {
    $arr = array();
    for ($i = 0; $i <= 99; $i++) {
        $i = "0" . $i;
        $i = substr($i, -2, 2);
        $arr[] = $i;
    }
    return $arr;
}

function add_zero_to_number($num = 0) {
    $num = "0" . $num;
    $num = substr($num, -2, 2);
    return $num;
}

function show_money($money = 0, $val = 0) {
    return number_format($money, $val);
}

function show_vn_date($date) {
    $w = date('w', strtotime($date));
    $vn_date = date('d/m/Y', strtotime($date));
    $arr = array(
        '0' => 'Chủ Nhật',
        '1' => 'Thứ Hai',
        '2' => 'Thứ Ba',
        '3' => 'Thứ Tư',
        '4' => 'Thứ Năm',
        '5' => 'Thứ Sáu',
        '6' => 'Thứ Bảy'
    );

    return $arr[$w] . ',&nbsp;' . $vn_date;
}

function show_short_vn_date($date) {
    $vn_date = date('d/m/Y', strtotime($date));
    return $vn_date;
}

function convert_from_vndate_to_endate($date) {
    $date = preg_replace(
            array('/([\d]+)\/([\d]+)\/([\d]+)/', '/([\d]+)-([\d]+)-([\d]+)/'), array('$2/$1/$3', '$2-$1-$3'), $date);
    return $date;
}

function convert_date($date = NULL) {
    $date = preg_replace(
            array('/([\d]+)\/([\d]+)\/([\d]+)/', '/([\d]+)-([\d]+)-([\d]+)/'), array('$3-$2-$1', '$3/$2/$1'), $date);
    return $date;
}

function convert_from_vn_date_to_mysql_date($date = '') {
    $date = preg_replace(
            '/([\d]+)\/([\d]+)\/([\d]+)/', '$3-$2-$1', $date);
    return $date;
}

function change_thumb_img($img_url = '', $size_to = '204-136', $size_from = '108-84') {
    $size_from = 'thumb_' . $size_from;
    $size_to = 'thumb_' . $size_to;
    $img_url = str_replace($size_from, $size_to, $img_url);
    return $img_url;
}

function img_custom($src, $alt, $title, $size, $class, $rel, $onerror = '') {
    $image_properties = array(
        'src' => $src,
        'alt' => view_title($alt),
        'class' => $class,
        'width' => $size[0],
        'height' => $size[1],
        'title' => view_title($alt),
        'rel' => $rel,
        'onerror' => ($onerror == '' ? "this.src='" . img_link('no-image.jpg') . "'" : $onerror)
    );

    return img($image_properties);
}

function static_link($link) {
    $pos = strpos($link, "http");

    //var_dump($pos);die;
    if ($pos === false) {
        return site_url($link);
        //return $link;
    } else {
        //$CI =& get_instance();
        return $link;
    }
}

function gen_secret() {
    $time = time();
}

function add_log_system($msg) {
    $CI = & get_instance();
    $CI->load->model("log_system_model");

    $CI->log_system_model->insert(array("msg" => $msg, "time" => time()));
}

function m_days_in_month($month, $year) {
    // calculate number of days in a month
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}

