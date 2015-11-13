<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_statistics_site extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('xs_statistics_site_model', 'xs_location_model'));
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

        $rows = $this->db->select("*")->from("xs_statistics_site")
//                ->order_by("order", "ASC")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_statistics_site")->get()->row()->cnt;
        $this->db->flush_cache();

        foreach ($rows as $k => $row) {
            $cat = $this->xs_location_model->get($row->lid);
            if ($cat) {
                $rows[$k]->lname = $cat->name;
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
        $this->data['tpl_file'] = 'xs_statistics_site/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $submit = array();
        $MODULE = $this->data['MODULE'];
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $lid = $this->input->post('lid');
            $date = $this->input->post('date');
            $content = $this->input->post('content');
            $active = ($this->input->post('active') == 'yes' ? 'yes' : 'no');
            $meta_keywords = trim($this->input->post('meta_keywords'));
            $meta_description = trim($this->input->post('meta_description'));
            $tags = trim($this->input->post('tags'));

            $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

            $submit['lid'] = $lid;
            $submit['date'] = $date;
            $submit['content'] = $content;
            $submit['active'] = $active;
            $submit['meta_keywords'] = $meta_keywords;
            $submit['meta_description'] = $meta_description;
            $submit['tags'] = $tags;

            $this->form_validation->set_rules('lid', 'Tỉnh/TP', 'required');
            $this->form_validation->set_rules('content', 'Nội dung', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'lid' => $lid,
                    'date' => $date,
                    'content' => $content,
                    'active' => $active,
                    'created_date' => date('Y-m-d H:i:s'),
                    'meta_keywords' => $meta_keywords,
                    'meta_description' => $meta_description,
                    'tags' => $tags,
                );

                if (!$this->xs_statistics_site_model->get_by(array('lid' => $lid, 'date' => $date))) {
                    $this->xs_statistics_site_model->insert($data);
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
        $this->data['tpl_file'] = 'xs_statistics_site/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL, $action = NULL) {
        $re = false;
        $row = $this->xs_statistics_site_model->get($id);
        $MODULE = $this->data['MODULE'];
        $submit = array();
        if ($row) {
            $submit['lid'] = $row->lid;
            $submit['date'] = $row->date;
            $submit['content'] = $row->content;
            $submit['active'] = $row->active;
            $submit['meta_keywords'] = $row->meta_keywords;
            $submit['meta_description'] = $row->meta_description;
            $submit['tags'] = $row->tags;

            if ($action == 'yes' || $action == 'no') {
                $this->xs_statistics_site_model->update($id, array('active' => $action));
                $re = true;
            } else {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $lid = $this->input->post('lid');
                    $date = $this->input->post('date');
                    $content = $this->input->post('content');
                    $active = ($this->input->post('active') == 'yes' ? 'yes' : 'no');
                    $meta_keywords = trim($this->input->post('meta_keywords'));
                    $meta_description = trim($this->input->post('meta_description'));
                    $tags = trim($this->input->post('tags'));

                    $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

                    $submit['lid'] = $lid;
                    $submit['date'] = $date;
                    $submit['content'] = $content;
                    $submit['active'] = $active;
                    $submit['meta_keywords'] = $meta_keywords;
                    $submit['meta_description'] = $meta_description;
                    $submit['tags'] = $tags;

                    $this->form_validation->set_rules('lid', 'Tỉnh/TP', 'required');
                    $this->form_validation->set_rules('content', 'Nội dung', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        $data = array(
                            'lid' => $lid,
                            'date' => $date,
                            'content' => $content,
                            'active' => $active,
                            'meta_keywords' => $meta_keywords,
                            'meta_description' => $meta_description,
                            'tags' => $tags,
                        );

                        if (!$this->xs_statistics_site_model->get_by(array('id <>' => $id, 'lid' => $lid, 'date' => $date))) {
                            $this->xs_statistics_site_model->update($id, $data);
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

        $this->data['tpl_file'] = 'xs_statistics_site/edit';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        if ($row = $this->xs_statistics_site_model->get($id)) {
            if ($this->xs_statistics_site_model->delete($id)) {
                admin_redirect($this->data['module']);
            }
        }
    }

}
