<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class Introduction extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model('introduction_model');
    }

    function index($page = 1) {

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $rows = $this->introduction_model->limit($limit, $offset)->get_all();
//        foreach ($rows as $k => $row) {
//            
//        }

        $conf = array(
            'base_url' => admin_url($this->router->class) . '/index',
            'total_rows' => $this->introduction_model->count_all(),
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display();

        $this->data['rows'] = $rows;
        $this->data['tpl_file'] = 'introduction/index';
        $this->load->view('layout/default', $this->data);
    }

    function update($id = null, $act = null) {
        $re = FALSE;
        $submit = array();
        $MODULE = $this->data['MODULE'];

        $row = $this->introduction_model->get($id);

        if ($row) {
            if ($act == 'yes' || $act == 'no') {
                if ($this->introduction_model->update($id, array('active' => $act))) {
                    $re = TRUE;
                }
            }
            $submit['title'] = $row->title;
            $submit['content'] = $row->content;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = trim($this->input->post('title'));
            $content = $this->input->post('content');

            $submit['title'] = $title;
            $submit['content'] = $content;

            $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('content', 'Nội dung', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'title' => $title,
                    'content' => $content,
                );
                if ($row) {
                    if ($this->introduction_model->update($id, $data)) {
                        $re = TRUE;
                    }
                }//Update
                else {
                    $data['time'] = time();
                    if ($this->introduction_model->insert($data)) {
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

        $this->data['tpl_file'] = 'introduction/update';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id) {
        if ($this->introduction_model->delete($id)) {
            redirect(admin_url($this->data['_request_index']));
        }
    }

}
