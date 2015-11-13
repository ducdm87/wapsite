<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_dreams extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('xs_dreams_model', 'xs_dreams_categories_model'));
        $this->xs_dreams_categories_model->order_by('order', 'ASC');
        $this->xs_dreams_categories_model->order_by('id', 'DESC');
        $this->data['xs_dreams_categories'] = $this->xs_dreams_categories_model->get_many_by(array("published" => 1));
    }

    function index() {
        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $this->db->start_cache();
        if (isset($_GET["catid"]) && $_GET["catid"] != "") {
            $this->db->where("catid", $_GET["catid"]);
        }
        $this->db->stop_cache();

        $rows = $this->db->select("id,title,catid,order,str_number,published")->from("xs_dreams")
                ->order_by("order", "ASC")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_dreams")->get()->row()->cnt;
        $this->db->flush_cache();

        foreach ($rows as $k => $row) {
            $cat = $this->xs_dreams_categories_model->get($row->catid);
            if ($cat) {
                $rows[$k]->cat_name = $cat->title;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ids = $this->input->post('ids');
            $orders = $this->input->post('orders');
//            var_dump($ids);
//            var_dump($orders);
            foreach ($ids as $k => $id) {
                $this->xs_dreams_model->update($id, array("order" => $orders[$k]));
            }

            admin_redirect($this->data['module']);
        }

        $conf = array(
            'base_url' => admin_url($this->router->class)
            . '/index?x=1'
            . (isset($_GET["catid"]) ? "&catid=" . $_GET["catid"] : ""),
            'total_rows' => $total_rows,
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display_query_string();

        $this->data['rows'] = $rows;
        $this->data["count"] = $total_rows;
        $this->data['offset'] = $offset;
        $this->data['tpl_file'] = 'xs_dreams/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $submit = array();
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $title = trim($this->input->post('title'));
            $catid = $this->input->post('catid');
            $str_number = $this->input->post('str_number');
            $published = (int) $this->input->post('published');

            $submit['title'] = $title;
            $submit['catid'] = $catid;
            $submit['str_number'] = $str_number;
            $submit['published'] = $published;

            $this->form_validation->set_rules('title', 'Nội dung giấc mơ', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'title' => $title,
                    'catid' => $catid,
                    'str_number' => $str_number,
                    'published' => $published
                );

                if ($this->xs_dreams_model->insert($data)) {
                    $re = TRUE;
                }
            } else {
                $this->message->add('error', validation_errors());
            }
        }

        if ($re) {
            redirect(admin_url($this->data['module']));
        }

        $this->data['submitted'] = $submit;
        $this->data['tpl_file'] = 'xs_dreams/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL, $action = NULL) {
        $re = false;
        $row = $this->xs_dreams_model->get($id);
        $submit = array();
        if ($row) {
            $submit['title'] = $row->title;
            $submit['str_number'] = $row->str_number;
            $submit['catid'] = $row->catid;
            $submit['published'] = $row->published;

            if ($action != NULL && ($action == 1 || $action == 0)) {
                $this->xs_dreams_model->update($id, array('published' => $action));
                $re = true;
            } else {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $title = $this->input->post('title');
                    $catid = $this->input->post('catid');
                    $str_number = $this->input->post('str_number');
                    $published = (int) $this->input->post('published');

                    $submit['title'] = $title;
                    $submit['catid'] = $catid;
                    $submit['str_number'] = $str_number;
                    $submit['published'] = $published;

                    $this->form_validation->set_rules('title', 'Nội dung giấc mơ', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        $data = array(
                            'title' => $title,
                            'catid' => $catid,
                            'str_number' => $str_number,
                            'published' => $published
                        );

                        if ($this->xs_dreams_model->update($id, $data)) {
                            $re = TRUE;
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

        $this->data['tpl_file'] = 'xs_dreams/edit';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        if ($row = $this->xs_dreams_model->get($id)) {
            if ($this->xs_dreams_model->delete($id)) {
                admin_redirect($this->data['module']);
            }
        }
    }

}
