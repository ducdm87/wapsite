<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_northern extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model('xs_northern_model');
    }

    function index() {
        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $this->db->start_cache();
        if (isset($_GET["type"]) && $_GET["type"] != "") {
            $this->db->where("type", $_GET["type"]);
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

        $rows = $this->db->select("*")->from("xs_northern")
                ->order_by("date", "DESC")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_northern")->get()->row()->cnt;
        $this->db->flush_cache();

        $conf = array(
            'base_url' => admin_url($this->router->class)
            . '/index?x=1'
            . (isset($_GET["type"]) ? "&type=" . $_GET["type"] : "")
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
        $this->data['tpl_file'] = 'xs_northern/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $submit = array();
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $type = $this->input->post('type');
            $date = $this->input->post('date');
            $data = trim($this->input->post('data'));
            $alias = trim($this->input->post('alias'));
            $status = (int) $this->input->post('status');

            $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

            $submit['type'] = $type;
            $submit['date'] = $date;
            $submit['data'] = $data;
            $submit['alias'] = $alias;
            $submit['status'] = $status;

            $this->form_validation->set_rules('type', 'Loại hình xổ số', 'required');

            if ($this->form_validation->run() == TRUE) {
                $arr_data = explode('-', $data);
                $data = json_encode($arr_data);
                $data = array(
                    'type' => $type,
                    'date' => $date,
                    'data' => $data,
                    'alias' => $alias,
                    'status' => $status,
                    'created_time' => date('Y-m-d H:i:s')
                );

                $this->db->where('date', $date);
                $this->db->where('type', $type);
                $this->db->from('xs_northern');
                if ($this->db->count_all_results() == 0) {
                    $this->db->insert('xs_northern', $data);
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
        $this->data['tpl_file'] = 'xs_northern/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL) {
        $re = false;
        $row = $this->xs_northern_model->get($id);
        $submit = array();
        if ($row) {
            $submit['type'] = $row->type;
            $submit['date'] = $row->date;
            $arr_data = json_decode($row->data);
            $submit['data'] = implode('-', $arr_data);
            $submit['alias'] = $row->alias;
            $submit['status'] = $row->status;

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $type = $this->input->post('type');
                $date = $this->input->post('date');
                $data = trim($this->input->post('data'));
                $alias = trim($this->input->post('alias'));
                $status = (int) $this->input->post('status');

                $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

                $submit['type'] = $type;
                $submit['date'] = $date;
                $submit['data'] = $data;
                $submit['alias'] = $alias;
                $submit['status'] = $status;

                $this->form_validation->set_rules('type', 'Loại hình xổ số', 'required');

                if ($this->form_validation->run() == TRUE) {
                    $arr_data = explode('-', $data);
                    $data = json_encode($arr_data);
                    $data = array(
                        'type' => $type,
                        'date' => $date,
                        'data' => $data,
                        'alias' => $alias,
                        'status' => $status,
//                        'created_time' => date('Y-m-d H:i:s')
                    );

                    $this->db->where('date', $date);
                    $this->db->where('type', $type);
                    $this->db->where('id <>', $id);
                    $this->db->from('xs_northern');
                    if ($this->db->count_all_results() == 0) {
                        $this->xs_northern_model->update($id, $data);
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

        $this->data['tpl_file'] = 'xs_northern/edit';
        $this->load->view('layout/default', $this->data);
    }

    function status($id = null, $status = null) {
        if ($row = $this->xs_northern_model->get($id)) {
            if ($this->xs_northern_model->update($id, array("status" => $status))) {
                //delete cache
                $this->simple_cache->delete_item('home_data');
                admin_redirect($this->data["module"]);
            }
        }
    }

    function delete($id = NULL) {
        if ($row = $this->xs_northern_model->get($id)) {
            if ($this->xs_northern_model->delete($id)) {
                //delete cache
                $this->simple_cache->delete_item('home_data');
                admin_redirect($this->data['module']);
            }
        }
    }

}
