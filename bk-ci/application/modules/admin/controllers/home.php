<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('admin'.EXT);

class Home extends admin {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {	
        $this->data['tpl_file'] = 'home/index';        
        $this->load->view('layout/default', $this->data);
    }
}
