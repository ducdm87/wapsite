<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class help_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $_table = $this->db->dbprefix('help');
        $this->_table = $_table;
    }

    function lasthelpbyType($type = 1, $limit = 10) {
        $this->db->where("active", 'yes');
        $this->db->like("title_link_old ", ',' . $type . ',');
        $this->db->select('title,title_link,image,short_desc')
                ->from($this->_table)
                ->order_by('id', 'DESC')
                ->limit($limit, 0)
        ;
        $arr = $this->db->get()->result();
        return $arr;
    }

    function mostviewhelp($catid = 1, $limit = 10) {
        $this->load->model('help_category_model');

        $str_catid = $catid;
        $sub_cats = $this->help_category_model->get_sub_cats($catid);
        foreach ($sub_cats as $k => $v) {
            $str_catid .= ',' . $v->id;
        }

        $this->db->where("catid IN($str_catid)");
        $this->db->where("active", 'yes');
        $this->db->select('title,title_link,image')
                ->from($this->_table)
                ->order_by('order', 'DESC')
                ->order_by('id', 'DESC')
                ->limit($limit, 0)
        ;
        $arr = $this->db->get()->result();
        return $arr;
    }

    function mostviewhelp2($catid = 1, $limit = 10) {
        $this->load->model('help_category_model');

        $str_catid = $catid;
        $sub_cats = $this->help_category_model->get_sub_cats($catid);
        foreach ($sub_cats as $k => $v) {
            $str_catid .= ',' . $v->id;
        }

        $this->db->where("catid IN($str_catid)");
        $this->db->where("active", 'yes');
        $this->db->select('title,title_link,image')
                ->from($this->_table)
                ->order_by('view', 'DESC')
                ->order_by('id', 'DESC')
                ->limit($limit, 0)
        ;
        $arr = $this->db->get()->result();
        return $arr;
    }

    function lasthelp($catid = 1, $limit = 10) {
        $this->load->model('help_category_model');

        $str_catid = $catid;
        $sub_cats = $this->help_category_model->get_sub_cats($catid);
        foreach ($sub_cats as $k => $v) {
            $str_catid .= ',' . $v->id;
        }

        $this->db->where("catid IN($str_catid)");
        $this->db->where("active", 'yes');
        $this->db->select('title,title_link,image,short_desc')
                ->from($this->_table)
                ->order_by('id', 'DESC')
                ->limit($limit, 0)
        ;
        $arr = $this->db->get()->result();
        return $arr;
    }

    function get_limit($limit = 10, $offset = 0, $where = array(), $where_in = '') {
        if ($where)
            $this->db->where($where);

        if ($where_in != '')
            $this->db->where("catid IN($where_in)");

        $rows = $this->db->select()
                ->from($this->_table)
                ->order_by('order', 'ASC')
                ->limit($limit, $offset)
                ->get()
                ->result();

        if ($where)
            $this->db->where($where);

        if ($where_in != '')
            $this->db->where("catid IN($where_in)");

        $count = $this->db->select('count(id) as cnt')
                        ->from($this->_table)
                        ->get()
                        ->row()
                ->cnt;

        return array('rows' => $rows, 'count' => $count);
    }

}