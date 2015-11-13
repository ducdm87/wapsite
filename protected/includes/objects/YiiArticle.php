<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
  

class YiiArticle{
    private $items = array();
    private $item = array();
    private $active = 0;
    var $_db = null;
    
    private $table = "{{articles}}";
    
    function __construct($db = null) {
        $this->_db = $db;        
        if($this->_db == null) $this->_db = Yii::app()->db;
        
         $this->table = TBL_ARTICLES;
    }
    
    static function & getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new YiiArticle();
        }

        return $instance;
    } 

    function loadItems($field = "*", $condition = "", $orderBy = " lft ASC ", $limit = 10, $start = 0){        
        $table = YiiTables::getInstance($this->table);
        $items = $table->loads($field, $condition,$orderBy, $limit, $start);
        return $items;
    }
    
    function loadItem($id, $field = "*"){         
        $table = YiiTables::getInstance($this->table);
        $table->load($id);
       return $table;
    } 
    
    
    function getItems($field = "*", $condition = "", $orderBy = " A.id DESC ", $limit = 10, $start = 0)
    {
        if($field == null){
            $field = "A.*, B.title cat_title, B.alias cat_alias";
        }
        $command = $this->_db->createCommand()->select($field)
                ->from($this->table ." A")
                ->leftJoin(TBL_CATEGORIES ." B", "A.catID = B.id");
        
        if($condition != null) $command->where($condition);
        if($orderBy != null AND $orderBy != "") $command->order($orderBy);
        if($limit != null)$command->limit($limit, $start);
        
        $results = $command->queryAll();
        
        return $results;
    }
    
    function remove($id = null, $condition = "")
    {
        $table = YiiTables::getInstance($this->table);
        $table->remove($id, $condition);
    }
}
