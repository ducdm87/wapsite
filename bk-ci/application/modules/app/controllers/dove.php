<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'app' . EXT;

class dove extends app {

    function __construct() {
        parent::__construct();
        $this->load->helper('rest');
    }

    public function index() {
        $this->load->model('xs_result_model');

        $rest = new REST;

        $fromdate = (isset($_GET['ngay']) ? $_GET['ngay'] : date('d-m-Y'));
        $sos = (isset($_GET['so']) ? trim($_GET['so']) : '');
        $lid = (isset($_GET['tinh']) ? (int) $_GET['tinh'] : 1);

        $this->data['alias'] = $lid;

        $this->data['lname'] = '';
        foreach ($this->data['xs_location_menu'] as $value) {
            if ($lid == $value->id) {
                $lid = $value->alias;
                $this->data['lname'] = $value->name;
                break;
            }
        }

        $this->data['items'] = array();
        $this->data['result'] = "";
        $this->data['soluong'] = "";
        if ($fromdate != '' && $sos != '') {
            $this->data['items'] = $this->xs_result_model->Doveso($lid, $fromdate);
            if ($this->data['items']) {
                $arr_so = explode(',', $sos);
                foreach ($arr_so as $so) {
                    $tmp = explode(':', $so);
                    $so = trim($tmp[0]);
                    $this->data['soluong'][$so] = 1;
                    if (isset($tmp[1]))
                        $this->data['soluong'][$so] = $tmp[1];
                    if (strlen($so) == strlen($this->data['items']->a0)) {
                        if ($this->data['items']->area == 'MB') {
                            $check_db = false;
                            if ($so == $this->data['items']->a0) {
                                $this->data['result'][$so] = "0,";
                                $check_db = true;
                            }
                            if ($so == $this->data['items']->a1)
                                $this->data['result'][$so] .= "1,";
                            if (strpos($this->data['items']->a2 . '-', $so . '-') !== false)
                                $this->data['result'][$so] .= "2,";
                            if (strpos($this->data['items']->a3 . '-', $so . '-') !== false)
                                $this->data['result'][$so] .= "3,";
                            if (strpos($this->data['items']->a4 . '-', substr($so, -4) . '-') !== false)
                                $this->data['result'][$so] .= "4,";
                            if (strpos($this->data['items']->a5 . '-', substr($so, -4) . '-') !== false)
                                $this->data['result'][$so] .= "5,";
                            if (strpos($this->data['items']->a6 . '-', substr($so, -3) . '-') !== false)
                                $this->data['result'][$so] .= "6,";
                            if (strpos($this->data['items']->a7 . '-', substr($so, -2) . '-') !== false)
                                $this->data['result'][$so] .= "7,";
                            if (!$check_db && strpos($this->data['items']->a0 . '-', substr($so, -2) . '-') !== false)
                                $this->data['result'][$so] .= "8,";
                        }else {
                            $check_db = false;
                            if ($so == $this->data['items']->a0) {
                                $this->data['result'][$so] = "0,";
                                $check_db = true;
                            }
                            if (substr($so, -5) == $this->data['items']->a1)
                                $this->data['result'][$so] .= "1,";
                            if (substr($so, -5) == $this->data['items']->a2)
                                $this->data['result'][$so] .= "2,";
                            if (strpos($this->data['items']->a3 . '-', substr($so, -5) . '-') !== false)
                                $this->data['result'][$so] .= "3,";
                            if (strpos($this->data['items']->a4 . '-', substr($so, -5) . '-') !== false)
                                $this->data['result'][$so] .= "4,";
                            if (substr($so, -4) == $this->data['items']->a5)
                                $this->data['result'][$so] .= "5,";
                            if (strpos($this->data['items']->a6 . '-', substr($so, -4) . '-') !== false)
                                $this->data['result'][$so] .= "6,";
                            if (substr($so, -3) == $this->data['items']->a7)
                                $this->data['result'][$so] .= "7,";
                            if (substr($so, -2) == $this->data['items']->a8)
                                $this->data['result'][$so] .= "8,";

                            if (strlen($this->data['items']->a0) == 5) {
                                if (!$check_db && strpos($this->data['items']->a0 . '-', substr($so, -2) . '-') !== false)
                                    $this->data['result'][$so] .= "10,";
                            }else {
                                if (!$check_db && strpos($this->data['items']->a0 . '-', substr($so, -5) . '-') !== false)
                                    $this->data['result'][$so] .= "9,";
                                elseif (!$check_db) {
                                    $dau = substr($so, 0, 1);
                                    $duoi = substr($so, -4);
                                    $dau2 = substr($so, 0, 2);
                                    $duoi2 = substr($so, -3);
                                    $dau3 = substr($so, 0, 3);
                                    $duoi3 = substr($so, -2);
                                    $dau4 = substr($so, 0, 4);
                                    $duoi4 = substr($so, -1);
                                    $dau5 = substr($so, 0, 5);
                                    if (preg_match('/' . $dau . '\d' . $duoi . '/', $this->data['items']->a0))
                                        $this->data['result'][$so] .= "10,";
                                    elseif (preg_match('/' . $dau2 . '\d' . $duoi2 . '/', $this->data['items']->a0))
                                        $this->data['result'][$so] .= "10,";
                                    elseif (preg_match('/' . $dau3 . '\d' . $duoi3 . '/', $this->data['items']->a0))
                                        $this->data['result'][$so] .= "10,";
                                    elseif (preg_match('/' . $dau4 . '\d' . $duoi4 . '/', $this->data['items']->a0))
                                        $this->data['result'][$so] .= "10,";
                                    elseif (preg_match('/' . $dau5 . '\d/', $this->data['items']->a0))
                                        $this->data['result'][$so] .= "10,";
                                }
                            }
                        }
                    }else {
                        $this->data['result'][$so] = 999;
                    }
                }
            }
        }

        $this->data['fromdate'] = $fromdate;
        $this->data['sos'] = $sos;
        $this->data['lid'] = $lid;
        if (isset($_GET['json'])) {
            $this->data['rest'] = $rest;
            $this->load->view('layout/dove_json', $this->data);
        } else {
            $this->data['tmpl'] = 'layout/dove';
            $this->load->view('layout/index', $this->data);
        }
    }

}

?>
