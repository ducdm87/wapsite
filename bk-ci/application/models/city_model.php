<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class City_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $_table = $this->db->dbprefix('cities');
        $this->_table = $_table;
    }

}