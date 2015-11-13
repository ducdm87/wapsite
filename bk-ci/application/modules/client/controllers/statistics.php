<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'client' . EXT;

class statistics extends Client {

    function __construct() {
        parent::__construct();
        $this->load->model(array('xs_result_model', 'xs_statistics_links_model'));
//        $this->data['xs_location'] = $this->xs_location_model->select('id,name,alias,lich')->order_by('ordering', 'ASC')->get_many_by(array("status" => 1));
    }

    public function index($statistics_links, $alias = 'xo-so-mien-bac') {
        $time_turn = (isset($_POST['time_turn']) ? $_POST['time_turn'] : 30);
//        if ((!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0) && $time_turn > 30) {
//            $time_turn = 30;
//        }
        $lid = 0;

        $lname = '';
        if ($alias != '') {
            foreach ($this->data['xs_location_menu'] as $value) {
                if ($value->alias == $alias) {
                    $lid = $value->id;
                    $lname = $value->name;
                    break;
                }
            }
        }

        if ($lid == 0)
            redirect($this->data['uri_root'] . '404_override');

        $replace_str = '';
        if ($lid == 1) {
            $replace_str = 'quan trọng Xổ số Miền Bắc';
        } else {
            $replace_str = 'quan trọng Xổ số ' . $lname;
        }

        $search = array('[TITLE]');
        $replace = array($replace_str);
        $this->data['_meta'] = $this->meta_model->show_title('thong_ke', $search, $replace);
        $this->data['items'] = $this->xs_result_model->getitemsImportant($lid, $time_turn);

        $statistics_content = $this->xs_statistics_links_model->get_by(array('alias' => $statistics_links, 'published' => 1));
        $this->data['statistics_content'] = $statistics_content->content;

        $this->data['lid'] = $lid;
        $this->data['time_turn'] = $time_turn;
        $this->data['tmpl'] = 'statistics/index';
        $this->load->view('default', $this->data);
    }

    public function synthesis($statistics_links, $alias = 'xo-so-mien-bac') {
        $fromdate = (isset($_POST['fromdate']) ? $_POST['fromdate'] : date('d-m-Y', strtotime('-365 days')));
        $todate = (isset($_POST['todate']) ? $_POST['todate'] : date('d-m-Y'));
        $lid = 0;
        $type = (isset($_POST['type']) ? $_POST['type'] : 't4');

        $lname = '';
        if ($alias != '') {
            foreach ($this->data['xs_location_menu'] as $value) {
                if ($value->alias == $alias) {
                    $lid = $value->id;
                    $lname = $value->name;
                    break;
                }
            }
        }

        if ($lid == 0)
            redirect($this->data['uri_root'] . '404_override');

        $replace_str = '';
        if ($lid == 1) {
            $replace_str = 'theo bộ số Xổ số Miền Bắc';
        } else {
            $replace_str = 'theo bộ số Xổ số ' . $lname;
        }

        $search = array('[TITLE]');
        $replace = array($replace_str);
        $this->data['_meta'] = $this->meta_model->show_title('thong_ke', $search, $replace);
        $this->data['items'] = $this->xs_result_model->getItemsSynthesis($fromdate, $todate, $lid, $type);

        $statistics_content = $this->xs_statistics_links_model->get_by(array('alias' => $statistics_links, 'published' => 1));
        $this->data['statistics_content'] = $statistics_content->content;

        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;
        $this->data['lid'] = $lid;
        $this->data['type'] = $type;
        $this->data['tmpl'] = 'statistics/synthesis';
        $this->load->view('default', $this->data);
    }

