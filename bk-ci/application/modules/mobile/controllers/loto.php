<?php

//mobile/loto/index?tinh=1&fromdate=11-03-2013&todate=11-03-2014&number=88,99,100
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'mobile' . EXT;

class loto extends mobile {

    function __construct() {
        parent::__construct();

//        if (isset($_GET['checkcap'])) {
//            if (!isset($_GET['captcha'])) {
//                if (!isset($_SESSION['captcha' . $this->data['c_module']]))
//                    $_SESSION['captcha' . $this->data['c_module']] = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 5);
//                echo '<div style="display:none">' . json_encode(array('captcha' => $_SESSION['captcha' . $this->data['c_module']])) . '</div>';
//                die;
//            }else {
//                $captcha = $_GET['captcha'];
//                if (!isset($_SESSION['captcha' . $this->data['c_module']]) || $_SESSION['captcha' . $this->data['c_module']] != $captcha) {
//                    echo 'Nhập sai captcha!';
//                    die;
//                }
//            }
//        }
    }

    public function index() {
        $fromdate = (isset($_GET['fromdate']) ? $_GET['fromdate'] : date('d-m-Y', strtotime('-365 days')));
        $todate = (isset($_GET['todate']) ? $_GET['todate'] : date('d-m-Y'));
        $number = (isset($_GET['number']) ? trim($_GET['number']) : '');
        $lid = (isset($_GET['tinh']) ? $_GET['tinh'] : 1);

        if ($lid == 0)
            return;

        $this->data['items'] = array();
        if (isset($_GET['number']) && trim($_GET['number']) != '')
            $this->data['items'] = $this->xs_result_model->getItemsLoto($fromdate, $todate, $number, $lid);
        else
            return;

        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;
        $this->data['number'] = $number;
        $this->data['lid'] = $lid;
        $this->data['tmpl'] = 'statistics/loto';
        $this->load->view('layout/content', $this->data);
    }

}