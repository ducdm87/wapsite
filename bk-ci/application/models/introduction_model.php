<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Introduction_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $_table = $this->db->dbprefix('introduction');
        $this->_table = $_table;
        $this->primary_key = 'id';
    }

}