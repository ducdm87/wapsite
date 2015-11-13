<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_veso extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array('xs_veso_model'));
        $this->load->helper(array('upload'));
    }

    function index() {
        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $this->db->start_cache();
        if (isset($_GET["catid"]) && $_GET["catid"] != "") {
            $this->db->where("catid", $_GET["catid"]);
        }
        $this->db->stop_cache();

        $rows = $this->db->select("*")->from("xs_veso")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_veso")->get()->row()->cnt;
        $this->db->flush_cache();

        $conf = array(
            'base_url' => admin_url($this->router->class)
            . '/index?x=1'
            . (isset($_GET["catid"]) ? "&catid=" . $_GET["catid"] : ""),
            'total_rows' => $total_rows,
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display_query_string();

        $this->data['rows'] = $rows;
        $this->data["count"] = $total_rows;
        $this->data['offset'] = $offset;
        $this->data['tpl_file'] = 'xs_veso/index';
        $this->load->view('layout/default', $this->data);
    }

    function add() {
        $re = FALSE;
        $submit = array();
        $submit['author'] = $_SESSION['_admin']['username'];
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $title = trim($this->input->post('title'));
            $catid = $this->input->post('catid');
            $content = $this->input->post('content');
            $active = ($this->input->post('active') == 'yes' ? 'yes' : 'no');

            $submit['title'] = $title;
            $submit['content'] = $content;
            $submit['active'] = $active;
            $submit['catid'] = $catid;

            $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('content', 'Nội dung', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'title' => $title,
                    'content' => $content,
                    'active' => $active,
                    'created_date' => date('Y-m-d H:i:s'),
                    'catid' => $catid,
                );

                if ($this->xs_veso_model->insert($data)) {
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
        $this->data['tpl_file'] = 'xs_veso/add';
        $this->load->view('layout/default', $this->data);
    }

    function edit($id = NULL, $action = NULL) {
        $re = false;
        $row = $this->xs_veso_model->get($id);
        $submit = array();
        if ($row) {
            $submit['title'] = $row->title;
            $submit['content'] = $row->content;
            $submit['active'] = $row->active;
            $submit['catid'] = $row->catid;

            if ($action == 'yes' || $action == 'no') {
                $this->xs_veso_model->update($id, array('active' => $action));
                $re = true;
            } else {

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $title = $this->input->post('title');
                    $catid = $this->input->post('catid');
                    $content = $this->input->post('content');
                    $active = ($this->input->post('active') == 'yes' ? 'yes' : 'no');

                    $submit['title'] = $title;
                    $submit['title_link'] = $title_link;
                    $submit['content'] = $content;
                    $submit['active'] = $active;
                    $submit['catid'] = $catid;

                    $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
                    $this->form_validation->set_rules('content', 'Nội dung', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        $data = array(
                            'title' => $title,
                            'content' => $content,
                            'active' => $active,
                            'catid' => $catid,
                        );

                        if ($this->xs_veso_model->update($id, $data)) {
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

        $this->data['tpl_file'] = 'xs_veso/edit';
        $this->load->view('layout/default', $this->data);
    }

    function delete($id = NULL) {
        if ($row = $this->xs_veso_model->get($id)) {
            if ($this->xs_veso_model->delete($id)) {
                admin_redirect($this->data['module']);
            }
        }
    }

}