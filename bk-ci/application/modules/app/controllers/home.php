<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'app' . EXT;

class home extends app {

    function __construct() {
        parent::__construct();
        $this->load->helper('rest');
    }

    public function index() {
        $this->load->model('xs_result_model');

        $rest = new REST;

        $date_now = date('Y-m-d');
        $date = date('Y-m-d', strtotime('-1 day'));

        $this->db->where('r.date', $date_now);
        $this->db->where('l.status', 1);
        $data = $this->db->select('r.lid,l.name,r.a0,r.date,l.area')
                ->from('xs_result AS r')
                ->join('xs_location AS l', 'r.lid = l.id', 'left')
                ->order_by('r.date', 'DESC')
                ->order_by('l.ordering', 'ASC')
                ->get()
                ->result();
        if (!$data) {
            $this->db->where('r.date', $date);
            $this->db->where('l.status', 1);
            $data = $this->db->select('r.lid,l.name,r.a0,r.date,l.area')
                    ->from('xs_result AS r')
                    ->join('xs_location AS l', 'r.lid = l.id', 'left')
                    ->order_by('r.date', 'DESC')
                    ->order_by('l.ordering', 'ASC')
                    ->get()
                    ->result();
        }

        $items = null;
        foreach ($data as $i => $item) {
            if ($item->area == 'MB') {
                if ($items[$item->area] == '') {
                    $data[$i]->date = date('d/m/Y', strtotime($item->date));
                    $items[$item->area] = $data[$i];
                }
            } elseif ($item->area == 'MT') {
                if ($items[$item->area][$item->lid] == '') {
                    $data[$i]->date = date('d/m/Y', strtotime($item->date));
                    $items[$item->area][$item->lid] = $data[$i];
                }
            } else {
                if ($items[$item->area][$item->lid] == '') {
                    $data[$i]->date = date('d/m/Y', strtotime($item->date));
                    $items[$item->area][$item->lid] = $data[$i];
                }
            }
        }

        if ($items) {
            $data = array('status' => "1", "msg" => "", "result" => $items);
            $rest->response($rest->json($data), 200);
        } else {
            $error = array('status' => "0", "msg" => "Not Found");
            $rest->response($rest->json($error), 200);
        }
    }

    public function matinh() {
        $rest = new REST;
        $data = array('status' => "1", "msg" => "", "result" => $this->data['xs_location_menu']);
        $rest->response($rest->json($data), 200);
    }

}