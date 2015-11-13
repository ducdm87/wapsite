<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'mobile' . EXT;

class dreams extends mobile {

    function __construct() {
        parent::__construct();
        $this->load->model(array("xs_dreams_model"));
    }

    function index() {
        $page = 1;
        $limit = (isset($_GET['limit']) ? $_GET['limit'] : 20);
        $offset = ($page - 1) * $limit;

        $this->db->start_cache();
        if (isset($_GET["title"]) && $_GET["title"] != "") {
            $this->db->like("title", $_GET["title"]);
        }
        $this->db->stop_cache();

        $rows = $this->db->select("id,title,catid,order,str_number,published")->from("xs_dreams")
                ->order_by("order", "DESC")
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $total_rows = $this->db->select("count(id) as cnt")->from("xs_dreams")->get()->row()->cnt;
        $this->db->flush_cache();

        $this->data['rows'] = $rows;
        $this->data['total_rows'] = $total_rows;
        $this->data['limit'] = $limit;
        $this->data['title'] = &$_GET["title"];

        $this->data["tmpl"] = "statistics/dreams";
        $this->load->view("layout/content", $this->data);
    }

}