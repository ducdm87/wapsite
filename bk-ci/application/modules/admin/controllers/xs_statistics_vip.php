<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_statistics_vip extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('xs_statistics_vip_model', 'xs_location_model'));
        $this->xs_location_model->order_by('ordering', 'ASC');
        $this->xs_location_model->order_by('id', 'DESC');
        $this->data['xs_location'] = $this->xs_location_model->get_many_by(array("status" => 1));
        $this->load->helper(array('upload'));
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

        $rows = $this->db->select("*")->from("xs_statistics_vip")
//                ->order_by("order", "ASC")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_statistics_vip")->get()->row()->cnt;
        $this->db->flush_cache();

        foreach ($rows as $k => $row) {
            $cat = $this->xs_location_model->get($row->lid);
            if ($cat)
                $rows[$k]->lname = $cat->name;
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
        $this->data['tpl_file'] = 'xs_statistics_vip/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $submit = array();
        $MODULE = $this->data['MODULE'];
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $lid = $this->input->post('lid');
            $date = $this->input->post('date');
            $status = ($this->input->post('status') == 1 ? 1 : 0);
            $dac_biet = trim($this->input->post('dac_biet'));
            $cau_loto = trim($this->input->post('cau_loto'));
            $lo_xien = trim($this->input->post('lo_xien'));
            $ve_nhieu = trim($this->input->post('ve_nhieu'));
            $lau_ve = trim($this->input->post('lau_ve'));

            $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

            $submit['lid'] = $lid;
            $submit['date'] = $date;
            $submit['status'] = $status;
            $submit['dac_biet'] = $dac_biet;
            $submit['cau_loto'] = $cau_loto;
            $submit['lo_xien'] = $lo_xien;
            $submit['ve_nhieu'] = $ve_nhieu;
            $submit['lau_ve'] = $lau_ve;

            $this->form_validation->set_rules('lid', 'Tỉnh/TP', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'lid' => $lid,
                    'date' => $date,
                    'status' => $status,
                    'created' => time(),
                    'dac_biet' => $dac_biet,
                    'cau_loto' => $cau_loto,
                    'lo_xien' => $lo_xien,
                    've_nhieu' => $ve_nhieu,
                    'lau_ve' => $lau_ve,
                );
                if (!$this->xs_statistics_vip_model->get_by(array('lid' => $lid, 'date' => $date))) {
                    $this->xs_statistics_vip_model->insert($data);
                    $re = true;
                } else {
                    $this->message->add('error', 'Tỉnh này đã có dữ liệu ngày ' . $date);
                }
            } else {
                $this->message->add('error', validation_errors());
            }
        }

        if ($re) {
            redirect(admin_url($this->data['module']));
        }

        $this->data['submitted'] = $submit;
        $this->data['tpl_file'] = 'xs_statistics_vip/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL, $action = 999) {
        $re = false;
        $row = $this->xs_statistics_vip_model->get($id);
        $MODULE = $this->data['MODULE'];
        $submit = array();
        if ($row) {
            $submit['lid'] = $row->lid;
            $submit['date'] = $row->date;
            $submit['status'] = $row->status;
            $submit['image'] = $row->image;
            $submit['dac_biet'] = $row->dac_biet;
            $submit['cau_loto'] = $row->cau_loto;
            $submit['lo_xien'] = $row->lo_xien;
            $submit['ve_nhieu'] = $row->ve_nhieu;
            $submit['lau_ve'] = $row->lau_ve;

            if ($action == 1 || $action == 0) {
                $this->xs_statistics_vip_model->update($id, array('status' => $action));
                $re = true;
            } else {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $lid = $this->input->post('lid');
                    $date = $this->input->post('date');
                    $status = ($this->input->post('status') == 1 ? 1 : 0);
                    $dac_biet = trim($this->input->post('dac_biet'));
                    $cau_loto = trim($this->input->post('cau_loto'));
                    $lo_xien = trim($this->input->post('lo_xien'));
                    $ve_nhieu = trim($this->input->post('ve_nhieu'));
                    $lau_ve = trim($this->input->post('lau_ve'));

                    $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

                    $submit['lid'] = $lid;
                    $submit['date'] = $date;
                    $submit['status'] = $status;
                    $submit['dac_biet'] = $dac_biet;
                    $submit['cau_loto'] = $cau_loto;
                    $submit['lo_xien'] = $lo_xien;
                    $submit['ve_nhieu'] = $ve_nhieu;
                    $submit['lau_ve'] = $lau_ve;

                    $this->form_validation->set_rules('lid', 'Tỉnh/TP', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        $data = array(
                            'lid' => $lid,
                            'date' => $date,
                            'status' => $status,
                            'dac_biet' => $dac_biet,
                            'cau_loto' => $cau_loto,
                            'lo_xien' => $lo_xien,
                            've_nhieu' => $ve_nhieu,
                            'lau_ve' => $lau_ve,
                        );

                        if (!$this->xs_statistics_vip_model->get_by(array('id <>' => $id, 'lid' => $lid, 'date' => $date))) {
                            $this->xs_statistics_vip_model->update($id, $data);
                            $re = true;
                        } else {
                            $this->message->add('error', 'Tỉnh này đã có dữ liệu ngày ' . $date);
                        }
                    } else {
                        $this->message->add('error', validation_errors());
                    }
                }
            }
        }

        if ($re == true) {
            redirect(admin_url($this->data['module'] . '/index'));
        }

        $this->data['row'] = $row;
        $this->data['submitted'] = $submit;

        $this->data['tpl_file'] = 'xs_statistics_vip/edit';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        if ($row = $this->xs_statistics_vip_model->get($id)) {
            if ($this->xs_statistics_vip_model->delete($id)) {
                admin_redirect($this->data['module']);
            }
        }
    }

}
