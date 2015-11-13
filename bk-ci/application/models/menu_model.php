<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author  Nguyen Viet Manh
 * @email   manhnv@binhhoang.com
 * @date    17.04.2012
 */
 
class Menu_model extends MY_Model {
    
    function __construct()
    {
        parent::__construct();
        $_table = $this->db->dbprefix('menus');
        $this->_table = $_table;
    }
    
    function get_level($pid = 0)
    {
    	
    }
    
    function get_trees($pid = 0, $space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;L&nbsp;&nbsp;', $trees = NULL, $is_stt = false)
    {
    	if(!$trees) $trees = array();
    	$where	=	array('pid' => intval($pid));
    	$this->db->select()
    	->from($this->_table)
    	->where($where);
    	$this->db->order_by('order ASC');
    	$q = $this->db->get();
    	$arr = $q->result();
    	foreach($arr as $k => $rs){
    		if($pid==0){
    			$rs->stt	=	$is_stt ? ($k+1)."." : "";
    			$trees[] = $rs;
    		}else{
    			$rs->stt = $space.($is_stt ? ($k+1)."." : "");
    			$rs->name = $rs->name;
    			$trees[] = $rs;
    		}
    
    		$trees = $this->get_trees($rs->id,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$space.''.($is_stt ? ($k+1) . '.' : ""),$trees, $is_stt);
    	}
    	return $trees;
    }
    
}