    public function loto($statistics_links, $alias = 'xo-so-mien-bac') {
        $fromdate = (isset($_POST['fromdate']) ? $_POST['fromdate'] : date('d-m-Y', strtotime('-365 days')));
        $todate = (isset($_POST['todate']) ? $_POST['todate'] : date('d-m-Y'));
        $number = (isset($_POST['number']) ? trim($_POST['number']) : '');
        $lid = 0;

        $lname = '';
        if ($alias != '') {
            foreach ($this->data['xs_location_menu'] as $value) {
                if ($value->alias == $alias) {
                    $lid = $value->id;
                    $lname = $value->name;
                    break;
                }
            }
        }

        if ($lid == 0)
            redirect($this->data['uri_root'] . '404_override');

        $replace_str = '';
        if ($lid == 1) {
            $replace_str = 'Loto nhanh Xổ số Miền Bắc';
        } else {
            $replace_str = 'Loto nhanh Xổ số ' . $lname;
        }

        $search = array('[TITLE]');
        $replace = array($replace_str);
        $this->data['_meta'] = $this->meta_model->show_title('thong_ke', $search, $replace);

        $this->data['items'] = array();
        if (isset($_POST['number']) && trim($_POST['number']) != '') {
            $arr_number = explode(',', $number);
            $arr_number = array_slice($arr_number, 0, 5);
            $arr_max_number = implode(',', $arr_number);
            $this->data['items'] = $this->xs_result_model->getItemsLoto($fromdate, $todate, $arr_max_number, $lid);
        }

        $statistics_content = $this->xs_statistics_links_model->get_by(array('alias' => $statistics_links, 'published' => 1));
        $this->data['statistics_content'] = $statistics_content->content;

        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;
        $this->data['number'] = $number;
        $this->data['lid'] = $lid;
        $this->data['tmpl'] = 'statistics/loto';
        $this->load->view('default', $this->data);
    }

    public function gan($statistics_links, $alias = 'xo-so-mien-bac') {
        $fromdate = (isset($_POST['fromdate']) ? $_POST['fromdate'] : date('d-m-Y', strtotime('-365 days')));
//        if ((!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0) && strtotime($fromdate) < strtotime('-365 days'))
//            $fromdate = date('d-m-Y', strtotime('-365 days'));
        $todate = (isset($_POST['todate']) ? $_POST['todate'] : date('d-m-Y'));
        $number = (isset($_POST['number']) ? trim($_POST['number']) : '');
        $lid = 0;
        $amplitude = (isset($_POST['amplitude']) ? trim($_POST['amplitude']) : 10);
//        if (!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0)
//            $amplitude = 10;
        $type = (isset($_POST['type']) ? $_POST['type'] : 1);

        $lname = '';
        if ($alias != '') {
            foreach ($this->data['xs_location_menu'] as $value) {
                if ($value->alias == $alias) {
                    $lid = $value->id;
                    $lname = $value->name;
                    break;
                }
            }
        }

        if ($lid == 0)
            redirect($this->data['uri_root'] . '404_override');

        $replace_str = '';
        if ($lid == 1) {
            $replace_str = 'Loto gan Xổ số Miền Bắc';
        } else {
            $replace_str = 'Loto gan Xổ số ' . $lname;
        }

        $search = array('[TITLE]');
        $replace = array($replace_str);
        $this->data['_meta'] = $this->meta_model->show_title('thong_ke', $search, $replace);

        $this->data['items'] = array();
        if (isset($_POST['number']) && trim($_POST['number']) != '') {
            $arr_number = explode(',', $number);
            $arr_number = array_slice($arr_number, 0, 10);
            $arr_max_number = implode(',', $arr_number);
            $this->data['items'] = $this->xs_result_model->getItemsNumberLiver($fromdate, $todate, $arr_max_number, $lid, $amplitude, $type);
        }

        $statistics_content = $this->xs_statistics_links_model->get_by(array('alias' => $statistics_links, 'published' => 1));
        $this->data['statistics_content'] = $statistics_content->content;

        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;
        $this->data['number'] = $number;
        $this->data['lid'] = $lid;
        $this->data['amplitude'] = $amplitude;
        $this->data['type'] = $type;
        $this->data['tmpl'] = 'statistics/gan';
        $this->load->view('default', $this->data);
    }

