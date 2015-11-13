<?php

ini_set('display_errors', 1);

$filename = $_GET['filename'];

$mwidth = $_GET['mwidth'];
$mheight = $_GET['mheight'];

if (!file_exists($filename)) {
    header('HTTP/1.1 500 Internal Server Error');	    
    echo 'No image';
    
    echo "\r\n".'<p style="display: none;">'. $filename .'</p>';
    die;
}


$info = getimagesize($filename);
if ($info == null) {
    header('HTTP/1.1 500 Internal Server Error');
    exit('Invalid image type');
}
$type = $info[2];
$mine = $info['mime'];
$ext = explode('/', $mine);
$ext = $ext[1];
if ($type == IMAGETYPE_JPEG)
    $src_img = imagecreatefromjpeg($filename);
else if ($type == IMAGETYPE_PNG)
    $src_img = imagecreatefrompng($filename);
else if ($type == IMAGETYPE_GIF)
    $src_img = imagecreatefromgif($filename);
else {
    header('HTTP/1.1 500 Internal Server Error');
    exit('Invalid image type');
}

if ($mheight) {
    $dst_img = make_thumb($src_img, 'thumb-' .  $ext, $mwidth, $mheight, strtolower($ext));
}
else {
    $dst_img = make_thumb_w($src_img, 'thumb-' . $ext, $mwidth, strtolower($ext));
}

header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header("Content-Type: " . $mine);

if ($type == IMAGETYPE_PNG)
    imagepng($dst_img);
else
    imagejpeg($dst_img);
imagedestroy($dst_img);
imagedestroy($src_img);

function make_thumb($src_img, $to_image, $new_w, $new_h, $ext) {

    $old_y = imageSY($src_img);
    $old_x = imageSX($src_img);
    if ($old_y < $new_h || $new_h == 0) {
        $new_h = $old_y;
    }

    if ($old_x < $new_w || $new_w == 0) {
        $new_w = $old_x;
    }

    $ratio1 = $old_x / $new_w;
    $ratio2 = $old_y / $new_h;
    if ($ratio1 > $ratio2) {
        $thumb_w = $new_w;
        $thumb_h = $old_y / $ratio1;
    }
    else {
        $thumb_h = $new_h;
        $thumb_w = $old_x / $ratio2;
    }
    $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
    imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
    return $dst_img;
}

function make_thumb_w($src_img, $to_image, $new_w, $ext) {
    $old_y = imageSY($src_img);
    $old_x = imageSX($src_img);

    if ($old_x < $new_w || $new_w == 0) {
        $new_w = $old_x;
    }
    $thumb_w = $new_w;
    $thumb_h = $old_y / ($old_x / $new_w);
    $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
    imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
    return $dst_img;
}
