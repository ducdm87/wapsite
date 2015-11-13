<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class Banner extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model('banner_model');
        $this->load->helper('upload');
        $this->data['positions'] = $this->config->item('positions');
        $this->data['pages'] = $this->config->item('pages');
    }

    function index() {
        $rows = $this->banner_model->order_by("order", "ASC")->get_all();
        $this->data['rows'] = $rows;
        $this->data['tpl_file'] = 'banner/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $MODULE = $this->data['MODULE'];
        $submit = array();

        $dir = get_dir_name('banners');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($this->input->post('name'));
            $page = $this->input->post('page');
            $url = trim($this->input->post('url'));
            $order = $this->input->post('order');
            $position = $this->input->post('position');
            $active = ($this->input->post('active') == 'yes' ? 'yes' : 'no');

            $submit['name'] = $name;
            $submit['page'] = $page;
            $submit['url'] = $url;
            $submit['order'] = $order;
            $submit['position'] = $position;
            $submit['active'] = $active;


            $this->form_validation->set_rules('name', lang($MODULE . '_NAME'), 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $name,
                    'page' => $page,
                    'url' => $url,
                    'order' => $order,
                    'position' => $position,
                    'active' => $active
                );

                if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != '') {
                    // Upload images
                    if (!is_dir($dir)) {
                        create_dir($dir);
                    }

                    $ext = get_ext($_FILES["image"]["name"]);
                    if (!in_array($ext, array('png', 'gif', 'jpg', 'jpeg'))) {
                        continue;
                    }

                    //print_r($_FILES);die('====');

                    if ($_FILES['image']['error'] === 0) {
                        $new_path = $dir . $_FILES["image"]["name"];
                        move_uploaded_file($_FILES["image"]['tmp_name'], dirname($_SERVER['SCRIPT_FILENAME']) . '/' . $new_path);

                        $pathinfo = pathinfo($new_path);
                        $new_name = $pathinfo['basename'];
                        $temp = explode('.', $pathinfo['basename']);
                        $new_name = cleanName($temp[0]) . date('-his-dmy') . '.' . $pathinfo['extension'];
                        rename($new_path, $pathinfo['dirname'] . '/' . $new_name);

                        $data['image'] = $pathinfo['dirname'] . '/' . $new_name;
                    }
                }//End select image

                if ($this->banner_model->insert($data)) {
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
        $this->data['tpl_file'] = 'banner/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL, $action = NULL) {
        $row = $this->banner_model->get($id);
        $re = FALSE;
        $MODULE = $this->data['MODULE'];
        $submit = array();

        if ($row) {
            if ($action == 'yes' || $action == 'no') {
                if ($this->banner_model->update($id, array('active' => $action))) {
                    $re = TRUE;
                }
            } else {
                $submit['name'] = $row->name;
                $submit['page'] = $row->page;
                $submit['order'] = $row->order;
                $submit['url'] = $row->url;
                $submit['position'] = $row->position;
                $submit['active'] = $row->active;
                $submit['image'] = $row->image;

                $dir = get_dir_name('banners');
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = trim($this->input->post('name'));
                    $page = $this->input->post('page');
                    $url = trim($this->input->post('url'));
                    $order = $this->input->post('order');
                    $position = $this->input->post('position');
                    $active = ($this->input->post('active') == 'yes' ? 'yes' : 'no');

                    $submit['name'] = $name;
                    $submit['page'] = $page;
                    $submit['url'] = $url;
                    $submit['order'] = $order;
                    $submit['position'] = $position;
                    $submit['active'] = $active;

                    $this->form_validation->set_rules('name', lang($MODULE . '_NAME'), 'required');

                    if ($this->form_validation->run() == TRUE) {
                        $data = array(
                            'name' => $name,
                            'url' => $url,
                            'order' => $order,
                            'position' => $position,
                            'active' => $active,
                            'page' => $page
                        );

                        if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != '') {
                            // Upload images
                            if (!is_dir($dir)) {
                                create_dir($dir);
                            }

                            $ext = get_ext($_FILES["image"]["name"]);
                            if (!in_array($ext, array('png', 'gif', 'jpg', 'jpeg'))) {
                                continue;
                            }

                            //print_r($_FILES);die('====');

                            if ($_FILES['image']['error'] === 0) {
                                $new_path = $dir . $_FILES["image"]["name"];
                                move_uploaded_file($_FILES["image"]['tmp_name'], dirname($_SERVER['SCRIPT_FILENAME']) . '/' . $new_path);

                                $pathinfo = pathinfo($new_path);
                                $new_name = $pathinfo['basename'];
                                $temp = explode('.', $pathinfo['basename']);
                                $new_name = cleanName($temp[0]) . date('-his-dmy') . '.' . $pathinfo['extension'];
                                rename($new_path, $pathinfo['dirname'] . '/' . $new_name);

                                $data['image'] = $pathinfo['dirname'] . '/' . $new_name;
                            }
                        }//End select image

                        if ($this->banner_model->update($id, $data)) {
                            $re = TRUE;
                        }
                    } else {
                        $this->message->add('error', validation_errors());
                    }
                }
            }
        } else {
            show_404();
        }



        if ($re) {
            //delete cache
            $this->simple_cache->delete_item('client_data');
            redirect(admin_url($this->data['module']));
        }

        $this->data['submitted'] = $submit;
        $this->data['tpl_file'] = 'banner/edit';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        if ($row = $this->banner_model->get($id)) {
            if ($this->banner_model->delete($id)) {
                //delete cache
                $this->simple_cache->delete_item('client_data');
                admin_redirect($this->data['module']);
            }
        }
    }

}