    public function two($statistics_links, $alias = 'xo-so-mien-bac') {
        $time_turn = (isset($_POST['time_turn']) ? $_POST['time_turn'] : 30);
//        if ((!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0) && $time_turn > 30) {
//            $time_turn = 30;
//        }
        $lid = 0;
        $type = (isset($_POST['type']) ? $_POST['type'] : 0);

        $lname = '';
        if ($alias != '') {
            foreach ($this->data['xs_location_menu'] as $value) {
                if ($value->alias == $alias) {
                    $lid = $value->id;
                    $lname = $value->name;
                    break;
                }
            }
        }

        if ($lid == 0)
            redirect($this->data['uri_root'] . '404_override');

        $replace_str = '';
        if ($lid == 1) {
            $replace_str = 'cặp số từ 00 - 99 Xổ số Miền Bắc';
        } else {
            $replace_str = 'cặp số từ 00 - 99 Xổ số ' . $lname;
        }

        $search = array('[TITLE]');
        $replace = array($replace_str);
        $this->data['_meta'] = $this->meta_model->show_title('thong_ke', $search, $replace);
        $this->data['items'] = $this->xs_result_model->getItemsTwo($time_turn, $lid, $type);

        $statistics_content = $this->xs_statistics_links_model->get_by(array('alias' => $statistics_links, 'published' => 1));
        $this->data['statistics_content'] = $statistics_content->content;

        $this->data['lid'] = $lid;
        $this->data['time_turn'] = $time_turn;
        $this->data['type'] = $type;
        $this->data['tmpl'] = 'statistics/two';
        $this->load->view('default', $this->data);
    }

    public function chuky($statistics_links, $alias = 'xo-so-mien-bac') {
        $fromdate = (isset($_POST['fromdate']) ? $_POST['fromdate'] : date('d-m-Y', strtotime('-30 days')));
        $todate = (isset($_POST['todate']) ? $_POST['todate'] : date('d-m-Y'));
        $lid = 0;

        $lname = '';
        if ($alias != '') {
            foreach ($this->data['xs_location_menu'] as $value) {
                if ($value->alias == $alias) {
                    $lid = $value->id;
                    $lname = $value->name;
                    break;
                }
            }
        }

        if ($lid == 0)
            redirect($this->data['uri_root'] . '404_override');

        $replace_str = '';
        if ($lid == 1) {
            $replace_str = 'theo chu kỳ Xổ số Miền Bắc';
        } else {
            $replace_str = 'theo chu kỳ Xổ số ' . $lname;
        }

        $search = array('[TITLE]');
        $replace = array($replace_str);
        $this->data['_meta'] = $this->meta_model->show_title('thong_ke', $search, $replace);
        list($this->data['items'], $this->data['count']) = $this->xs_result_model->getItemsChuKy($fromdate, $todate, $lid);

        $statistics_content = $this->xs_statistics_links_model->get_by(array('alias' => $statistics_links, 'published' => 1));
        $this->data['statistics_content'] = $statistics_content->content;

        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;
        $this->data['lid'] = $lid;
        $this->data['tmpl'] = 'statistics/chuky';
        $this->load->view('column1', $this->data);
    }

    public function week($statistics_links, $type = 0, $alias = 'xo-so-mien-bac') {
        $fromdate = (isset($_POST['fromdate']) ? $_POST['fromdate'] : date('d-m-Y', strtotime('-30 days')));
        $todate = (isset($_POST['todate']) ? $_POST['todate'] : date('d-m-Y'));
        $lid = 0;

        $lname = '';
        if ($alias != '') {
            foreach ($this->data['xs_location_menu'] as $value) {
                if ($value->alias == $alias) {
                    $lid = $value->id;
                    $lname = $value->name;
                    break;
                }
            }
        }

        if ($lid == 0)
            redirect($this->data['uri_root'] . '404_override');

        $replace_str = '';
        $meta_title = '';
        if ($type == 1)
            $meta_title = 'cặp số cuối giải đặc biệt theo tuần';
        else
            $meta_title = 'giải đặc biệt theo tuần';
        if ($lid == 1) {
            $replace_str = $meta_title . ' Xổ số Miền Bắc';
        } else {
            $replace_str = $meta_title . ' Xổ số ' . $lname;
        }

        $search = array('[TITLE]');
        $replace = array($replace_str);
        $this->data['_meta'] = $this->meta_model->show_title('thong_ke', $search, $replace);
        $this->data['items'] = $this->xs_result_model->getItemsWeek($fromdate, $todate, $lid, $type);

        $statistics_content = $this->xs_statistics_links_model->get_by(array('alias' => $statistics_links, 'published' => 1));
        $this->data['statistics_content'] = $statistics_content->content;

        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;
        $this->data['lid'] = $lid;
        $this->data['type'] = $type;
        $this->data['tmpl'] = 'statistics/week';
        $this->load->view('default', $this->data);
    }

