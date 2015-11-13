<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class doitac extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('doitac_model'));
        $this->load->helper('upload');
    }

    function index() {
        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $rows = $this->db->select("id,title,link,order,published")->from("doitac")
                ->order_by("order", "ASC")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("doitac")->get()->row()->cnt;
        $this->db->flush_cache();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ids = $this->input->post('ids');
            $orders = $this->input->post('orders');
//            var_dump($ids);
//            var_dump($orders);
            foreach ($ids as $k => $id) {
                $this->doitac_model->update($id, array("order" => $orders[$k]));
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
        $this->data['tpl_file'] = 'doitac/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $submit = array();
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $title = trim($this->input->post('title'));
            $link = $this->input->post('link');
            $published = (int) $this->input->post('published');

            $submit['title'] = $title;
            $submit['link'] = $link;
            $submit['published'] = $published;

            $this->form_validation->set_rules('title', 'Tên đối tác', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'title' => $title,
                    'link' => $link,
                    'published' => $published
                );

                if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != '') {
                    $dir = get_dir_name('doitac');
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

                if ($this->doitac_model->insert($data)) {
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
        $this->data['tpl_file'] = 'doitac/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL, $action = NULL) {
        $re = false;
        $row = $this->doitac_model->get($id);
        $submit = array();
        if ($row) {
            $submit['title'] = $row->title;
            $submit['link'] = $row->link;
            $submit['published'] = $row->published;
            $submit['image'] = $row->image;

            if ($action != NULL && ($action == 1 || $action == 0)) {
                $this->doitac_model->update($id, array('published' => $action));
                $re = true;
            } else {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $title = $this->input->post('title');
                    $link = $this->input->post('link');
                    $published = (int) $this->input->post('published');

                    $submit['title'] = $title;
                    $submit['link'] = $link;
                    $submit['published'] = $published;

                    $this->form_validation->set_rules('title', 'Tên đối tác', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        $data = array(
                            'title' => $title,
                            'link' => $link,
                            'published' => $published
                        );

                        if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != '') {
                            $dir = get_dir_name('doitac');
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

                        if ($this->doitac_model->update($id, $data)) {
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

        $this->data['tpl_file'] = 'doitac/edit';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        if ($row = $this->doitac_model->get($id)) {
            if ($this->doitac_model->delete($id)) {
                admin_redirect($this->data['module']);
            }
        }
    }

}
