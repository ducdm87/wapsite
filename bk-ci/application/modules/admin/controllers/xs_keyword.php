<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_keyword extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('xs_keyword_model'));
    }

    function index() {
        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $rows = $this->db->select("id,name,order,published")->from("xs_keyword")
                ->order_by("order", "DESC")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_keyword")->get()->row()->cnt;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ids = $this->input->post('ids');
            $orders = $this->input->post('orders');
//            var_dump($ids);
//            var_dump($orders);
            foreach ($ids as $k => $id) {
                $this->xs_keyword_model->update($id, array("order" => $orders[$k]));
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
        $this->data['tpl_file'] = 'xs_keyword/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $submit = array();
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $name = trim($this->input->post('name'));
            $published = (int) $this->input->post('published');

            $submit['name'] = $name;
            $submit['published'] = $published;

            $this->form_validation->set_rules('name', 'Từ khoá', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $name,
                    'published' => $published
                );

                if ($this->xs_keyword_model->insert($data)) {
                    $re = TRUE;
                }
            } else {
                $this->message->add('error', validation_errors());
            }
        }

        if ($re) {
            //delete cache
            $this->simple_cache->delete_item('client_data');
            redirect(admin_url($this->data['module']));
        }

        $this->data['submitted'] = $submit;
        $this->data['tpl_file'] = 'xs_keyword/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL, $action = NULL) {
        $re = false;
        $row = $this->xs_keyword_model->get($id);
        $submit = array();
        if ($row) {
            $submit['name'] = $row->name;
            $submit['published'] = $row->published;

            if ($action != NULL && ($action == 1 || $action == 0)) {
                $this->xs_keyword_model->update($id, array('published' => $action));
                $re = true;
            } else {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = $this->input->post('name');
                    $published = (int) $this->input->post('published');

                    $submit['name'] = $name;
                    $submit['published'] = $published;

                    $this->form_validation->set_rules('name', 'Từ khoá', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        $data = array(
                            'name' => $name,
                            'published' => $published
                        );

                        if ($this->xs_keyword_model->update($id, $data)) {
                            $re = TRUE;
                        }
                    } else {
                        $this->message->add('error', validation_errors());
                    }
                }
            }
        }

        if ($re == true) {
            //delete cache
            $this->simple_cache->delete_item('client_data');
            redirect(admin_url($this->data['module'] . '/index'));
        }

        $this->data['row'] = $row;
        $this->data['submitted'] = $submit;

        $this->data['tpl_file'] = 'xs_keyword/edit';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        if ($row = $this->xs_keyword_model->get($id)) {
            if ($this->xs_keyword_model->delete($id)) {
                //delete cache
                $this->simple_cache->delete_item('client_data');
                admin_redirect($this->data['module']);
            }
        }
    }

}
