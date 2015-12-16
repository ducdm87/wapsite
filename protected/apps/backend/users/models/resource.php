<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Resource extends CFormModel {
 
    function __construct() {
        parent::__construct();
    }

    static function getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new Resource();
        }
        return $instance;
    }
    
    function getItems($build_tree = true){
        $obj_table_resource = YiiTables::getInstance(TBL_RSM_RESOURCES);
        $items = $obj_table_resource->loads("*",null, " lft ASC ");
        
        if(is_array($items) AND count($items) AND $build_tree == true){
            // thuat toan nay chi ap dung cho mang cac doi tuong
            $items = json_encode($items);
            $items = json_decode($items);
            
            $childs = array();
            foreach($items as $item)
                $childs[$item->parentID][$item->id] = $item;
             

            foreach($items as $item)                
                if (isset($childs[$item->id])){
                    $item->data_child = $childs[$item->id];
                }
            
            $items = $childs[0]; 
        }        
        return $items;
    }
    
    function getItem($cid = null){ 
        if($cid == null) $cid = Request::getVar('cid',0);
        
        $obj_table_resource = YiiTables::getInstance(TBL_RSM_RESOURCES);
        return $obj_table_resource->load($cid);
    }
    
    function getListEdit($main_item){
        $lists = array();
        $cid = Request::getVar("cid", 0);
        
        $obj_resource = YiiTables::getInstance(TBL_RSM_RESOURCES);
        $condition = ""; 
        if($main_item ->id != 0){
            $condition = "(`lft` <" . $main_item->lft . " OR `lft` > ". $main_item->rgt .")";
        }
        $items = array();        
        $results = $obj_resource->loads('id value, title text, level', $condition," lft ASC ");
        $items = array_merge($items, $results);      
        $lists['parentID'] = buildHtml::select($items, $main_item->parentID, "parentID","","class='field-introduct'", "&nbsp;&nbsp;&nbsp;","");
        
        $items = array();
        $items["B"] = "Back-end";
        $items["F"] = "Front-end";
        $items["BF"] = "Both of 2 sides";
        $lists['affected'] = $items; 
        
        $lists['type'] = array('Label', 'Request');
        $lists['status'] = array('No', 'Yes');
        
        $obj_extension = YiiExtensions::getInstance();
        $items = array();
        $items[] = array("text"=>"-- Select app --", "value"=>0);
        $results = $obj_extension->loadApps("title text, name value");
        $items = array_merge($items, $results);     
        $lists['apps'] = buildHtml::select($items, $main_item->app, "params_app","","class='field-introduct'", "&nbsp;&nbsp;&nbsp;","");
        
        return $lists;
    }
}

?> 