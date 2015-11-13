<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once('admin' . EXT);

class Log extends admin {

    function __construct() {
        parent::__construct();
        $this->load->model('log_model');
        $this->load->helper('upload');
        $this->data['positions'] = $this->config->item('positions');
        $this->data['pages'] = $this->config->item('pages');
    }

    function index() {
        $p = (isset($_GET["p"]) ? $_GET["p"] : 1);
        $limit = 20;
        $offset = ($p - 1) * $limit;
        $rows = $this->log_model
                ->order_by("id", "DESC")
                ->limit($limit, $offset)
                ->get_all();
        $count = $this->log_model->count_all();

        foreach ($rows as $k => $row) {
            $users = $this->user_model->get($row->user_id);
            if ($users) {
                $rows[$k]->username = $users->username;
            }
        }

        $this->data['rows'] = $rows;
        $conf = array(
            'base_url' => admin_url($this->router->class) . '/index',
            'total_rows' => $count,
            'per_page' => $limit,
            'cur_page' => $p,
        );
        $this->pagination->initialize($conf);
        $this->data['pagnav'] = $this->pagination->display_query_string();
        $this->data['tpl_file'] = 'log/index';
        $this->load->view('layout/default', $this->data);
    }

}
