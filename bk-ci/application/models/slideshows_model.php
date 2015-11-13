<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author  Tran Van Thanh
 * @email   thanhtran@vietnambiz.com
 * @date    06.09.2011
 */
 
class Slideshows_model extends MY_Model {
    
    function __construct()
    {
        parent::__construct();
        $this->_table = 'slideshows';
    }
    
    function get_slideshows($page = 1)
    {
    	$this->db->order_by('time DESC');
    	$limit = $this->config->item('articles', 'limit');
    	return $this->limit($limit, ($page - 1)*$limit)->get_all();
    }

    function delete_slideshows($slideshow_id)
    {    	    	
    	if(is_numeric($slideshow_id)) {
        	$a[] = $slideshow_id;
        	$slideshow_id = $a;
        }    	
    	$this->db->where_in('id', $slideshow_id)->delete('slideshows');
    	$this->delete_many($slideshow_id);
    }
}