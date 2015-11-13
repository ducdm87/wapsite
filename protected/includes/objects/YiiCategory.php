<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
  

class YiiCategory{
    private $items = array();
    private $item = array();
    private $active = 0;
    var $_db = null;
    
    private $table = "{{categories}}";
    
    function __construct($db = null) {
        $this->_db = $db;        
        if($this->_db == null) $this->_db = Yii::app()->db;
        
         $this->table = TBL_CATEGORIES;
    }
    
    static function & getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new YiiCategory();
        }

        return $instance;
    } 
    
    function loadItems($field = "*", $condition = "", $oderby = " lft ASC ", $limit = 10, $start = 0){
        
        $table = YiiTables::getInstance(TBL_CATEGORIES);
        $items = $table->loads($field, $condition,$oderby, $limit, $start);
        return $items;
    }
    
    function loadItem($id, $field = "*"){         
        $table = YiiTables::getInstance(TBL_CATEGORIES);
        $table->load($id);
       return $table;
    }
    
    function loadXrefMenu($moduleID)
    {
        $obj_menuitem = YiiTables::getInstance(TBL_MODULE_MENUITEM_REF);
        return $obj_menuitem->loadColumn("menuID", "moduleID = $moduleID", null,null);
    }
    
}
