<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author  Nguyen Viet Manh
 * @email   manhnv@binhoang.com
 * @date    02.08.2012
 */
 
class Module_model extends MY_Model {
    
	protected $_table_group;
	protected $_table_group_module;
	
    function __construct()
    {
        parent::__construct();
        $_table = $this->db->dbprefix('c_modules');
        $this->_table = $_table;
        $this->_table_group	=	$this->db->dbprefix('c_groups');
        $this->_table_group_module	=	$this->db->dbprefix('c_group_module');
    }
    
    function check_per_module()
    {
    	if($this->router->class == 'home')
    	{
    		return TRUE;
    	}
    	
    	$row	=	$this->db->select('gm.*')->from($this->_table.' m')
    				->join($this->_table_group_module.' gm','gm.module_id=m.id')
    				->join($this->_table_group.' g','g.id=gm.group_id')
    				->where('g.id',$_SESSION['user']['group_id'])
    				->where('m.name_alias',$this->router->class)
    				->where('actions <>','')
    				//->where('admin',1)
    				->get()
    				->row();
//     	    		echo $this->db->last_query(); die;
    	if($row)
    	{
    		if($func = $this->module_model->get_by(array("name_alias" => $this->router->method, "pid <>" => 0)))
    		{
    			$tmp	=	explode(",",$row->ignore_actions);
    			foreach($tmp as $k => $v)
    			{
    				if($func->id == $v)
    				{
    					return false;
    				}
    			}
    		}
    	}
    	
    	if($row) return TRUE;
    	return FALSE;
    }
    
    function check_per_func($mud = NULL, $func = NULL)
    {
    	if($this->router->class == 'home')
    	{
    		//return TRUE;
    	}
    	 
    	$row	=	$this->db->select('gm.*')->from($this->_table.' m')
    	->join($this->_table_group_module.' gm','gm.module_id=m.id')
    	->join($this->_table_group.' g','g.id=gm.group_id')
    	->where('g.id',$_SESSION['user']['group_id'])
    	->where('m.name_alias',$mud)
    	->where('actions <>','')
    	->get()
    	->row();
    	
    	//var_dump($row);
    	 
    	if($row)
    	{
    		if($func = $this->module_model->get_by(array("name_alias" => $func, "pid <>" => 0)))
    		{
    			$tmp	=	explode(",",$row->ignore_actions);
    			foreach($tmp as $k => $v)
    			{
    				if($func->id == $v)
    				{
    					return false;
    				}
    			}
    		}
    	}
    	 
    	if($row) return TRUE;
    	return FALSE;
    }
    
    function check_by_group_module($group_id, $module_id)
    {
    	$row	=	$this->db->select('gm.*')->from($this->_table.' m')
			    	->join($this->_table_group_module.' gm','gm.module_id=m.id')
			    	->join($this->_table_group.' g','g.id=gm.group_id')
			    	->where('g.id',$group_id)
			    	->where('m.id',$module_id)
			    	->get()
			    	->row();
    	 
    	if($row) return TRUE;
    	return FALSE;
    }
    
    function get_actions($module_name = '')
    {
    	$row	=	$this->db->select('gm.*')->from($this->_table.' m')
			    	->join($this->_table_group_module.' gm','gm.module_id=m.id')
			    	->join($this->_table_group.' g','g.id=gm.group_id')
			    	->where('g.id',$_SESSION['user']['group_id'])
			    	->where('m.name_alias',$module_name)
			    	->get()
			    	->row();
    	if($row)
    	{
    		return $row->actions;
    	}
    	return NULL;
    }
    
    function get_module_by_user($pid = 0)
    {
    	$result	=	$this->db->select('gm.*,m.*')->from($this->_table.' m')
		    	->join($this->_table_group_module.' gm','gm.module_id=m.id')
		    	->join($this->_table_group.' g','g.id=gm.group_id')
		    	->where('g.id',$_SESSION['user']['group_id'])
		    	->where('m.pid',$pid)
		    	->where('gm.actions <>','')
		    	->order_by('m.order','ASC')
		    	->get()
		    	->result();
    	
    	return $result;
    }
}