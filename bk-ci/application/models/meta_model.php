<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author  Nguyen Viet Manh
 * @email   manhnv@binhhoang.com
 * @date    17.04.2012
 */
class Meta_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $_table = $this->db->dbprefix('c_meta');
        $this->_table = $_table;
    }

    function show_title($name = 'default', $arr_search = NULL, $arr_replace = NULL) {
        $row = $this->get_by(array('name_alias' => $name));
        if (!$row) {
            $row = $this->get_by(array('name_alias' => 'default'));
        }

        if ($row) {
            $tmp['title'] = trim($row->title);
            $tmp['description'] = trim($row->description);
            $tmp['keywords'] = trim($row->keywords);
            return str_replace($arr_search, $arr_replace, $tmp);
        }
        return NULL;
    }

}