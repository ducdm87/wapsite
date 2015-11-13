<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'client' . EXT;

class error_404 extends Client {

    function __construct() {
        parent::__construct();
    }

    public function index() {
//        redirect(base_url());
        $this->load->view("error404", $this->data);
    }

}