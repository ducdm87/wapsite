<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'client' . EXT;

class Home extends Client {

    function __construct() {
        parent::__construct();
        $time = date('H:i');
        if ($time > '16:00' && $time < '19:00')
            header("Cache-Control: max-age=30");
    }

    public function index() {
     //   $this->load->model(array('xs_result_model', 'xs_northern_model', 'gioithieu_model'));

//    	$this->db->where('(r.date=\'' . $yesterday . '\' OR r.date=\'' . $today . '\')');
//        $this->db->where('l.status', 1);
//        $data = $this->db->select('r.a0,r.date,l.name,l.alias,l.area,r.extension')
//                ->from('xs_result AS r')
//                ->join('xs_location AS l', 'r.lid = l.id', 'left')
//                ->order_by('r.date', 'DESC')
//                ->order_by('l.ordering', 'ASC')
//                ->get()
//                ->result(); 
$this->load->helper('url');
        echo site_url("client/xoso/home/12-12-12");


        $this->data['tmpl'] = 'home/home';
        $this->load->view('default', $this->data);
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */