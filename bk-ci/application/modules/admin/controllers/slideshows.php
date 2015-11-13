<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Articles Manager
 * @author	Tran Van Thanh
 * @mail	thanhtran@vietnambiz.com
 * @date	06.09.2011
 */
require_once('admin'.EXT);

class Slideshows extends admin {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('slideshows_model'));
		$this->load->helper(array('upload','text'));			
	}

	function index()
	{
		$page = (isset($_GET['p']) && is_numeric($_GET['p'])) ? $_GET['p'] : 1;

        if(isset($_GET['status'])) {
            $status = ($_GET['status'] == 'active') ? 'yes' : 'no';
            $this->db->where('status', $status);
        }		
		

		$this->data['slideshows'] 	= $this->slideshows_model->get_slideshows($page != "" ? $page : 1);
		$this->data['page'] 		= $page;

    	$conf =	array(
    		'base_url'		=> admin_url($this->router->class).'/',
    		'total_rows'	=> $this->slideshows_model->count_all(),
    		'per_page'		=> $this->config->item('articles', 'limit'),
    		'cur_page'		=> $page,
    	);
    	$this->pagination->initialize($conf);
    	$this->data['pagnav'] = $this->pagination->display_query_string();

		if($this->input->is_ajax_request()) {
			$this->load->view('slideshows/list', $this->data);
		}
		else {
			$this->data['tpl_file']	= 'slideshows/index';
			$this->load->view('layout/default', $this->data);
		}
	}

	function update($id = NULL)
	{
		$row	=	$this->slideshows_model->get($id);		
		if($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
			$this->form_validation->set_message('required', '%s không hợp lệ!');
    		$this->form_validation->set_rules('txt_title', 'Tên slideshows', 'required|trim|xss_clean');

    		if($this->form_validation->run() == TRUE)
            {
            	$title 	= $this->input->post('txt_title');
            	
            	$have_img = false;
            	//var_dump($_FILES);
            	if(isset($_FILES["images"]["name"]) && $_FILES["images"]["name"] != '')
            	{
            		// Upload images
            		$album_dir = 'uploads/slideshows/';
            		if(!is_dir($album_dir))
            		{
            			create_dir($album_dir);
            		}
            	
            		/*
            		 $ext = get_ext($_FILES["images"]["name"]);
            		if(!in_array($ext, array('png', 'gif', 'jpg', 'jpeg'))) {
            		continue;
            		} */
            	
            		//die('yes');
            		$new_path = $album_dir.$_FILES["images"]["name"];
            		//die($new_path);
            		//$data["img"]	=	$this->_create_thumb($new_path);
            		//die($data["img"]);
            		move_uploaded_file($_FILES["images"]['tmp_name'], dirname($_SERVER['SCRIPT_FILENAME']).'/'.$new_path);
            		$have_img = true;
            	}
            	$data = array(
            			'title'			=> strip_tags($title),
            			//'description'	=> $this->input->post('txt_description'),
            			//'img'			=> $this->_create_thumb($new_path),
            			'active'		=> $this->input->post('active'),
            			'order'		=>	$this->input->post('order'),
            			'url'		=>	$this->input->post('txt_url')
            	);
            	
            	if($have_img) $data['img']	=	$new_path;//$this->_create_thumb($new_path);
		        	
	            if($row)
	            {
	            	$this->slideshows_model->update($id, $data);
	            }
	            else
	            {
	            	$data['time']	=	time();
	            	$this->slideshows_model->insert($data);
	            }
	            die('yes');
           }else 
           {
           		die(validation_errors());
           }	
		}
		$this->data["row"]	=	$row;
		$this->load->view('slideshows/update', $this->data);
	}
	
	function active($id = NULL, $type = 0)
	{
		if($row	=	$this->slideshows_model->get($id))
		{
			if($this->slideshows_model->update($id, array("active" => $type))) admin_redirect($this->data["module"]);
		}
	}
	
    function delete($slideshow_id = null)
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
        	$slide = $this->slideshows_model->get($slideshow_id);        
			unlink($slide->img_path);
        	$this->slideshows_model->delete_slideshows($slideshow_id);
            die('yes');
        }
    }

	function do_action()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST') {

			$id_list = $this->input->post('id');
			$action = $this->input->post('action');

			if($action == 'delete') {
				$this->delete($id_list);
			}
			elseif($action == 'pending') {
				$this->slideshows_model->update_many($id_list, array('status' => 'no'));
			}
			elseif($action == 'active') {
				$this->slideshows_model->update_many($id_list, array('status' => 'yes'));
			}
			die('yes');
		}
	}

	function load_row($slideshow_id = null)
	{		
		$this->data['slideshows'] = $this->slideshows_model->get($slideshow_id);		
		$this->load->view('slideshows/row', $this->data);
	}	
	
	function _delete_image($img_path = '')
	{
    	$filename = basename($img_path);
        $sizes = config_item('thumb_size');

    	foreach($sizes as $size) {
    		$path = str_replace($sizes[0], $size, $img_path);
    		if(is_file($path)) unlink($path);
    	}
    	$path = str_replace('/thumb_'.$sizes[0], '', $img_path);
    	if(is_file($path)) unlink($path);
	}
	
	function _create_thumb($img_path = '')
	{
		$sizes = config_item('thumb_slideshow');
		$this->load->helper('string');
		$pathinfo = pathinfo($img_path);
		$new_name = $pathinfo['basename'];
		$temp	=	explode('.',$pathinfo['basename']);
		$new_name	=	$temp[0].date('-his-mdy').'.'.$pathinfo['extension'];

		rename($img_path, $pathinfo['dirname'].'/'.$new_name);

        include_once (config_item('phpThumb_dir')."ThumbLib.inc.php");

        $options = array(
		    'resizeUp' 		=> true,
		    'jpegQuality'	=> 88,
        );

		
		foreach($sizes as $size)
		{
			$thumb_dir  = $pathinfo['dirname'].'/thumb_'.$size;
			create_dir($thumb_dir);

			$t_size = explode('-', $size);

		    $thumb 	= PhpThumbFactory::create($pathinfo['dirname'].'/'.$new_name, $options);

		    $thumb->adaptiveResize($t_size[0] + 5, $t_size[1] + 5);
		    $thumb->cropFromCenter($t_size[0], $t_size[1]);
		    $thumb->save($thumb_dir.'/'.$new_name, 'jpg');
		}
		return $pathinfo['dirname'].'/thumb_'.$sizes[0].'/'.$new_name;
	}
}

