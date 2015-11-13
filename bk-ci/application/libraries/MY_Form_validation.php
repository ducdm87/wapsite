<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author  Nguyen Xuan Hung
 * @date    11.02.2011
 */

class MY_Form_validation extends CI_Form_validation {

    function __construct()
    {
        parent::__construct();
        //$this->set_message();
    }
    
    function get_error_array()
    {
        $errors = array();
        
        foreach($this->_error_array as $msg) {
            if($msg) $errors[] = $msg;
        }

        return $errors;
    }
}
