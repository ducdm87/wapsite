<?php
/*
 * Author	:	manhnv
 * Date		:	25-08-2010
 * Email	:	manhnv@vietnambiz.com
 */ 

class captcha_image {
	
	var $height =	'60';
	var $width	=	'140';
	var $font_path	=	'';
	var $num_string	=	5;
	var $x		=	30;
	var $y		=	1;
	var $font_size	=	30;
	var $bg	=	array(10,200,50);
	var $color	=	array(200,100,90);
	var $chars = 'ABCDEFGHKLMNPQRSTUVWYZ123456789'; // O  and 0 (Zero) are visually similar, that's why I am not using it
	var $RandomStr = '';
	var $text_color = array(0,0,0);
	
	/*
	 * Create string random
	 */
	function create_string()
	{
		$string='';
		$md5_hash = md5(rand(0,999));
		$string .= substr($md5_hash, 15, $this->num_string); 
		return $string;
	}

	function captcha_image($params = array())
	{
		if (count($params) > 0)
		{
			$this->initialize($params);
		}

		log_message('debug', "Pagination Class Initialized");
	}
	
	function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
	}
	
	/*
	 *Create image captcha 
	 */
	
	function create_image()
	{
		$obj=& get_instance();
		$obj->load->library('session');
		$string=$this->create_string(); 
		$obj->session->set_userdata('security_code',$string);
		$image = imagecreatetruecolor($this->width,$this->height);
		$black = imagecolorallocate($image, 0, 0, 0);  
		$color = imagecolorallocate($image, $this->color[0], $this->color[1], $this->color[2]); // red  
		$white = imagecolorallocate($image, 255, 255, 255); 
		$bg	   = imagecolorallocate($image, $this->bg[0], $this->bg[1], $this->bg[2]);
		//$url = realpath(APPPATH.'../public/captcha/monofont.ttf');
		//$NewImage =imagecreatefromjpeg($url); 
		
		imagefilledrectangle($image,0,0,200,100,$bg);  
	    imagettftext($image, $this->font_size, 0, $this->x, $this->y, $color, $this->font_path, $obj->session->userdata('security_code'));  
	    
	    header("Content-type: image/png");  
		imagepng($image);
		imagedestroy($image);
	}
	
	function output(){
		
		for($i = 0; $i < $this->num_string; $i++){ // Generating the captcha string

		   $pos = mt_rand(0, strlen($this->chars)-1);

		   $this->RandomStr .= substr($this->chars, $pos, 1);

		}

		$ResultStr = $this->RandomStr;
		$url = realpath(APPPATH.'../public/captcha/bg_captcha2.JPG');
		$NewImage =imagecreatefromjpeg($url);//image create by existing image and as back ground 
		
		$TextColor = imagecolorallocate($NewImage, $this->text_color[0], $this->text_color[1], $this->text_color[2]);//text color-Black
		
		//$line_clr = imagecolorallocate($NewImage, 0, 255, 11);
		//Top left to Bottom Left	
		//imageline($NewImage, 0, $height-22, $width, $height-1, $line_clr);	
		// Bottom Left to Bottom Right	
		//imageline($NewImage, $width-1, 0, $width-100, $height, $line_clr);
		//imageline($NewImage, $height-1, 0, $width-100, $width, $line_clr);
		//imageline($NewImage, $width-1, 0, $height-1, $width, $line_clr);
		//$font_path = realpath(APPPATH.'../public/captcha/monofont.ttf');
		//$font = imageloadfont($font_path);	
		imagestring($NewImage,$this->font_size, $this->x, $this->y, $ResultStr, $TextColor);// Draw a random string horizontally 
		$obj=& get_instance();
		$obj->load->library('session');
		$obj->session->set_userdata('security_code',$ResultStr);// carry the data through session
		
		
		header("Content-type: image/jpeg");// out out the image 
		
		imagejpeg($NewImage);//Output image to browser 
		
		}
 
}
 

 
?>