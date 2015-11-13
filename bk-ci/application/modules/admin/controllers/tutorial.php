<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class Tutorial extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('tutorial_model', 'step_model'));
        $this->data['list'] = $this->tutorial_model->get_cat_trees_name();

        //print_r($this->data['list']);
    }

    function index($page = 1) {

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $rows = $this->tutorial_model->limit($limit, $offset)->get_all();
        foreach ($rows as $k => $row) {
            
        }

        $conf = array(
            'base_url' => admin_url($this->router->class) . '/index',
            'total_rows' => $this->tutorial_model->count_all(),
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->pagination->initialize($conf);
        //$this->data['pagnav'] = $this->pagination->display_query_string();
        $this->data['pagnav'] = $this->pagination->display();

        //print_r($this->news_category_model->show_cat(5));
        $this->data['rows'] = $rows;
        $this->data['tpl_file'] = 'tutorial/index';
        $this->load->view('layout/default', $this->data);
    }

    function update($id = null, $act = null) {
        $re = FALSE;
        $submit = array();
        $MODULE = $this->data['MODULE'];

        $row = $this->tutorial_model->get($id);

        if ($row) {
            if ($act == 'yes' || $act == 'no') {
                if ($this->tutorial_model->update($id, array('active' => $act))) {
                    //die('asas');
                    $re = TRUE;
                }
            }
            $submit['title'] = $row->title;
            $submit['name'] = $row->name;
            $submit['content'] = $row->content;
            $submit['active'] = $row->active;
            $submit['catid'] = $row->pid;
            $submit['order'] = $row->order;
            $submit['main'] = $row->main;
        }



        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $this->input->post('title');
            $name = $this->input->post('name');
            $title_link = cleanName($name);
            $catid = $this->input->post('catid');
            $content = $this->input->post('content');
            $source = $this->input->post('source');
            $active = ($this->input->post('active') == 'yes' ? 'yes' : 'no');
            $order = $this->input->post('order');
            $main = $this->input->post('main');

            $submit['title'] = $title;
            $submit['name'] = $name;
            $submit['content'] = $content;
            $submit['active'] = $active;
            $submit['catid'] = $catid;
            $submit['order'] = $order;
            $submit['main'] = $main;

            $this->form_validation->set_rules('title', lang($MODULE . '_TITLE'), 'required');
            $this->form_validation->set_rules('content', lang($MODULE . '_CONTENT'), 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'title' => $title,
                    'name' => $name,
                    'title_link' => $title_link,
                    'content' => $content,
                    'active' => $active,
                    'pid' => $catid,
                    'order' => $order,
                    'main' => $main
                );
                if ($row) {
                    if ($this->tutorial_model->update($id, $data)) {
                        $re = TRUE;
                    }
                }//Update
                else {
                    $data['created_date'] = date('Y-m-d H:i:s');
                    if ($this->tutorial_model->insert($data)) {
                        $re = TRUE;
                    }
                }//Insert
            }
        }

        if ($re) {
            admin_redirect($this->data['module']);
        }

        $this->data['submitted'] = $submit;
        $this->data['row'] = $row;

        $this->data['tpl_file'] = 'tutorial/update';
        $this->load->view('layout/default', $this->data);
    }

    function def($id = null, $act = 'yes') {
        $row = $this->tutorial_model->get($id);
        if ($row) {
            if ($act == 'yes') {
                $this->tutorial_model->update_all(array('default' => 0));
                $this->tutorial_model->update($id, array('default' => 1, 'active' => 'yes'));
                admin_redirect($this->data['module']);
            }
        }
    }

    function add_step($id = null) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $this->input->post('title');
            $content = $this->input->post('contents');

            $data = array('title' => $title, 'content' => $content, 'tut_id' => $id);

            if ($this->step_model->insert($data)) {
                die('yes');
            }
            die('' . $id);
        }
        $this->load->view('tutorial/add_step', $this->data);
    }

    function edit_step($id = null) {
        $row = $this->step_model->get($id);

        if ($row) {
            $this->data['row'] = $row;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $this->input->post('title');
            $content = $this->input->post('contents');

            $data = array('title' => $title, 'content' => $content);

            if ($this->step_model->update($id, $data)) {
                die("yes");
            }
        }
        $this->load->view('tutorial/edit_step', $this->data);
    }

}
