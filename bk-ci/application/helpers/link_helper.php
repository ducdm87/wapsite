<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

function getAliasByDate($date = null) {
    $date = empty($date) ? date("Y-m-d") : $date;
    $date = date('D', strtotime($date));

    $day = '';
    switch ($date) {
        case 'Mon':
            $day = 'thu-hai';
            break;
        case 'Tue':
            $day = 'thu-ba';
            break;
        case 'Wed':
            $day = 'thu-tu';
            break;
        case 'Thu':
            $day = 'thu-nam';
            break;
        case 'Fri':
            $day = 'thu-sau';
            break;
        case 'Sat':
            $day = 'thu-bay';
            break;
        case 'Sun':
            $day = 'chu-nhat';
            break;

        default:
            break;
    }

    return $day;
}

function formatMail($str) {
    $coDau = array(
        "à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ",
        "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ",
        "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
        "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
        "ì", "í", "ị", "ỉ", "ĩ",
        "ỳ", "ý", "ỵ", "ỷ", "ỹ",
        "đ",
        "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
        "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
        "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
        "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
        "Ì", "Í", "Ị", "Ỉ", "Ĩ",
        "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
        "Đ");

    $khongDau = array(
        "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
        "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
        "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
        "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
        "i", "i", "i", "i", "i",
        "y", "y", "y", "y", "y",
        "d",
        "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A",
        "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O",
        "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
        "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
        "I", "I", "I", "I", "I",
        "Y", "Y", "Y", "Y", "Y",
        "D");

    $str = str_replace($coDau, $khongDau, $str);
    $str = preg_replace('/[^a-zA-Z0-9\-:,]/', ' ', $str); // a-zA-Z0-9 - = space
    $str = preg_replace("/\s{2,}/i", ' ', $str); // Replace 2 or more space = 1 space

    return $str;
}

function cleanName($name) {
    $name = RemoveSign(trim($name));
    $name = str_replace(' ', '-', $name);
    return urlencode(strtolower($name));
}

function RemoveSign($str) {
    $coDau = array(
        "à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ",
        "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ",
        "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
        "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
        "ì", "í", "ị", "ỉ", "ĩ",
        "ỳ", "ý", "ỵ", "ỷ", "ỹ",
        "đ",
        "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
        "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
        "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
        "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
        "Ì", "Í", "Ị", "Ỉ", "Ĩ",
        "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
        "Đ");

    $khongDau = array(
        "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
        "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
        "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
        "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
        "i", "i", "i", "i", "i",
        "y", "y", "y", "y", "y",
        "d",
        "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A",
        "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O",
        "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
        "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
        "I", "I", "I", "I", "I",
        "Y", "Y", "Y", "Y", "Y",
        "D");

    $str = str_replace($coDau, $khongDau, $str);
    $str = preg_replace('/[^a-zA-Z0-9\-]/', ' ', $str); // a-zA-Z0-9 - = space
    $str = preg_replace("/\s{2,}/i", ' ', $str); // Replace 2 or more space = 1 space

    return $str;
}

function Quote($text, $escaped = true) {
    return '\'' . ($escaped ? getEscaped($text) : $text) . '\'';
}

function getEscaped($text, $extra = false) {
    $result = mysql_real_escape_string($text);
    if ($extra) {
        $result = addcslashes($result, '%_');
    }
    return $result;
}

function admin_url($uri = '') {
    $CI = & get_instance();

    if (is_array($uri)) {
        $uri = implode('/', $uri);
    }
    return site_url($CI->uri->segment(1) . '/' . $uri);
}

function admin_redirect($uri = '', $method = 'location', $http_response_code = 302) {
    $CI = & get_instance();

    if (!preg_match('#^https?://#i', $uri)) {
        $uri = $CI->uri->segment(1) . '/' . $uri;
    }

    redirect($uri, $method, $http_response_code);
}

function html_url() {
    $CI = & get_instance();
    return $CI->config->item('html_url');
}

function css_link($css_file = '', $module = 'client', $folder = 'css') {
    $CI = & get_instance();
    if ($module == '') {
        $module = $CI->router->fetch_module();
    }
    return html_url() . config_item('static_dir') . $module . '/' . $folder . '/' . $css_file;
}

function img_link($img_file = '', $module = 'client', $folder = 'images') {
    $CI = & get_instance();
    if ($module == '') {
        $module = $CI->router->fetch_module();
    }
    return html_url() . config_item('static_dir') . $module . '/' . $folder . '/' . $img_file;
}

function js_link($js_file = '', $module = 'client', $folder = 'js') {
    $CI = & get_instance();
    if ($module == '') {
        $module = $CI->router->fetch_module();
    }
    return html_url() . config_item('static_dir') . $module . '/' . $folder . '/' . $js_file;
}

/**
 * Tạo link theo controller và method, mặc định là controller hiện tại nếu để trống
 */
function action_link($method = '', $controller = '') {
    if ($controller == '') {
        $CI = & get_instance();
        $controller = $CI->router->class;
    }

    return admin_url($controller . '/' . $method);
}

function go_back($default = '') {
    if (isset($_SERVER['HTTP_REFERER'])) {
        $default = $_SERVER['HTTP_REFERER'];
    }

    redirect($default);
}

function current_link() {
    return current_url() . ($_SERVER['QUERY_STRING'] ? '/?' . $_SERVER['QUERY_STRING'] : '');
}

function view_title($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

//function member_link($link = '', $ext = '', $prefix = 'thanh-vien') {
//    return site_url($prefix . '/' . $link) . $ext;
//}
//
//function register_link($link = '', $ext = '', $prefix = 'dang-ky') {
//    return site_url($prefix . '/' . $link) . $ext;
//}

function common_link($title_link = '', $ext = '/', $prefix = '') {
    return site_url($prefix . '/' . $title_link) . $ext;
}

function location_link($title_link = '', $ext = '/', $prefix = '') {
    return site_url($prefix . '/' . $title_link) . $ext;
}

function intro_link($title_link = '', $prefix = 'gioi-thieu', $ext = '.html') {
    return site_url($prefix . '/' . $title_link) . $ext;
}

function news_link($title_link = '', $prefix = 'tin-xo-so', $ext = '.html') {
    return site_url($prefix . '/' . $title_link) . $ext;
}
function help_link($title_link = '', $prefix = 'tro-giup', $ext = '.html') {
    return site_url($prefix . '/' . $title_link) . $ext;
}

//function tutorial_link($title_link = '', $ext = '.html', $prefix = 'huong-dan') {
//    return site_url($prefix . '/' . $title_link) . $ext;
//}