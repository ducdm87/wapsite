<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function create_dir($dirName) {
    $dirs = explode('/', $dirName);
    $dir = '';
    foreach ($dirs as $part) {
        $dir .= $part . '/';
        if (!is_dir($dir) && strlen($dir) > 0)
            mkdir($dir, 0777);
        //chmod($dir, 0777);
    }
}

function remove_dir($dir) {
    if (!file_exists($dir))
        return true;
    if (!is_dir($dir))
        return unlink($dir);
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..')
            continue;
        if (!$this->remove_dir($dir . DIRECTORY_SEPARATOR . $item))
            return false;
    }
    return rmdir($dir);
}

function get_ext($filename = '') {
    $pieces = explode('.', $filename);
    return strtolower($pieces{count($pieces) - 1});
}

function createThumb($img_path, $sizes) {
    $pathinfo = pathinfo($img_path);
    $new_name = $pathinfo['basename'];
    $temp = explode('.', $pathinfo['basename']);

    $new_name = cleanName($temp[0]) . date('-his-dmy') . '.' . $pathinfo['extension'];
    
    rename($img_path, $pathinfo['dirname'] . '/' . $new_name);

    include_once (config_item('phpThumb_dir') . "ThumbLib.inc.php");

    $options = array(
        'resizeUp' => true,
        'jpegQuality' => 88,
    );
    
    foreach ($sizes as $size) {
        $thumb_dir = $pathinfo['dirname'] . '/thumb_' . $size;
        create_dir($thumb_dir);

        $t_size = explode('-', $size);

        $thumb = PhpThumbFactory::create($pathinfo['dirname'] . '/' . $new_name, $options);

        $thumb->adaptiveResize($t_size[0] + 5, $t_size[1] + 5);
        $thumb->cropFromCenter($t_size[0], $t_size[1]);
        $thumb->save($thumb_dir . '/' . $new_name, 'jpg');        
    }
    return $pathinfo['dirname'] . '/thumb_' . $sizes[0] . '/' . $new_name;
}
