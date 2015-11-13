<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once 'admin' . EXT;

class xs_mo_receiver extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model(array("xs_mo_receiver_model"));
    }

    function index() {
        $page = (isset($_GET["p"]) && $_GET["p"] > 0 ? $_GET["p"] : 1);
        $limit = 20;
        $offer = ($page - 1) * $limit;

        $this->db->start_cache();
        if (isset($_GET["mobile"]) && $_GET["mobile"] != "") {
            $this->db->where("Destination", $_GET["mobile"]);
        }

        if (isset($_GET["start_date"]) && isset($_GET["end_date"]) && $_GET["u_date"] == 2) {
            $start_date = strtotime(str_replace('/', '-', $_GET['start_date']) . ' 00:00:00');
            $end_date = strtotime(str_replace('/', '-', $_GET['end_date']) . ' 23:59:59');
            $this->db->where("created >= '$start_date'");
            $this->db->where("created <= '$end_date'");
        }

        $this->db->stop_cache();
        $orders = $this->db->select("*")->from("xs_mo_receiver")
                ->order_by("id", "DESC")
                ->limit($limit, $offer)
                ->get()
                ->result();

//        echo $this->db->last_query();die;
        $count = $this->db->select("count(id) as cnt")->from("xs_mo_receiver")->get()->row()->cnt;
        $this->db->flush_cache();
//        var_dump($orders);

        $conf = array(
            'base_url' => admin_url($this->router->class) . '/index?x=1' . (isset($_GET["u_date"]) ? "&start_date=" . $_GET["start_date"] . "&end_date=" . $_GET["end_date"] . "&u_date=" . $_GET["u_date"] : "") . (isset($_GET["mobile"]) ? "&mobile=" . $_GET["mobile"] : ""),
            'total_rows' => $count,
            'per_page' => $limit,
            'cur_page' => $page,
        );
        $this->data["offer"] = $offer;
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display_query_string();
        $this->data["count"] = $count;
        $this->data["orders"] = $orders;
        $this->data["tpl_file"] = "xs_mo_receiver/index";
        $this->load->view("layout/default", $this->data);
    }

}