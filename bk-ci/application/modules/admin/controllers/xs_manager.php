<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_manager extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('xs_location_model', 'xs_result_model'));
        $this->xs_location_model->order_by('ordering', 'ASC');
        $this->xs_location_model->order_by('id', 'DESC');
        $this->data['xs_location'] = $this->xs_location_model->get_many_by(array("status" => 1));
    }

    function index() {
        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $this->db->start_cache();
        if (isset($_GET["lid"]) && $_GET["lid"] != "") {
            $this->db->where("lid", $_GET["lid"]);
        }
        if (isset($_GET["start_date"]) && isset($_GET["end_date"]) && isset($_GET["date"]) && $_GET["date"] == 1) {
            $start_date = $_GET["start_date"];
            $end_date = $_GET["end_date"];
            $start_date = convert_from_vn_date_to_mysql_date($start_date);
            $end_date = convert_from_vn_date_to_mysql_date($end_date);
            $this->db->where("DATE(date) >=", $start_date);
            $this->db->where("DATE(date) <=", $end_date);
        }
        $this->db->stop_cache();

        $rows = $this->db->select("id,lid,alias,date,a0,a1")->from("xs_result")
                ->order_by("date", "DESC")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_result")->get()->row()->cnt;
        $this->db->flush_cache();

        foreach ($rows as $k => $row) {
            $cat = $this->xs_location_model->get($row->lid);
            if ($cat) {
                $rows[$k]->lname = $cat->name;
                $rows[$k]->lalias = $cat->alias;
            }
        }

        $conf = array(
            'base_url' => admin_url($this->router->class)
            . '/index?x=1'
            . (isset($_GET["lid"]) ? "&lid=" . $_GET["lid"] : "")
            . (isset($_GET["date"]) ? "&date=" . $_GET["date"] : "")
            . (isset($_GET["start_date"]) ? "&start_date=" . $_GET["start_date"] : "")
            . (isset($_GET["end_date"]) ? "&end_date=" . $_GET["end_date"] : ""),
            'total_rows' => $total_rows,
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display_query_string();

        $this->data['rows'] = $rows;
        $this->data["count"] = $total_rows;
        $this->data['offset'] = $offset;
        $this->data['tpl_file'] = 'xs_manager/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $submit = array();
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $lid = $this->input->post('lid');
            $date = $this->input->post('date');
            $a0 = trim($this->input->post('a0'));
            $a1 = trim($this->input->post('a1'));
            $a2 = trim($this->input->post('a2'));
            $a3 = trim($this->input->post('a3'));
            $a4 = trim($this->input->post('a4'));
            $a5 = trim($this->input->post('a5'));
            $a6 = trim($this->input->post('a6'));
            $a7 = trim($this->input->post('a7'));
            $a8 = trim($this->input->post('a8'));

            $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

            $submit['lid'] = $lid;
            $submit['date'] = $date;
            $submit['a0'] = $a0;
            $submit['a1'] = $a1;
            $submit['a2'] = $a2;
            $submit['a3'] = $a3;
            $submit['a4'] = $a4;
            $submit['a5'] = $a5;
            $submit['a6'] = $a6;
            $submit['a7'] = $a7;
            $submit['a8'] = $a8;

            $this->form_validation->set_rules('lid', 'Khu vực', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'lid' => $lid,
                    'date' => $date,
                    'a0' => $a0,
                    'a1' => $a1,
                    'a2' => $a2,
                    'a3' => $a3,
                    'a4' => $a4,
                    'a5' => $a5,
                    'a6' => $a6,
                    'a7' => $a7,
                    'a8' => $a8
                );

                $this->db->where('date', $date);
                $this->db->where('lid', $lid);
                $this->db->from('xs_result');
                if ($this->db->count_all_results() == 0) {
                    $this->getExtension(&$data);
                    $this->db->insert('xs_result', $data);
                    $re = TRUE;
                } else {
                    $this->message->add('error', '<p>Trùng ngày mở thưởng</p>');
                }
            } else {
                $this->message->add('error', validation_errors());
            }
        }

        if ($re) {
            //delete cache
            $this->simple_cache->delete_item('home_data');
            redirect(admin_url($this->data['module']));
        }

        $this->data['submitted'] = $submit;
        $this->data['tpl_file'] = 'xs_manager/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL) {
        $re = false;
        $row = $this->xs_result_model->get($id);
        $submit = array();
        if ($row) {
            $submit['lid'] = $row->lid;
            $submit['date'] = $row->date;
            $submit['a0'] = $row->a0;
            $submit['a1'] = $row->a1;
            $submit['a2'] = $row->a2;
            $submit['a3'] = $row->a3;
            $submit['a4'] = $row->a4;
            $submit['a5'] = $row->a5;
            $submit['a6'] = $row->a6;
            $submit['a7'] = $row->a7;
            $submit['a8'] = $row->a8;

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $lid = $this->input->post('lid');
                $date = $this->input->post('date');
                $a0 = trim($this->input->post('a0'));
                $a1 = trim($this->input->post('a1'));
                $a2 = trim($this->input->post('a2'));
                $a3 = trim($this->input->post('a3'));
                $a4 = trim($this->input->post('a4'));
                $a5 = trim($this->input->post('a5'));
                $a6 = trim($this->input->post('a6'));
                $a7 = trim($this->input->post('a7'));
                $a8 = trim($this->input->post('a8'));

                $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

                $submit['lid'] = $lid;
                $submit['date'] = $date;
                $submit['a0'] = $a0;
                $submit['a1'] = $a1;
                $submit['a2'] = $a2;
                $submit['a3'] = $a3;
                $submit['a4'] = $a4;
                $submit['a5'] = $a5;
                $submit['a6'] = $a6;
                $submit['a7'] = $a7;
                $submit['a8'] = $a8;

                $this->form_validation->set_rules('lid', 'Khu vực', 'required');

                if ($this->form_validation->run() == TRUE) {
                    $data = array(
                        'lid' => $lid,
                        'date' => $date,
                        'a0' => $a0,
                        'a1' => $a1,
                        'a2' => $a2,
                        'a3' => $a3,
                        'a4' => $a4,
                        'a5' => $a5,
                        'a6' => $a6,
                        'a7' => $a7,
                        'a8' => $a8
                    );

                    $this->db->where('date', $date);
                    $this->db->where('lid', $lid);
                    $this->db->where('id <>', $id);
                    $this->db->from('xs_result');
                    if ($this->db->count_all_results() == 0) {
                        $this->getExtension(&$data);
                        $this->xs_result_model->update($id, $data);
                        $re = TRUE;
                    } else {
                        $this->message->add('error', '<p>Trùng ngày mở thưởng</p>');
                    }
                } else {
                    $this->message->add('error', validation_errors());
                }
            }
        }

        if ($re == true) {
            //delete cache
            $this->simple_cache->delete_item('home_data');
            redirect(admin_url($this->data['module'] . '/index'));
        }

        $this->data['row'] = $row;
        $this->data['submitted'] = $submit;

        $this->data['tpl_file'] = 'xs_manager/edit';
        $this->load->view('layout/default', $this->data);
    }

    function getExtension(&$data) {
        $arr_loto = array();
        $data['b0'] = '';
        $data['b1'] = '';
        $data['b2'] = '';
        $data['b3'] = '';
        $data['b4'] = '';
        $data['b5'] = '';
        $data['b6'] = '';
        $data['b7'] = '';
        $data['b8'] = '';

        if ($data['a8'] != '') {
            $arr_loto[] = $data['a8'];
            $data['b8'] = $data['a8'];
        }
        if ($data['a7'] != '') {
            $tmp = explode('-', $data['a7']);
            foreach ($tmp as $value) {
                $arr_loto[] = trim($value);
                if (strlen($data['b7']) == '')
                    $data['b7'] = $value;
                else
                    $data['b7'] .= ',' . $value;
            }
        }
        if ($data['a6'] != '') {
            $tmp = explode('-', $data['a6']);
            foreach ($tmp as $value) {
                $value = substr($value, -2, 2);
                $arr_loto[] = trim($value);
                if (strlen($data['b6']) == '')
                    $data['b6'] = $value;
                else
                    $data['b6'] .= ',' . $value;
            }
        }
        if ($data['a5'] != '') {
            $tmp = explode('-', $data['a5']);
            foreach ($tmp as $value) {
                $value = substr($value, -2, 2);
                $arr_loto[] = trim($value);
                if (strlen($data['b5']) == '')
                    $data['b5'] = $value;
                else
                    $data['b5'] .= ',' . $value;
            }
        }
        if ($data['a4'] != '') {
            $tmp = explode('-', $data['a4']);
            foreach ($tmp as $value) {
                $value = substr($value, -2, 2);
                $arr_loto[] = trim($value);
                if (strlen($data['b4']) == '')
                    $data['b4'] = $value;
                else
                    $data['b4'] .= ',' . $value;
            }
        }
        if ($data['a3'] != '') {
            $tmp = explode('-', $data['a3']);
            foreach ($tmp as $value) {
                $value = substr($value, -2, 2);
                $arr_loto[] = trim($value);
                if (strlen($data['b3']) == '')
                    $data['b3'] = $value;
                else
                    $data['b3'] .= ',' . $value;
            }
        }
        if ($data['a2'] != '') {
            $tmp = explode('-', $data['a2']);
            foreach ($tmp as $value) {
                $value = substr($value, -2, 2);
                $arr_loto[] = trim($value);
                if (strlen($data['b2']) == '')
                    $data['b2'] = $value;
                else
                    $data['b2'] .= ',' . $value;
            }
        }
        if ($data['a1'] != '') {
            $value = substr($data['a1'], -2, 2);
            $arr_loto[] = $value;
            $data['b1'] = $value;
        }
        if ($data['a0'] != '') {
            $value = substr($data['a0'], -2, 2);
            $arr_loto[] = $value;
            $data['b0'] = $value;
        }

        $duoi0 = "";
        $duoi1 = "";
        $duoi2 = "";
        $duoi3 = "";
        $duoi4 = "";
        $duoi5 = "";
        $duoi6 = "";
        $duoi7 = "";
        $duoi8 = "";
        $duoi9 = "";
        //lay loto duoi
        for ($j = 0; $j < count($arr_loto); $j++) {
            if (substr($arr_loto[$j], 0, 1) == '0') {
                if ($duoi0 == '')
                    $duoi0 .= substr($arr_loto[$j], 1, 1);
                else
                    $duoi0 .= "," . substr($arr_loto[$j], 1, 1);
            }
            if (substr($arr_loto[$j], 0, 1) == '1') {
                if ($duoi1 == '')
                    $duoi1 .= substr($arr_loto[$j], 1, 1);
                else
                    $duoi1 .= "," . substr($arr_loto[$j], 1, 1);
            }
            if (substr($arr_loto[$j], 0, 1) == '2') {
                if ($duoi2 == '')
                    $duoi2 .= substr($arr_loto[$j], 1, 1);
                else
                    $duoi2 .= "," . substr($arr_loto[$j], 1, 1);
            }
            if (substr($arr_loto[$j], 0, 1) == '3') {
                if ($duoi3 == '')
                    $duoi3 .= substr($arr_loto[$j], 1, 1);
                else
                    $duoi3 .= "," . substr($arr_loto[$j], 1, 1);
            }
            if (substr($arr_loto[$j], 0, 1) == '4') {
                if ($duoi4 == '')
                    $duoi4 .= substr($arr_loto[$j], 1, 1);
                else
                    $duoi4 .= "," . substr($arr_loto[$j], 1, 1);
            }
            if (substr($arr_loto[$j], 0, 1) == '5') {
                if ($duoi5 == '')
                    $duoi5 .= substr($arr_loto[$j], 1, 1);
                else
                    $duoi5 .= "," . substr($arr_loto[$j], 1, 1);
            }
            if (substr($arr_loto[$j], 0, 1) == '6') {
                if ($duoi6 == '')
                    $duoi6 .= substr($arr_loto[$j], 1, 1);
                else
                    $duoi6 .= "," . substr($arr_loto[$j], 1, 1);
            }
            if (substr($arr_loto[$j], 0, 1) == '7') {
                if ($duoi7 == '')
                    $duoi7 .= substr($arr_loto[$j], 1, 1);
                else
                    $duoi7 .= "," . substr($arr_loto[$j], 1, 1);
            }
            if (substr($arr_loto[$j], 0, 1) == '8') {
                if ($duoi8 == '')
                    $duoi8 .= substr($arr_loto[$j], 1, 1);
                else
                    $duoi8 .= "," . substr($arr_loto[$j], 1, 1);
            }
            if (substr($arr_loto[$j], 0, 1) == '9') {
                if ($duoi9 == '')
                    $duoi9 .= substr($arr_loto[$j], 1, 1);
                else
                    $duoi9 .= "," . substr($arr_loto[$j], 1, 1);
            }
        }
        $extra[0] = $duoi0;
        $extra[1] = $duoi1;
        $extra[2] = $duoi2;
        $extra[3] = $duoi3;
        $extra[4] = $duoi4;
        $extra[5] = $duoi5;
        $extra[6] = $duoi6;
        $extra[7] = $duoi7;
        $extra[8] = $duoi8;
        $extra[9] = $duoi9;
        $data['extension'] = json_encode($extra);
    }

    function delete($id = NULL) {
        if ($row = $this->xs_result_model->get($id)) {
            if ($this->xs_result_model->delete($id)) {
                //delete cache
                $this->simple_cache->delete_item('home_data');
                admin_redirect($this->data['module']);
            }
        }
    }

}