    public function month($statistics_links, $type = 0, $alias = 'xo-so-mien-bac') {
        $fromdate = (isset($_POST['fy']) ? $_POST['fy'] : date('Y'));
        $todate = (isset($_POST['ty']) ? $_POST['ty'] : date('Y'));
        $lid = 0;

        $lname = '';
        if ($alias != '') {
            foreach ($this->data['xs_location_menu'] as $value) {
                if ($value->alias == $alias) {
                    $lid = $value->id;
                    $lname = $value->name;
                    break;
                }
            }
        }

        if ($lid == 0)
            redirect($this->data['uri_root'] . '404_override');

        $replace_str = '';
        $meta_title = '';
        if ($type == 1)
            $meta_title = 'cặp số cuối giải đặc biệt theo tháng';
        else
            $meta_title = 'giải đặc biệt theo tháng';
        if ($lid == 1) {
            $replace_str = $meta_title . ' Xổ số Miền Bắc';
        } else {
            $replace_str = $meta_title . ' Xổ số ' . $lname;
        }

        $search = array('[TITLE]');
        $replace = array($replace_str);
        $this->data['_meta'] = $this->meta_model->show_title('thong_ke', $search, $replace);
        $this->data['items'] = $this->xs_result_model->getItemsMonth($fromdate, $todate, $lid);

        $statistics_content = $this->xs_statistics_links_model->get_by(array('alias' => $statistics_links, 'published' => 1));
        $this->data['statistics_content'] = $statistics_content->content;

        $this->data['fy'] = $fromdate;
        $this->data['ty'] = $todate;
        $this->data['lid'] = $lid;
        $this->data['type'] = $type;
        $this->data['tmpl'] = 'statistics/month';
        $this->load->view('column2', $this->data);
    }

    public function first_last($statistics_links, $alias = 'xo-so-mien-bac') {
        $time_turn = (isset($_POST['time_turn']) ? $_POST['time_turn'] : 30);
//        if ((!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0) && $time_turn > 30) {
//            $time_turn = 30;
//        }
        $lid = 0;

        $lname = '';
        if ($alias != '') {
            foreach ($this->data['xs_location_menu'] as $value) {
                if ($value->alias == $alias) {
                    $lid = $value->id;
                    $lname = $value->name;
                    break;
                }
            }
        }

        if ($lid == 0)
            redirect($this->data['uri_root'] . '404_override');

        $replace_str = '';
        if ($lid == 1) {
            $replace_str = 'đầu đuôi 0-9 Xổ số Miền Bắc';
        } else {
            $replace_str = 'đầu đuôi 0-9 Xổ số ' . $lname;
        }

        $search = array('[TITLE]');
        $replace = array($replace_str);
        $this->data['_meta'] = $this->meta_model->show_title('thong_ke', $search, $replace);
        $this->data['items'] = $this->xs_result_model->getItemsFirstLast($time_turn, $lid);

        $statistics_content = $this->xs_statistics_links_model->get_by(array('alias' => $statistics_links, 'published' => 1));
        $this->data['statistics_content'] = $statistics_content->content;

        $this->data['lid'] = $lid;
        $this->data['time_turn'] = $time_turn;
        $this->data['tmpl'] = 'statistics/first_last';
        $this->load->view('default', $this->data);
    }

