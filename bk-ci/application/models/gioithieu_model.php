<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class gioithieu_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $_table = $this->db->dbprefix('gioithieu');
        $this->_table = $_table;
    }

}

?>