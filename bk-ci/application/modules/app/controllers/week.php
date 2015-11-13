<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'app' . EXT;

class week extends app {

    function __construct() {
        parent::__construct();
        $this->load->model('xs_result_model');
        
//        if (!isset($_GET['captcha'])) {
//            if (!isset($_SESSION['captcha' . $this->data['c_module'] . $this->data['c_func']]))
//                $_SESSION['captcha' . $this->data['c_module'] . $this->data['c_func']] = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 5);
//            echo '<div style="display:none">' . json_encode(array('captcha' => $_SESSION['captcha' . $this->data['c_module'] . $this->data['c_func']])) . '</div>';
//            die;
//        }else {
//            $captcha = $_GET['captcha'];
//            if (!isset($_SESSION['captcha' . $this->data['c_module'] . $this->data['c_func']]) || $_SESSION['captcha' . $this->data['c_module'] . $this->data['c_func']] != $captcha) {
//                echo 'Nhập sai captcha!';
//                die;
//            }
//        }
    }

    function index() {
        $fromdate = (isset($_GET['fromdate']) ? $_GET['fromdate'] : date('d-m-Y', strtotime('-30 days')));
        $todate = (isset($_GET['todate']) ? $_GET['todate'] : date('d-m-Y'));
        $lid = (isset($_GET['tinh']) ? (int) $_GET['tinh'] : 1);
        $type = 0;

        if ($lid == 0)
            die;

        $lname = '';
        foreach ($this->data['xs_location_menu'] as $value) {
            if ($lid == $value->id) {
                $lname = $value->name;
                break;
            }
        }

        $this->data['items'] = $this->xs_result_model->getItemsWeek($fromdate, $todate, $lid, $type);

        $this->data['lname'] = $lname;
        $this->data['tmpl'] = 'layout/week';
        $this->load->view('layout/index', $this->data);
    }

}

?>