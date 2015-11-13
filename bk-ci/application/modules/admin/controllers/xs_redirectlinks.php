<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class xs_redirectlinks extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model('xs_redirectlinks_model');
    }

    function index($page = 1) {
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $rows = $this->db->select("*")->from("xs_redirectlinks")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_redirectlinks")->get()->row()->cnt;
        
        $conf = array(
            'base_url' => admin_url($this->router->class) . '/index',
            'total_rows' => $total_rows,
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display();
        
        $this->data['rows'] = $rows;
        $this->data["count"] = $total_rows;
        $this->data['offset'] = $offset;
        $this->data['tpl_file'] = 'xs_redirectlinks/index';
        $this->load->view('layout/default', $this->data);
    }

    function active($id = null, $status = null) {
        if ($row = $this->xs_redirectlinks_model->get($id)) {
            if ($this->xs_redirectlinks_model->update($id, array("published" => $status))) {
                admin_redirect($this->data["_request_index"]);
            }
        }
    }

    function delete($id) {
        if ($this->xs_redirectlinks_model->delete($id)) {
            redirect(admin_url($this->data['_request_index']));
        }
    }

    function edit($id = NULL) {
        $row = $this->xs_redirectlinks_model->get($id);
        $submit = array();

        if ($row) {
            $submit['link'] = $row->link;
            $submit['rlink'] = $row->rlink;
            $submit['published'] = $row->published;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $link = trim($this->input->post('link'));
            $rlink = $this->input->post('rlink');
            $published = (int) $this->input->post('published');

            $submit['link'] = $link;
            $submit['rlink'] = $rlink;
            $submit['published'] = $published;

            $this->form_validation->set_rules('link', 'Link', 'required');
            $this->form_validation->set_rules('rlink', 'Link Redirect', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'link' => $link,
                    'md5_link' => md5($link),
                    'rlink' => $rlink,
                    'published' => $published
                );

                if ($row) {
                    $this->xs_redirectlinks_model->update($id, $data);
                } else {
                    $this->xs_redirectlinks_model->insert($data);
                }
                die('yes');
            } else {
                die(validation_errors());
            }
        }

        $this->data['submitted'] = $submit;
        $this->load->view($this->data["module"] . "/edit", $this->data);
    }

}
