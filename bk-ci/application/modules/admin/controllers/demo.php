<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class demo extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('demo_model'));
    }

    function index() {
        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $rows = $this->db->select("id,title,size,order,published")->from("demo")
                ->order_by("order", "ASC")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("demo")->get()->row()->cnt;
        $this->db->flush_cache();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ids = $this->input->post('ids');
            $orders = $this->input->post('orders');
//            var_dump($ids);
//            var_dump($orders);
            foreach ($ids as $k => $id) {
                $this->demo_model->update($id, array("order" => $orders[$k]));
            }

            admin_redirect($this->data['module']);
        }

        $conf = array(
            'base_url' => admin_url($this->router->class),
            'total_rows' => $total_rows,
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display_query_string();

        $this->data['rows'] = $rows;
        $this->data["count"] = $total_rows;
        $this->data['offset'] = $offset;
        $this->data['tpl_file'] = 'demo/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $submit = array();
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $title = trim($this->input->post('title'));
            $size = $this->input->post('size');
            $published = (int) $this->input->post('published');

            $submit['title'] = $title;
            $submit['size'] = $size;
            $submit['published'] = $published;

            $this->form_validation->set_rules('title', 'Tiêu đề menu', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'title' => $title,
                    'size' => $size,
                    'published' => $published
                );

                if ($this->demo_model->insert($data)) {
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
        $this->data['tpl_file'] = 'demo/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL, $action = NULL) {
        $re = false;
        $row = $this->demo_model->get($id);
        $submit = array();
        if ($row) {
            $submit['title'] = $row->title;
            $submit['size'] = $row->size;
            $submit['published'] = $row->published;

            if ($action != NULL && ($action == 1 || $action == 0)) {
                $this->demo_model->update($id, array('published' => $action));
                $re = true;
            } else {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $title = $this->input->post('title');
                    $size = $this->input->post('size');
                    $published = (int) $this->input->post('published');

                    $submit['title'] = $title;
                    $submit['size'] = $size;
                    $submit['published'] = $published;

                    $this->form_validation->set_rules('title', 'Tiêu đề menu', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        $data = array(
                            'title' => $title,
                            'size' => $size,
                            'published' => $published
                        );

                        if ($this->demo_model->update($id, $data)) {
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

        $this->data['tpl_file'] = 'demo/edit';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        if ($row = $this->demo_model->get($id)) {
            if ($this->demo_model->delete($id)) {
                admin_redirect($this->data['module']);
            }
        }
    }

}
