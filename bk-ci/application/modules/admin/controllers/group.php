<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('admin'.EXT);

class Group extends admin {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('group_model'));
    }
    
    function index()
    {
    	
    	$rows	=	$this->group_model->get_all();
    	foreach($rows as $k => $v)
    	{
    		$count = $this->user_model->count_by(array("group_id" => $v->id,"is_delete" => 0));
    		$rows[$k]->count = $count;
    	}
    	
    	//print_r($rows);
    	$this->data['rows']		=	$rows;
        $this->data['tpl_file'] = 'group/index';        
        $this->load->view('layout/default', $this->data);
    }
    
    function edit($id = NULL)
    {
    	$row	=	$this->group_model->get_by(array('id' => $id));
    	$this->data['row']	=	$row;
    	
    	if($_SERVER["REQUEST_METHOD"] == "POST")
    	{
    		$this->form_validation->set_rules('name', lang('GROUP_NAME'),'required');
    		
    		if($this->form_validation->run() == TRUE)
    		{
    			$data	=	array('name' => $this->input->post('name'));
    			$this->group_model->update($id, $data);
    			redirect(admin_url($this->data['module']));
    		}
    		else
    		{
    			$this->message->add('error', validation_errors());
    		}
    		
    	}
    	
    	$this->data['tpl_file'] = 'group/edit';
    	$this->load->view('layout/default', $this->data);
    }
    
    function add()
    {
    	if($_SERVER["REQUEST_METHOD"] == "POST")
    	{
    		$this->form_validation->set_rules('name', lang('GROUP_NAME'),'required');
    	
    		if($this->form_validation->run() == TRUE)
    		{
    			$data	=	array('name' => $this->input->post('name'));
    			$this->group_model->insert($data);
    			redirect(admin_url($this->data['module']));
    		}
    		else
    		{
    			$this->message->add('error', validation_errors());
    		}
    	
    	}
    	 
    	$this->data['tpl_file'] = 'group/add';
    	$this->load->view('layout/default', $this->data);
    }
    
    function delete($id = NULL)
    {
    	$row	=	$this->group_model->get_by(array('id' => $id));
    	if($row)
    	{
    		if($this->group_model->delete($id))
    		{
    			redirect(admin_url($this->data['module']));
    		}
    	}
    }
    
    function set_admin($id = NULL, $val = 0)
    {
    	if($row	=	$this->group_model->get_by(array('id' => $id)))
    	{
    		if($this->group_model->update($id, array("admin" => $val)))
    		{
    			admin_redirect("group");
    		}
    	}
    }
}
