<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class blackkey_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $_table = $this->db->dbprefix('xs_loto_keyword');
        $this->_table = $_table;
        $this->primary_key = "id";
    }

    function getKey() {		
        $this->db->from($this->_table);
        $this->db->select('*');
        $categories = $this->db->get()->result();
//         echo $this->db->last_query(); die;
        return $categories;
    }

}  