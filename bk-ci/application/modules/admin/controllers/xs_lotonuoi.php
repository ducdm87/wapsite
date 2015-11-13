<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_lotonuoi extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('xs_lotonuoi_model'));
    }

    function index() {
        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $this->db->start_cache();
        if ($title = $this->input->get('title')) {
            $this->db->like("title", $title);
        }
        $this->db->stop_cache();

        $rows = $this->db->select("*")->from("xs_lotonuoi")
//                ->order_by("order", "ASC")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_lotonuoi")->get()->row()->cnt;
        $this->db->flush_cache();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ids = $this->input->post('ids');
            $orders = $this->input->post('orders');
            //var_dump($ids);
            //var_dump($orders);
            foreach ($ids as $k => $id) {
                $this->xs_lotonuoi_model->update($id, array("order" => $orders[$k]));
            }

            admin_redirect($this->data['module']);
        }

        $conf = array(
            'base_url' => admin_url($this->router->class)
            . '/index?x=1'
            . (isset($_GET["title"]) ? "&title=" . $_GET["title"] : ""),
            'total_rows' => $total_rows,
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display_query_string();

        $this->data['rows'] = $rows;
        $this->data["count"] = $total_rows;
        $this->data['offset'] = $offset;
        $this->data['tpl_file'] = 'xs_lotonuoi/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $submit = array();
        $MODULE = $this->data['MODULE'];
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $title = trim($this->input->post('title'));
            $title_link = cleanName($title);
            $content = $this->input->post('content');
            $active = ($this->input->post('active') == 'yes' ? 'yes' : 'no');
            $meta_keywords = trim($this->input->post('meta_keywords'));
            $meta_description = trim($this->input->post('meta_description'));
            $tags = trim($this->input->post('tags'));

            $submit['title'] = $title;
            $submit['content'] = $content;
            $submit['active'] = $active;
            $submit['meta_keywords'] = $meta_keywords;
            $submit['meta_description'] = $meta_description;
            $submit['tags'] = $tags;

            $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('content', 'Nội dung', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'title' => $title,
                    'title_link' => $title_link,
                    'content' => $content,
                    'active' => $active,
                    'created_date' => date('Y-m-d H:i:s'),
                    'meta_keywords' => $meta_keywords,
                    'meta_description' => $meta_description,
                    'tags' => $tags,
                );

                if ($this->xs_lotonuoi_model->get_by(array('title_link' => $title_link))) {
                    $data['title_link'] = $title_link . '-' . time();
                }
                if ($this->xs_lotonuoi_model->insert($data)) {
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
        $this->data['tpl_file'] = 'xs_lotonuoi/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL, $action = NULL) {
        $re = false;
        $row = $this->xs_lotonuoi_model->get($id);
        $MODULE = $this->data['MODULE'];
        $submit = array();
        if ($row) {
            $submit['title'] = $row->title;
            $submit['title_link'] = $row->title_link;
            $submit['content'] = $row->content;
            $submit['active'] = $row->active;
            $submit['meta_keywords'] = $row->meta_keywords;
            $submit['meta_description'] = $row->meta_description;
            $submit['tags'] = $row->tags;

            if ($action == 'yes' || $action == 'no') {
                $this->xs_lotonuoi_model->update($id, array('active' => $action));
                $re = true;
            } else {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $title = $this->input->post('title');
                    $title_link = cleanName($title);
                    $content = $this->input->post('content');
                    $active = ($this->input->post('active') == 'yes' ? 'yes' : 'no');
                    $meta_keywords = trim($this->input->post('meta_keywords'));
                    $meta_description = trim($this->input->post('meta_description'));
                    $tags = trim($this->input->post('tags'));

                    $submit['title'] = $title;
                    $submit['title_link'] = $title_link;
                    $submit['content'] = $content;
                    $submit['active'] = $active;
                    $submit['meta_keywords'] = $meta_keywords;
                    $submit['meta_description'] = $meta_description;
                    $submit['tags'] = $tags;

                    $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
                    $this->form_validation->set_rules('content', 'Nội dung', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        $data = array(
                            'title' => $title,
                            'title_link' => $title_link,
                            'content' => $content,
                            'active' => $active,
                            'meta_keywords' => $meta_keywords,
                            'meta_description' => $meta_description,
                            'tags' => $tags,
                        );

                        if ($this->xs_lotonuoi_model->get_by(array('id <>' => $id, 'title_link' => $title_link))) {
                            $data['title_link'] = $title_link . '-' . time();
                        }
                        if ($this->xs_lotonuoi_model->update($id, $data)) {
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

        $this->data['tpl_file'] = 'xs_lotonuoi/edit';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        if ($row = $this->xs_lotonuoi_model->get($id)) {
            if ($this->xs_lotonuoi_model->delete($id)) {
                admin_redirect($this->data['module']);
            }
        }
    }

}
