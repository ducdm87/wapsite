<?php

//mobile/doveso/index?ngay=11-03-2013&tinh=1&so=83014
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'mobile' . EXT;

class doveso extends mobile {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $fromdate = (isset($_GET['ngay']) ? $_GET['ngay'] : date('d-m-Y'));
        $so = (isset($_GET['so']) ? trim($_GET['so']) : '');
        $lid = (isset($_GET['tinh']) ? $_GET['tinh'] : 1);

        $this->data['items'] = array();
        $this->data['result'] = -1;
        if ($fromdate != '' && $so != '') {
            $this->data['items'] = $this->xs_result_model->Doveso($lid, $fromdate);
            if ($this->data['items']) {
                if (strlen($so) == strlen($this->data['items']->a0)) {
                    if ($this->data['items']->area == 'MB') {
                        if ($so == $this->data['items']->a0)
                            $this->data['result'] = 0;
                        elseif ($so == $this->data['items']->a1)
                            $this->data['result'] = 1;
                        elseif (strpos($this->data['items']->a2 . '-', $so . '-') !== false)
                            $this->data['result'] = 2;
                        elseif (strpos($this->data['items']->a3 . '-', $so . '-') !== false)
                            $this->data['result'] = 3;
                        elseif (strpos($this->data['items']->a4 . '-', substr($so, -4) . '-') !== false)
                            $this->data['result'] = 4;
                        elseif (strpos($this->data['items']->a5 . '-', substr($so, -4) . '-') !== false)
                            $this->data['result'] = 5;
                        elseif (strpos($this->data['items']->a6 . '-', substr($so, -3) . '-') !== false)
                            $this->data['result'] = 6;
                        elseif (strpos($this->data['items']->a7 . '-', substr($so, -2) . '-') !== false)
                            $this->data['result'] = 7;
                        elseif (strpos($this->data['items']->a0 . '-', substr($so, -2) . '-') !== false)
                            $this->data['result'] = 8;
                    }else {
                        if ($so == $this->data['items']->a0)
                            $this->data['result'] = 0;
                        elseif (substr($so, -5) == $this->data['items']->a1)
                            $this->data['result'] = 1;
                        elseif (substr($so, -5) == $this->data['items']->a2)
                            $this->data['result'] = 2;
                        elseif (strpos($this->data['items']->a3 . '-', substr($so, -5) . '-') !== false)
                            $this->data['result'] = 3;
                        elseif (strpos($this->data['items']->a4 . '-', substr($so, -5) . '-') !== false)
                            $this->data['result'] = 4;
                        elseif (substr($so, -4) == $this->data['items']->a5)
                            $this->data['result'] = 5;
                        elseif (strpos($this->data['items']->a6 . '-', substr($so, -4) . '-') !== false)
                            $this->data['result'] = 6;
                        elseif (substr($so, -3) == $this->data['items']->a7)
                            $this->data['result'] = 7;
                        elseif (substr($so, -2) == $this->data['items']->a8)
                            $this->data['result'] = 8;

                        if (strlen($this->data['items']->a0) == 5) {
                            if (strpos($this->data['items']->a0 . '-', substr($so, -2) . '-') !== false)
                                $this->data['result'] = 10;
                        }else {
                            if ($this->data['result'] != 0 && strpos($this->data['items']->a0 . '-', substr($so, -5) . '-') !== false)
                                $this->data['result'] = 9;
                            if ($this->data['result'] == -1 || ($this->data['result'] >= 4 && $this->data['result'] <= 8)) {
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
                                    $this->data['result'] = 10;
                                elseif (preg_match('/' . $dau2 . '\d' . $duoi2 . '/', $this->data['items']->a0))
                                    $this->data['result'] = 10;
                                elseif (preg_match('/' . $dau3 . '\d' . $duoi3 . '/', $this->data['items']->a0))
                                    $this->data['result'] = 10;
                                elseif (preg_match('/' . $dau4 . '\d' . $duoi4 . '/', $this->data['items']->a0))
                                    $this->data['result'] = 10;
                                elseif (preg_match('/' . $dau5 . '\d/', $this->data['items']->a0))
                                    $this->data['result'] = 10;
                            }
                        }
                    }
                }else {
                    $this->data['result'] = 999;
                }
            }
        }
//        var_dump($this->data['result']);
        $this->data['fromdate'] = $fromdate;
        $this->data['so'] = $so;
        $this->data['lid'] = $lid;
        $this->data['tmpl'] = 'statistics/doveso';
        $this->load->view('layout/content', $this->data);
    }

}