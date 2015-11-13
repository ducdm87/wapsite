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
    
    // lay tat ca ext
    function getItems()
    {
        if(count($this->items)>0)
            return $this->items;
        
        $query = "SELECT * FROM ". $this->table_item ." WHERE status = 1 ORDER BY `lft` ASC ";
        $query_command = Yii::app()->db->createCommand($query);
        $items = $query_command->queryAll();
        $arr_new = array();
        foreach ($items as $key => $item) {            
            if($item['alias'] == "") $item['alias'] = $item['title'];
            $item['path'] = $item['alias'];
            if($item['type'] == "app"){
                $item['url'] = $item['alias'];
                if($item['level'] >1 AND isset($arr_new[$item['parentID']])){
                    $item['url'] = $arr_new[$item['parentID']]['path'] . "/". $item['url'];
                    $item['path'] = $item['url'];
                }
            }else if($item['type'] == "url"){
                $item['url'] = $item['link'];
            }
            $item['params'] = json_decode($item['params']);
            $arr_new[$item['id']] = $item;
        }
        
        foreach ($arr_new as $key => $item) {            
             if($item['type'] == "alias"){
                 $alias_option = $item['params']->alias_option;
                 if(isset($arr_new[$alias_option])){
                     $item['url'] = $arr_new[$alias_option]['url'];
                 }
             }
            if($this->active == 0 AND $item['default'] == 1){
                $this->active = $item['id'];
                $item['url'] = '';
            }
            $arr_new[$key] = $item;
        }
        
        $this->items = $arr_new;
        return $this->items;
    }
    
    // lay 1 ext
    function getItem($extID = null) {   }
     
    function getModules() { }
    function getModule($moduleID) { }
    
    function getApps() { }
    function getApp($appID) { }    
    
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
    function loadApp($appID = null){ }    
}
