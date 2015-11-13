<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_statistics_links extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('xs_statistics_links_model'));
    }

    function index() {
        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $rows = $this->db->select("id,title,alias,order,published")->from("xs_statistics_links")
                ->order_by("order", "DESC")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_statistics_links")->get()->row()->cnt;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ids = $this->input->post('ids');
            $orders = $this->input->post('orders');
//            var_dump($ids);
//            var_dump($orders);
            foreach ($ids as $k => $id) {
                $this->xs_statistics_links_model->update($id, array("order" => $orders[$k]));
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
        $this->data['tpl_file'] = 'xs_statistics_links/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $submit = array();
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $title = trim($this->input->post('title'));
            $alias = trim($this->input->post('alias'));
            $content = trim($this->input->post('content'));
            $meta_keywords = trim($this->input->post('meta_keywords'));
            $meta_description = trim($this->input->post('meta_description'));
            $published = (int) $this->input->post('published');

            $submit['title'] = $title;
            $submit['alias'] = $alias;
            $submit['content'] = $content;
            $submit['meta_keywords'] = $meta_keywords;
            $submit['meta_description'] = $meta_description;
            $submit['published'] = $published;

            $this->form_validation->set_rules('alias', 'Alias', 'required');

            if ($this->form_validation->run() == TRUE) {
                if ($alias == '')
                    $alias = cleanName($title);
                $data = array(
                    'title' => $title,
                    'alias' => $alias,
                    'content' => $content,
                    'meta_keywords' => $meta_keywords,
                    'meta_description' => $meta_description,
                    'published' => $published
                );

                $this->db->where('alias ', $alias);
                $this->db->from('xs_statistics_links');
                if ($this->db->count_all_results() == 0) {
                    $this->xs_statistics_links_model->insert($data);
                    $re = TRUE;
                } else {
                    $this->message->add('error', '<p>Trùng Alias</p>');
                }
            } else {
                $this->message->add('error', validation_errors());
            }
        }

        if ($re) {
            redirect(admin_url($this->data['module']));
        }

        $this->data['submitted'] = $submit;
        $this->data['tpl_file'] = 'xs_statistics_links/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL, $action = NULL) {
        $re = false;
        $row = $this->xs_statistics_links_model->get($id);
        $submit = array();
        if ($row) {
            $submit['title'] = $row->title;
            $submit['alias'] = $row->alias;
            $submit['content'] = $row->content;
            $submit['meta_keywords'] = $row->meta_keywords;
            $submit['meta_description'] = $row->meta_description;
            $submit['published'] = $row->published;

            if ($action != NULL && ($action == 1 || $action == 0)) {
                $this->xs_statistics_links_model->update($id, array('published' => $action));
                $re = true;
            } else {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $title = trim($this->input->post('title'));
                    $alias = trim($this->input->post('alias'));
                    $content = trim($this->input->post('content'));
                    $meta_keywords = trim($this->input->post('meta_keywords'));
                    $meta_description = trim($this->input->post('meta_description'));
                    $published = (int) $this->input->post('published');

                    $submit['title'] = $title;
                    $submit['alias'] = $alias;
                    $submit['content'] = $content;
                    $submit['meta_keywords'] = $meta_keywords;
                    $submit['meta_description'] = $meta_description;
                    $submit['published'] = $published;

                    $this->form_validation->set_rules('alias', 'Alias', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        if ($alias == '')
                            $alias = cleanName($title);
                        $data = array(
                            'title' => $title,
                            'alias' => $alias,
                            'content' => $content,
                            'meta_keywords' => $meta_keywords,
                            'meta_description' => $meta_description,
                            'published' => $published
                        );

                        $this->db->where('alias ', $alias);
                        $this->db->where('id <>', $id);
                        $this->db->from('xs_statistics_links');
                        if ($this->db->count_all_results() == 0) {
                            $this->xs_statistics_links_model->update($id, $data);
                            $re = TRUE;
                        } else {
                            $this->message->add('error', '<p>Trùng Alias</p>');
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

        $this->data['tpl_file'] = 'xs_statistics_links/edit';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        if ($row = $this->xs_statistics_links_model->get($id)) {
            if ($this->xs_statistics_links_model->delete($id)) {
                admin_redirect($this->data['module']);
            }
        }
    }

}
