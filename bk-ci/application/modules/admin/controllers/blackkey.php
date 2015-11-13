<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once('admin' . EXT);
// require_once('href.php');

class blackkey extends admin {

    function __construct() {
        parent::__construct();       
        $this->load->model(array('blackkey_model'));
        $this->load->helper(array('upload'));
    }    

    function key_index() {    	
    	
        $rows = $this->blackkey_model->getKey();        
        $this->data['rows'] = $rows;
        $this->data['tpl_file'] = 'blackkey/key_index';
        $this->load->view('layout/default', $this->data);
    }

    function key_edit($id = NULL, $action = '') {
        $re = false;
        $row = $this->blackkey_model->get($id);
       
        if ($row) {
            if ($action == 'yes' || $action == 'no') {
                $this->blackkey_model->update($id, array('active' => $action));
                $re = true;
            } else { 
            	
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $content_vn = $this->input->post('key_vn');
//                     $href = new href();
				
                    $content_vn = strip_tags($content_vn);
                    $content_vn = html_entity_decode(trim($content_vn), ENT_QUOTES, "utf-8");
                    $content_alias = $this->clean_text($content_vn);
                  
                    $data = array(
                        'key_vn' => $content_vn, 
                        'key_alias' => $content_alias,
                        'last_update' => date('Y-m-d H:i:s')
                    );

                    if ($this->blackkey_model->update($id, $data)) {
                        $re = true;
                    }
                }
            }
        }

        if ($re == true) {
            //delete cache
            $this->simple_cache->delete_item('client_data');
            redirect(admin_url($this->data['module'] . '/key_index'));
        }

        $this->data['row'] = $row;

        $this->data['tpl_file'] = 'blackkey/key_edit';
        $this->load->view('layout/default', $this->data);
    }

    function category_delete($id = NULL) {
        $row = $this->blackkey_model->get($id);
        if ($row) {
            if ($this->blackkey_model->delete($id)) {
                //delete cache
                $this->simple_cache->delete_item('client_data');
                redirect(admin_url($this->data['module'] . '/key_index'));
            }
        }
    }
    function clean_text($string)
    {
    	$alias = $string;
    
    	$coDau=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
    			"ằ","ắ","ặ","ẳ","ẵ",
    			"è","é","ẹ","ẻ","ẽ","ê","ề" ,"ế","ệ","ể","ễ",
    			"ì","í","ị","ỉ","ĩ",
    			"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
    			,"ờ","ớ","ợ","ở","ỡ",
    			"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
    			"ỳ","ý","ỵ","ỷ","ỹ",
    			"đ",
    			"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
    			,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
    			"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
    			"Ì","Í","Ị","Ỉ","Ĩ",
    			"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
    			,"Ờ","Ớ","Ợ","Ở","Ỡ",
    			"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
    			"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
    			"Đ","ê","ù","à");
    
    	$khongDau=array("a","a","a","a","a","a","a","a","a","a","a"
    			,"a","a","a","a","a","a",
    			"e","e","e","e","e","e","e","e","e","e","e",
    			"i","i","i","i","i",
    			"o","o","o","o","o","o","o","o","o","o","o","o"
    			,"o","o","o","o","o",
    			"u","u","u","u","u","u","u","u","u","u","u",
    			"y","y","y","y","y",
    			"d",
    			"A","A","A","A","A","A","A","A","A","A","A","A"
    			,"A","A","A","A","A",
    			"E","E","E","E","E","E","E","E","E","E","E",
    			"I","I","I","I","I",
    			"O","O","O","O","O","O","O","O","O","O","O","O"
    			,"O","O","O","O","O",
    			"U","U","U","U","U","U","U","U","U","U","U",
    			"Y","Y","Y","Y","Y",
    			"D","e","u","a");
    
    	//		var_dump(count($coDau).'<br/>'.count($khongDau));
    
    	$alias = str_replace($coDau,$khongDau,$alias);
    	$alias = str_replace('Ð','D',$alias);
//     	$alias = preg_replace('/[^a-zA-Z0-9-.]/ism', ' ', $alias);
//     	$alias = preg_replace('/^[-]+/ism', '', $alias);
//     	$alias = preg_replace('/[-]+$/ism', '', $alias);
//     	$alias = preg_replace('/[-]{2,}/ism', ' ', $alias);
    	return $alias;
    }
    
   

}
