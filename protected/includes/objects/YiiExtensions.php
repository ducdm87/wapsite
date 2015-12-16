<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */  

class YiiExtensions{
    private $items = array();
    private $item = array();
    private $active = 0;
    
    private $table = "{{extensions}}";
    private $table_module = "{{modules}}";
    private $table_menu = "{{menus}}";
    
    var $_db = null;
    
    function __construct($db = null) { 
        $this->_db = $db;        
        if($this->_db == null) $this->_db = Yii::app()->db;
    }
    
    static function & getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new YiiExtensions();
        }

        return $instance;
    }  
    /* DANH CHO QUAN TRI */
    
    function loadExts($field = "*", $condition = ""){ 
        $table = YiiTables::getInstance(TBL_EXTENSIONS);
        $items = $table->loads($field, $condition);
        return $items;
    }
    
    function loadExt($extID = null, $field = "*"){ 
        $table = YiiTables::getInstance(TBL_EXTENSIONS);
        $table->load($extID, $field);
        return $table;
    }
    
    /* 
     * desc: lay ra tat ca module
     */    
    function loadModules($field = null, $condition = ""){ 
        if($field == null){
           $field = "a.id, a.title, a.alias, a.cdate, a.mdate, a.ordering, a.position, a.menu, a.module, a.description, a.status + 2*(b.status - 1) as status, a.params";
        }
        
        $command = $this->_db->createCommand()->select($field)
                ->from(TBL_MODULES . " as a")
                ->leftjoin(TBL_EXTENSIONS . " as b", " a.module = b.folder");
        if($conditions != null) $command->where($conditions);
        $items = $command->queryAll();
        return $items;
    }
    
    /* 
     * desc: lay ra 1 module
     */    
    function loadModule($moduleID = null, $field = null){
         if ($moduleID === 0 || $moduleID == "") {
            return YiiTables::getInstance(TBL_MODULES);;
        }
        if($field == null){
              $field = "a.id, a.title, a.alias, a.cdate, a.mdate, a.ordering, a.position, a.module, a.description, a.status + 2*(b.status - 1) as status, a.params";
        }
        
        $command = $this->_db->createCommand()->select($field)
                ->from(TBL_MODULES . " as a")
                ->rightjoin(TBL_EXTENSIONS . " as b", " ON a.module = b.folder");
        if($conditions != null) $command->where("a.id = $moduleID");
        $items = $command->queryRow();
        return $items;
    }
    
    /* 
     */
    function loadApps($field = "*", $conditions = null){         
        $command = $this->_db->createCommand()->select($field)
                ->from(TBL_EXTENSIONS);
        
        $conditions = " type = 'app'";
        
        if($conditions != null) $command->where($conditions);
        $items = $command->queryAll();
        return $items;
    }   
    function loadApp($appID = null){ }    
}
