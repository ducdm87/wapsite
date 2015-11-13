<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Set and display flash message (remove after display ) type : success, error, warning...
 *
 * @author  Nguyen Xuan Hung
 * @email   hungnguyen@vietnambiz.com
 * @date    19.11.2010
 */

class Message {
    
    var $info, $warning, $success, $error;
    
    // @param type : info, warning, succes, error
    function add($type, $message)
    {
        $arr =& $this->$type;
        
        if(is_array($message)) {
            foreach($message as $msg) $arr[] = $msg;
        }
        else {
            $arr[]  = $message;
        }
        
        $_SESSION['message'][$type] = $arr;
    }
    
    function get($type)
    {
        if(!$this->$type && isset($_SESSION['message'][$type]))
        {
            $this->$type = $_SESSION['message'][$type];
        }
        
        return $this->$type;
    }
    
    function has($type)
    {
        $arr =& $this->get($type);
        return (count($arr) > 0) ? true : false;
    }
    
    function display()
    {
        $CI =& get_instance();
        $CI->load->helper('inflector');
        
        $html = '';
        
        foreach (get_object_vars($this) as $key => $value)
        {
            if($this->has($key)) {
    
                $list = $this->get($key);
                
                // if msg > 1
                if(count($list) > 1) {
                    $html .= '<div class="box">';
                    $html .= '<div class="'.$key.'"><b>'.ucfirst(plural($key)).'</b></div>';
                    foreach($list as $msg) {
                        $html .= '<div class="'.$key.'">'.$msg.'</div>';
                    }
                    $html .= '</div>';
                }
                else {
                    $html .= '<div class="'.$key.'">'.$list[0].'</div>';
                }
                
                // free after display
                $this->$key = array();
                unset($_SESSION['message']);
            }
        }
        
        return $html;
    }
    
	function display_blank()
    {
        $CI =& get_instance();
        $CI->load->helper('inflector');
        
        $html = '';
        
        foreach (get_object_vars($this) as $key => $value)
        {
            if($this->has($key)) {
    
                $list = $this->get($key);
                
                // if msg > 1
                if(count($list) > 1) {
                    
                    
                    $html .= '<ul class="booking">';
					$html .= '<li>'.ucfirst(plural($key)).'</li>';
                    foreach($list as $msg) {
                        $html .= '<li> -'.$msg.'</li>';
                    }
                    
                    $html .= '</ul>';
                }
                else {
                    $html .= '<li> -'.$list[0].'</li>';
                }
                
                // free after display
                $this->$key = array();
                unset($_SESSION['message']);
            }
        }
        
        return $html;
    } 

    function display_p()
    {
    	$CI =& get_instance();
    	$CI->load->helper('inflector');
    
    	$html = '';
    
    	foreach (get_object_vars($this) as $key => $value)
    	{
    		if($this->has($key)) {
    
    			$list = $this->get($key);
    
    			// if msg > 1
    			if(count($list) > 1) {
    
    
    				//$html .= '<ul class="booking">';
    				//$html .= '<li>'.ucfirst(plural($key)).'</li>';
    				foreach($list as $msg) {
    					$html .= '<p>'.$msg.'</p>';
    				}
    
    				//$html .= '</ul>';
    			}
    			else {
    				$html .= '<p>'.$list[0].'</p>';
    			}
    
    			// free after display
    			$this->$key = array();
    			unset($_SESSION['message']);
    		}
    	}
    
    	return $html;
    }
}