    public function sum($statistics_links, $alias = 'xo-so-mien-bac') {
        $time_turn = (isset($_POST['time_turn']) ? $_POST['time_turn'] : 30);
//        if ((!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0) && $time_turn > 30) {
//            $time_turn = 30;
//        }
        $lid = 0;
        $type = (isset($_POST['type']) ? $_POST['type'] : 't1');

        $lname = '';
        if ($alias != '') {
            foreach ($this->data['xs_location_menu'] as $value) {
                if ($value->alias == $alias) {
                    $lid = $value->id;
                    $lname = $value->name;
                    break;
                }
            }
        }

        if ($lid == 0)
            redirect($this->data['uri_root'] . '404_override');

        $replace_str = '';
        if ($lid == 1) {
            $replace_str = 'theo tổng 2 số cuối Xổ số Miền Bắc';
        } else {
            $replace_str = 'theo tổng 2 số cuối Xổ số ' . $lname;
        }

        $search = array('[TITLE]');
        $replace = array($replace_str);
        $this->data['_meta'] = $this->meta_model->show_title('thong_ke', $search, $replace);
        $this->data['items'] = $this->xs_result_model->getItemsSum($time_turn, $lid, $type);

        $statistics_content = $this->xs_statistics_links_model->get_by(array('alias' => $statistics_links, 'published' => 1));
        $this->data['statistics_content'] = $statistics_content->content;

        $this->data['lid'] = $lid;
        $this->data['time_turn'] = $time_turn;
        $this->data['type'] = $type;
        $this->data['tmpl'] = 'statistics/sum';
        $this->load->view('default', $this->data);
    }

    public function sum_even_odd($statistics_links, $type = 0, $alias = 'xo-so-mien-bac') {
        $time_turn = (isset($_POST['time_turn']) ? $_POST['time_turn'] : 30);
//        if ((!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0) && $time_turn > 30) {
//            $time_turn = 30;
//        }
        $lid = 0;

        $lname = '';
        if ($alias != '') {
            foreach ($this->data['xs_location_menu'] as $value) {
                if ($value->alias == $alias) {
                    $lid = $value->id;
                    $lname = $value->name;
                    break;
                }
            }
        }

        if ($lid == 0)
            redirect($this->data['uri_root'] . '404_override');

        $replace_str = '';
        $meta_title = '';
        if ($type == 1)
            $meta_title = 'theo tổng lẻ';
        else
            $meta_title = 'theo tổng chẵn';
        if ($lid == 1) {
            $replace_str = $meta_title . ' Xổ số Miền Bắc';
        } else {
            $replace_str = $meta_title . ' Xổ số ' . $lname;
        }

        $search = array('[TITLE]');
        $replace = array($replace_str);
        $this->data['_meta'] = $this->meta_model->show_title('thong_ke', $search, $replace);
        $this->data['items'] = $this->xs_result_model->getItemsSumEvenOdd($time_turn, $lid, $type);

        $statistics_content = $this->xs_statistics_links_model->get_by(array('alias' => $statistics_links, 'published' => 1));
        $this->data['statistics_content'] = $statistics_content->content;

        $this->data['lid'] = $lid;
        $this->data['time_turn'] = $time_turn;
        $this->data['type'] = $type;
        $this->data['tmpl'] = 'statistics/sum_even_odd';
        $this->load->view('default', $this->data);
    }

