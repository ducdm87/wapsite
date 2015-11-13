<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'app' . EXT;

class somm extends app {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $lid = (isset($_GET['tinh']) ? (int) $_GET['tinh'] : 1);
        $this->data['lid'] = $lid;
        $this->data['tmpl'] = 'layout/somm';
        $this->load->view('layout/index', $this->data);
    }

}