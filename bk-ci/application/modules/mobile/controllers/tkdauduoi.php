<?php

//mobile/tkdauduoi/index?tinh=1&fromdate=09-02-2013&todate=20-02-2013&type=0
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'mobile' . EXT;

class tkdauduoi extends mobile {

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
        $lid = (isset($_GET['tinh']) ? $_GET['tinh'] : 1);
        $fromdate = (isset($_GET['fromdate']) ? $_GET['fromdate'] : date('d-m-Y', strtotime('-30 days')));
        $todate = (isset($_GET['todate']) ? $_GET['todate'] : date('d-m-Y'));
        $type = (isset($_GET['type']) ? $_GET['type'] : 0);

        if ($lid == 0)
            return;

        $this->data['items'] = $this->xs_result_model->getItemsDauDuoi($fromdate, $todate, $lid, $type);

        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;
        $this->data['lid'] = $lid;
        $this->data['type'] = $type;
        $this->data['tmpl'] = 'statistics/dau_duoi';
        $this->load->view('layout/content', $this->data);
    }

}