    public function dau_duoi($statistics_links, $alias = 'xo-so-mien-bac') {
        $fromdate = (isset($_POST['fromdate']) ? $_POST['fromdate'] : date('d-m-Y', strtotime('-30 days')));
        $todate = (isset($_POST['todate']) ? $_POST['todate'] : date('d-m-Y'));
        $lid = 0;
        $type = (isset($_POST['type']) ? $_POST['type'] : 0);

        $lname = '';
        if ($alias != '') {
            foreach ($this->data['xs_location_menu'] as $value) {
                if ($value->alias == $alias) {
                    $lid = $value->id;
                    $lname = $value->name;
                    break;
                }
            }
        }

        if ($lid == 0)
            redirect($this->data['uri_root'] . '404_override');

        $replace_str = '';
        if ($lid == 1) {
            $replace_str = 'Loto theo đầu/đuôi Xổ số Miền Bắc';
        } else {
            $replace_str = 'Loto theo đầu/đuôi Xổ số ' . $lname;
        }

        $search = array('[TITLE]');
        $replace = array($replace_str);
        $this->data['_meta'] = $this->meta_model->show_title('thong_ke', $search, $replace);
        $this->data['items'] = $this->xs_result_model->getItemsDauDuoi($fromdate, $todate, $lid, $type);

        $statistics_content = $this->xs_statistics_links_model->get_by(array('alias' => $statistics_links, 'published' => 1));
        $this->data['statistics_content'] = $statistics_content->content;

        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;
        $this->data['lid'] = $lid;
        $this->data['type'] = $type;
        $this->data['tmpl'] = 'statistics/dau_duoi';
        $this->load->view('default', $this->data);
    }

    public function loto_sum($statistics_links, $alias = 'xo-so-mien-bac') {
        $fromdate = (isset($_POST['fromdate']) ? $_POST['fromdate'] : date('d-m-Y', strtotime('-30 days')));
        $todate = (isset($_POST['todate']) ? $_POST['todate'] : date('d-m-Y'));
        $lid = 0;

        $lname = '';
        if ($alias != '') {
            foreach ($this->data['xs_location_menu'] as $value) {
                if ($value->alias == $alias) {
                    $lid = $value->id;
                    $lname = $value->name;
                    break;
                }
            }
        }

        if ($lid == 0)
            redirect($this->data['uri_root'] . '404_override');

        $replace_str = '';
        if ($lid == 1) {
            $replace_str = 'theo tổng Xổ số Miền Bắc';
        } else {
            $replace_str = 'theo tổng Xổ số ' . $lname;
        }

        $search = array('[TITLE]');
        $replace = array($replace_str);
        $this->data['_meta'] = $this->meta_model->show_title('thong_ke', $search, $replace);
        $this->data['items'] = $this->xs_result_model->getItemsLotoSum($fromdate, $todate, $lid);

        $statistics_content = $this->xs_statistics_links_model->get_by(array('alias' => $statistics_links, 'published' => 1));
        $this->data['statistics_content'] = $statistics_content->content;

        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;
        $this->data['lid'] = $lid;
        $this->data['tmpl'] = 'statistics/loto_sum';
        $this->load->view('default', $this->data);
    }

    public function doveso() {
        $fromdate = (isset($_GET['ngay']) ? $_GET['ngay'] : date('d-m-Y'));
        $sos = (isset($_GET['so']) ? trim($_GET['so']) : '');
        $lid = (isset($_GET['tinh']) ? $_GET['tinh'] : 'xo-so-mien-bac');

        $search = array();
        $replace = array();
        $this->data['_meta'] = $this->meta_model->show_title('do_ve_so', $search, $replace);

        $this->data['items'] = array();
        $this->data['result'] = "";
        if ($fromdate != '' && $sos != '') {
            $this->data['items'] = $this->xs_result_model->Doveso($lid, $fromdate);
            if ($this->data['items']) {
                $arr_so = explode(',', $sos);
                foreach ($arr_so as $i => $so) {
//                    if ((!isset($_SESSION['user']) || $_SESSION['user']['gender'] == 0) && $i > 0)
//                        break;
                    $so = trim($so);
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
        $this->data['tmpl'] = 'statistics/doveso';
        $this->load->view('default', $this->data);
    }

    public function loadtinh($selected_id, $lid, $date) {
        $datew = date('w', strtotime($date));
        ?>
        <select name="tinh" id="<?php echo $selected_id ?>" tabindex="1">
            <?php
            foreach ($this->data['xs_location_menu'] as $value) {
                if (strpos($value->lich, strval($datew + 1)) !== false) {
                    $selected = '';
                    if ($lid == $value->alias) {
                        $selected = ' selected=""';
                    }
                    echo '<option' . $selected . ' value="' . $value->alias . '">' . $value->name . '</option>';
                }
            }
            ?>
        </select>
        <?php
    }

}