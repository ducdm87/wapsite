<?php
session_start();

/*
* File: CaptchaSecurityImages.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 03/08/06
* Updated: 07/02/07
* Requirements: PHP 4/5 with GD and FreeType libraries
* Link: http://www.white-hat-web-design.co.uk/articles/php-captcha.php
* 
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation; either version 2 
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*
*/

class CaptchaSecurityImages {

	var $font = 'monofont.ttf';

	function generateCode($characters) {
		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = '23456789bcdfghjkmnpqrstvwxyz';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		$code	=	strtoupper($code);
		return $code;
	}

	function CaptchaSecurityImages($width='120',$height='30',$characters='5') {
		$code = $this->generateCode($characters);
		/* font size will be 75% of the image height */
		$font_size = $height * 0.75;
		$image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
		/* set the colours */
		$background_color = imagecolorallocate($image, 255, 255, 255);
		$text_color = imagecolorallocate($image, 255, 51, 0);
		$noise_color = imagecolorallocate($image, 204, 204, 204);
		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) {
			//imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
		}
		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) {
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
		}
		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $code) or die('Error in imagettftext function');
		/* output captcha image to browser */
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
//		$_SESSION['captcha'] = $code;
                
                define('THIS_PATH', dirname(__FILE__));
                require(THIS_PATH . '/xsms/database.php');

                $host = 'localhost';
                $user = 'xoso';
                $pass = 'b03d1556f7';
//                $user = 'root';
//                $pass = '123465';
                $db = 'xosov2';
                $_db = new database($host, $user, $pass, $db);
                
                $session_id = session_id();
                
                $_db->setQuery('DELETE FROM `sessions_captcha` WHERE `created`<=' . time()-(60*15));
                $_db->query();
                
                $query = 'SELECT `id` FROM `sessions_captcha` WHERE `sessid`=\'' . $session_id . '\' LIMIT 1';
                $row = $_db->setQuery($query);
                $row = $_db->loadObject($sessions_captcha);
                if(isset($sessions_captcha->id) && $sessions_captcha->id > 0) {
                    $_db->setQuery('UPDATE `sessions_captcha` SET `value`=\'' . $code . '\',`created`=' . time() . ' WHERE id=' . $sessions_captcha->id);
                    $_db->query();
                }else{
                    $_db->setQuery('INSERT INTO `sessions_captcha` SET `value`=\'' . $code . '\',`sessid`=\'' . $session_id . '\',`created`=' . time());
                    $_db->query();
                }
	}

}

$width = isset($_GET['width']) ? $_GET['width'] : '194';//64
$height = isset($_GET['height']) ? $_GET['height'] : '39';//26
$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '5';

$captcha = new CaptchaSecurityImages($width,$height,$characters);

?>