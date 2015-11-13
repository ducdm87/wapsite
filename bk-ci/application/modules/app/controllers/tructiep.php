<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'app' . EXT;

class tructiep extends app {

    function __construct() {
        parent::__construct();
        $this->load->model('xs_result_model');
        $time = date('H:i');
        if ($time > '16:00' && $time < '19:00')
            header("Cache-Control: max-age=30");
    }

    public function index() {
        $area = (isset($_GET['area']) ? trim($_GET['area']) : 'MB');

        $this->data['timer'] = $this->data['location_menu']['MB'][0]->time;
        if ($area == 'MT')
            $this->data['timer'] = $this->data['location_menu']['MT'][0]->time;
        elseif ($area == 'MN')
            $this->data['timer'] = $this->data['location_menu']['MN'][0]->time;

        $this->data['area'] = $area;
        $this->data['tmpl'] = 'layout/tructiep';
        $this->load->view('layout/index', $this->data);
    }

    public function xstt($area = 'MB') {
        $result = $this->xs_result_model->getResultLoto($area);
        
        $this->data['timer'] = (isset($_GET['t']) ? $_GET['t'] : '');
        $this->data['data'] = $result->cache->data;
        $this->data['area'] = $area;
        $this->load->view('layout/xstt', $this->data);
    }

}