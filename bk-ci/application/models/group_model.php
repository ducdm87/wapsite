<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author  Nguyen Viet Manh
 * @email   manhnv@binhoang.com
 * @date    02.08.2012
 */
 
class Group_model extends MY_Model {
    
    function __construct()
    {
        parent::__construct();
        $_table = $this->db->dbprefix('c_groups');
        $this->_table = $_table;
    }
    
    
}