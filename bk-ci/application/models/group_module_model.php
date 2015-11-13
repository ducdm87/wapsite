<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author  Nguyen Viet Manh
 * @email   manhnv@binhoang.com
 * @date    02.08.2012
 */
 
class Group_module_model extends MY_Model {
    
    function __construct()
    {
        parent::__construct();
        $this->_table = 'c_group_module';
    }
    
    function edit($arr = array(), $data = array())
    {
    	$this->db->where($arr);
    	if($this->db->update($this->_table, $data))
    	{
    		return TRUE;
    	}
    	return FALSE;
    }
}