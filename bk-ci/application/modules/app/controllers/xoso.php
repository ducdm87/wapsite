<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'app' . EXT;

class xoso extends app {

    function __construct() {
        parent::__construct();
        $this->load->helper('rest');
    }

    public function index() {
        $rest = new REST;

        $area = $rest->_request['area'];
        $lid = (int) $rest->_request['lid'];
        $date = $rest->_request['date'];

        $arr = null;

        $this->db->start_cache();
        if ($area != '') {
            if ($area == 'MB') {
                $this->db->where('r.lid', 1);
            } else {
                $this->db->where("l.area", $area);
            }
        } elseif ($lid > 0) {
            $this->db->where('r.lid', $lid);
        }
        $this->db->stop_cache();

        if (!$date) {
            if ($lid > 0) {
                $list = $this->db->select('r.*,l.name,l.code,l.area')->from('xs_result AS r')
                        ->join('xs_location AS l', 'r.lid = l.id', 'left')
                        ->order_by('r.date', 'DESC')
                        ->limit(1)
                        ->get()
                        ->result();
            } else {
                $date_now = date('Y-m-d');
                $date = date('Y-m-d', strtotime('-1 day'));

                $this->db->where('r.date', $date_now);
                $list = $this->db->select('r.*,l.name,l.code,l.area')->from('xs_result AS r')
                        ->join('xs_location AS l', 'r.lid = l.id', 'left')
                        ->order_by('l.ordering', 'ASC')
                        ->get()
                        ->result();
                if (!$list) {
                    $this->db->where('r.date', $date);
                    $list = $this->db->select('r.*,l.name,l.code,l.area')->from('xs_result AS r')
                            ->join('xs_location AS l', 'r.lid = l.id', 'left')
                            ->order_by('l.ordering', 'ASC')
                            ->get()
                            ->result();
                }
            }
        } else {
            $date = date('Y-m-d', strtotime($date));
            
            $this->db->where('r.date', $date);
            $list = $this->db->select('r.*,l.name,l.code,l.area')->from('xs_result AS r')
                    ->join('xs_location AS l', 'r.lid = l.id', 'left')
                    ->order_by('l.ordering', 'ASC')
                    ->get()
                    ->result();
            if (!$list && $lid > 0) {
                $this->db->where('r.date <', $date);
                $list = $this->db->select('r.*,l.name,l.code,l.area')->from('xs_result AS r')
                        ->join('xs_location AS l', 'r.lid = l.id', 'left')
                        ->order_by('r.date', 'DESC')
                        ->limit(1)
                        ->get()
                        ->result();
//                echo $this->db->last_query();
            } elseif (!$list) {
                $i = 0;
                foreach ($this->data['location_today'] as $k => $locs) {
                    if ($area != '' && $area != $k)
                        continue;
                    foreach ($locs as $value) {
                        $list[$i]->lid = $value->id;
                        $list[$i]->date = $date;
                        $list[$i]->name = $value->name;
                        $list[$i]->code = $value->code;
                        $list[$i]->area = $value->area;
                        $i++;
                    }
                }
            }
        }

        $this->db->flush_cache();

        $areaList = array(
            'MB' => 'Miền Bắc',
            'MT' => 'Miền Trung',
            'MN' => 'Miền Nam',
        );

        foreach ($list as $k => $item) {
            $item->date = date('d-m-Y', strtotime($item->date));
            $item->area_name = $areaList[$item->area];
            $item->strday = $item->date;
            $arr[$item->area][] = $item;
        }

        if ($date && $area == '' && $lid == 0) {
            foreach ($this->data['location_today'] as $k2 => $locs) {
                $check = false;
                foreach ($arr as $k1 => $v2) {
                    if ($k1 == $k2) {
                        $check = true;
                        break;
                    }
                }
                if ($check == false) {
                    foreach ($locs as $value) {
                        $tmp = null;
                        $tmp->lid = $value->id;
                        $tmp->date = $date;
                        $tmp->name = $value->name;
                        $tmp->code = $value->code;
                        $tmp->area = $value->area;

                        $tmp->date = date('d-m-Y', strtotime($tmp->date));
                        $tmp->area_name = $areaList[$tmp->area];
                        $tmp->strday = $tmp->date;
                        $arr[$k2][] = $tmp;
                    }
                }
            }
        }

        $this->_data['items'] = $arr;
        $this->load->view('xoso/index', $this->_data);
    }

}

?>
