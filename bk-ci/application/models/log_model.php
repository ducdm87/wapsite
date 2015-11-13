<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author  Nguyen Viet Manh
 * @email   manhnv@binhhoang.com
 * @date    17.04.2012
 */
class Log_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $_table = $this->db->dbprefix('c_logs');
        $this->_table = $_table;
    }

    function add($crime_id, $msg) {
        if ($this->insert(array("crime_id" => $crime_id, "user_id" => $_SESSION["user"]["id"], "msg" => $msg, "created" => time())))
            return TRUE;
        return FALSE;
    }

}