<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class Email_template extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('email_template_model', 'step_model'));
    }

    function index($page = 1) {

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $rows = $this->email_template_model->limit($limit, $offset)->get_all();
//        foreach ($rows as $k => $row) {
//            
//        }

        $conf = array(
            'base_url' => admin_url($this->router->class) . '/index',
            'total_rows' => $this->email_template_model->count_all(),
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display();

        $this->data['rows'] = $rows;
        $this->data['tpl_file'] = 'email_template/index';
        $this->load->view('layout/default', $this->data);
    }

    function update($id = null, $act = null) {
        $re = FALSE;
        $submit = array();
        $MODULE = $this->data['MODULE'];

        $row = $this->email_template_model->get($id);

        if ($row) {
            if ($act == 'yes' || $act == 'no') {
                if ($this->email_template_model->update($id, array('active' => $act))) {
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
            $content = $this->input->post('content');

            $submit['title'] = $title;
            $submit['name'] = $name;
            $submit['content'] = $content;

            $this->form_validation->set_rules('title', lang($MODULE . '_TITLE'), 'required');
            $this->form_validation->set_rules('content', lang($MODULE . '_CONTENT'), 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'title' => $title,
                    'name' => $name,
                    'content' => $content,
                );
                if ($row) {
                    if ($this->email_template_model->update($id, $data)) {
                        $re = TRUE;
                    }
                }//Update
                else {
                    $data['time'] = time();
                    if ($this->email_template_model->insert($data)) {
                        $re = TRUE;
                    }
                }//Insert
            } else {
                $this->message->add('error', validation_errors());
            }
        }

        if ($re) {
            admin_redirect($this->data['module']);
        }

        $this->data['submitted'] = $submit;
        $this->data['row'] = $row;

        $this->data['tpl_file'] = 'email_template/update';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id) {
        if ($this->email_template_model->delete($id)) {
            redirect(admin_url($this->data['_request_index']));
        }
    }

    function def($id = null, $act = 'yes') {
        $row = $this->email_template_model->get($id);
        if ($row) {
            if ($act == 'yes') {
                $this->email_template_model->update_all(array('default' => 0));
                $this->email_template_model->update($id, array('default' => 1, 'active' => 'yes'));
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
        $this->load->view('email_template/add_step', $this->data);
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
        $this->load->view('email_template/edit_step', $this->data);
    }

}
