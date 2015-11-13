<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class Contact extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model('contact_model');
    }

    function index($page = 1) {
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $this->db->start_cache();
        $this->db->where("type", 0);
        $this->db->stop_cache();
        $rows = $this->db->select("*")->from("contacts")
                ->order_by("id", "DESC")
                ->limit($limit, $offer)
                ->get()
                ->result();
        $total_rows = $this->db->select("count(id) as cnt")->from("contacts")->get()->row()->cnt;
        $this->db->flush_cache();

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
        $this->data['tpl_file'] = 'contact/index';
        $this->load->view('layout/default', $this->data);
    }

    function view($id = NULL) {
        $row = $this->contact_model->get($id);
        $row->content = str_replace("\r\n", "<br/>", $row->content);
        $this->data["row"] = $row;
        $this->load->view($this->data["module"] . "/view", $this->data);
    }

    function delete($id) {
        if ($this->contact_model->delete($id)) {
            redirect(admin_url($this->data['_request_index']));
        }
    }

}
