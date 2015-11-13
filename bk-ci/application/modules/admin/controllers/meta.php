<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class Meta extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model($this->data['module'] . '_model');
    }

    function index() {
        $rows = $this->meta_model->order_by("id", "DESC")->get_all();
        $this->data['rows'] = $rows;
        $this->data['tpl_file'] = $this->data['module'] . '/index';
        $this->load->view('layout/default', $this->data);
    }

    function update($id = NULL) {
        if ($id) {
            $this->data['pages'] = $this->meta_model->get_all();
        } else {
            //$this->data['pages']	=	$this->meta_model->get_no_title();
        }

        $row = $this->meta_model->get_by(array('id' => $id));
        $suc = false;
        $input = array();
        if ($row) {
            $input['title'] = $row->title;
            $input['title_content'] = $row->title_content;
            $input['name_alias'] = $row->name_alias;
            $input['name'] = $row->name;
            $input['description'] = $row->description;
            $input['keywords'] = $row->keywords;
        } else {
            $default = $this->meta_model->get_by(array('name_alias' => 'default'));
            if ($default) {
                $input['title'] = $default->title;
                $input['description'] = $default->description;
                $input['keywords'] = $default->keywords;
            }
        }



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $this->input->post('title');
            $title_content = $this->input->post('title_content');
            $name = $this->input->post('name');
            $name_ascii = $this->input->post('name_alias');
            $keyword = $this->input->post('keyword');
            $desc = $this->input->post('desc');
            $page = $this->input->post('page');
            $banner = $this->input->post('content');

            $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
            if (!$row) {
                $this->form_validation->set_rules('name_alias', 'Tên định danh', 'required|callback_check_name');
            }
            //$this->from_validation->set_rules('name_ascii','Tên định danh','required');

            $input['title'] = $title;
            $input['title_content'] = $title_content;
            $input['name'] = $name;
            $input['name_alias'] = $name_ascii;
            $input['page'] = $page;
            $input['description'] = $desc;
            $input['keywords'] = $keyword;
            $input['banner'] = $banner;

            $data = array(
                'title' => $title,
                'title_content' => $title_content,
                'name' => $name,
                'name_alias' => $name_ascii,
                'description' => $desc,
                'keywords' => $keyword,
                //'page_id'	=>	$page,
                //'banner'	=>	$banner,
                'created_date' => date('Y-m-d H:i:s')
            );

            if ($this->form_validation->run() == TRUE) {
                if ($row) {
                    if ($this->meta_model->update($id, $data)) {
                        $suc = true;
                    }
                } else {
                    if ($this->meta_model->insert($data)) {
                        $suc = true;
                    }
                }
            } else {
                $this->message->add('error', validation_errors());
            }
        }

        //print_r($input);

        if ($suc == true) {
            redirect(admin_url($this->data['module']));
        }

        $this->data['input'] = $input;
        $this->data['tpl_file'] = 'admin/' . $this->data['module'] . '/update';
        $this->load->view('admin/layout/default', $this->data);
    }

    function check_name($name_ascii = NULL) {
        $row = $this->meta_model->get_by(array('name_alias' => $name_ascii));
        if ($row) {
            $this->form_validation->set_message('check_name', '%s đã tồn tại trong hệ thống!');
            return false;
        } else {
            return true;
        }
    }

    function delete($id = NULL) {
        $row = $this->meta_model->get_by(array('id' => $id));
        if ($row) {
            if ($this->meta_model->delete($id)) {
                redirect(admin_url($this->data['module']));
            }
        }
    }

}
