<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class help_category_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $_table = $this->db->dbprefix('help_categories');
        $this->_table = $_table;
    }

    function get_cat_trees($pid = 0, $space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;L&nbsp;&nbsp;', $trees = NULL) {
        if (!$trees)
            $trees = array();
        $where = array('pid' => intval($pid));
        $this->db->select()
                ->from($this->_table)
                ->where($where);
        $this->db->order_by('order','ASC');
        $this->db->order_by('id','DESC');
        $q = $this->db->get();
        $arr = $q->result();
        foreach ($arr as $k => $rs) {
            if ($pid == 0) {
                $rs->stt = ($k + 1) . ".";
                $trees[] = $rs;
            } else {
                $rs->stt = $space . ($k + 1) . ".";
                $rs->name = $rs->name;
                $trees[] = $rs;
            }

            $trees = $this->get_cat_trees($rs->id, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $space . '' . ($k + 1) . '.', $trees);
        }
        return $trees;
    }

    function get_cat_trees_name($pid = 0, $space = '----', $trees = NULL) {
        if (!$trees)
            $trees = array();
        $where = array('pid' => intval($pid));
        $this->db->select()
                ->from($this->_table)
                ->where($where);
        $this->db->order_by('order','ASC');
        $this->db->order_by('id','DESC');
        $q = $this->db->get();
        $arr = $q->result();
        foreach ($arr as $k => $rs) {
            if ($pid == 0) {
                $trees[] = $rs;
            } else {
                $rs->name = $space . $rs->name;
                $trees[] = $rs;
            }

            $trees = $this->get_cat_trees_name($rs->id, $space . $space, $trees);
        }
        return $trees;
    }

    function show_level_cat($id = NULL) {
        $row = $this->get($id);
        $tmp = array();
        if ($row) {
            $pid = $row->pid;
            while ($pid != 0) {
                $r = $this->get($pid);
                if ($r) {
                    $tmp[] = $r;
                    $pid = $r->pid;
                    sort($tmp);
                }
            }
            $tmp[] = $row;
        }
        return $tmp;
    }

    function get_sub_cats($pid = 0, $space = '----', $trees = NULL) {
        if (!$trees)
            $trees = array();
        $where = array('pid' => intval($pid), 'active' => 'yes');
        $this->db->select()
                ->from($this->_table)
                ->where($where);
        $this->db->order_by('order','ASC');
        $this->db->order_by('id','DESC');
        $q = $this->db->get();
        $arr = $q->result();
        foreach ($arr as $k => $rs) {
            if ($pid == 0) {
                $trees[] = $rs;
            } else {
                $rs->name = $space . $rs->name;
                $trees[] = $rs;
            }

            $trees = $this->get_cat_trees_name($rs->id, $space . $space, $trees);
        }
        return $trees;
    }

}