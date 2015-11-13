<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class gioithieu extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('gioithieu_model'));
    }

    function edit($id = NULL) {
        $re = false;
        $row = $this->gioithieu_model->get($id);
        $submit = array();
        if ($row) {
            $submit['title'] = $row->title;
            $submit['content'] = $row->content;

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $title = $this->input->post('title');
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

                    if ($this->gioithieu_model->update($id, $data)) {
                        $re = TRUE;
                    }
                } else {
                    $this->message->add('error', validation_errors());
                }
            }
        }

        if ($re == true) {
            redirect(admin_url($this->data['module'] . '/edit/' . $id));
        }

        $this->data['row'] = $row;
        $this->data['submitted'] = $submit;

        $this->data['tpl_file'] = 'gioithieu/edit';
        $this->load->view('layout/default', $this->data);
    }

}
