<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class sessions_captcha_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $_table = $this->db->dbprefix('sessions_captcha');
        $this->_table = $_table;
    }

}
