<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 



class YiiMenu{  
    private $items = array();
    private $arr_menu = array();
    private $item = array();
    private $active = 0;
    
    private $table = "{{menus}}";
    private $table_item = "{{menu_item}}";
    
    function __construct() {
         $this->table = TBL_MENU;
         $this->table_item = TBL_MENU_ITEM;
    }
    
    static function & getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new YiiMenu();
        }

        return $instance;
    }
    
    // lay tat ca menu
    function getItems()
    {
        if(count($this->items)>0)
            return $this->items;
         
        $query = "SELECT * FROM ". $this->table_item ." WHERE status = 1 ORDER BY `lft` ASC ";
        $query_command = Yii::app()->db->createCommand($query);
        $items = $query_command->queryAll();
        $arr_new = array();
        $arr_menu = array();
         
        foreach ($items as $key => $item) {            
            if($item['alias'] == "") $item['alias'] = $item['title'];
            $item['path'] = $item['alias'];
            if($item['type'] == "app"){
                $item['url'] = "/".$item['alias'];
                if($item['level'] >1 AND isset($arr_new[$item['parentID']])){
                    $path_parent = trim($arr_new[$item['parentID']]['path'],"/");
                    $item['url'] = "/".$path_parent . $item['url'];
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
                $item['url'] = '/';
            }
            $arr_new[$key] = $item;
            $arr_menu[$item['menuID']][] = $item;
        }
        
        $this->items = $arr_new;
        $this->arr_menu = $arr_menu;
        return $this->items;
    }
    
    // lay 1 menu
    function getItem($menuItemID = null)
    {
        if($menuItemID == 0) return null;
        $this->getItems();
        if(isset($this->items[$menuItemID]))
            return $this->items[$menuItemID];
        return null;
    }
    
    function getMenuApp($app = 'article'){
        $items = $this->getItems();
        if(empty($items)) return array();
        $arr_new = array();
        foreach ($items as $item) {
            if($item['app'] == $app){
                $arr_new[] = $item;
            }
        }
        return $arr_new;
    }
    
    function getMenu($menuID = null){
        if($menuID == 0) return null;
        $this->getItems();
        if(isset($this->arr_menu[$menuID]))
            return $this->arr_menu[$menuID];
        return null;
    }
    
    // lay menu active
    function getItemActive()
    {
//      $table_menu = YiiTables::getInstance(TBL_MENU);
        $this->getItems();
        return $this->items[$this->active];
    }
    
    // dat active
    function setActive($active){
        $this->active = $active;
    }
    
    // id cua menu active
    function getActive(){
        return $this->active;
    }
    
    /* danh cho quan tri */
    
    /* 
     * desc: lay ra tat ca menu
     * $getSub: có lấy các item con không
     */    
    function loadMenus($field = "*", $getSub = true){
        $table_menu = YiiTables::getInstance(TBL_MENU);
        $items = $table_menu->loads($field);
        
        if($getSub == true){
            foreach($items as &$item){
                $item['_items'] = $this->loadItems($item['id'], "*");
            }
        }
       return $items;
    }
    
    /* 
     * desc: lay ra 1 menu
     * $getSub: có lấy các item con không
     */    
    function loadMenu($menuID = null, $field = "*", $getSub = true){
        $table_menu = YiiTables::getInstance(TBL_MENU);
        $table_menu->load($menuID);
        
        if($getSub == true){
            $table_menu->_items = $this->loadItems($menuID, "*");
        }
       return $table_menu;
    }
    
    /* 
     * desc: lay ra danh sach menu item
     * $menuID: menu item cua menu nay. 
     *      neu khong chuyen vao thi lay tat ca menu item cua tat ca menu
     */
    function loadItems($menuID = null, $field = "*", $condition = "", $oderby = " lft ASC "){
        $conds = array();
        if($menuID != null){
             $conds[] = "menuID = $menuID";
        }else $conds[] = "menuID != 0";
        if($condition != "" AND $condition != null)
        {
            $conds[] = $condition;
        }
        $condition = implode(" AND ", $conds);

        $table_menu_item = YiiTables::getInstance(TBL_MENU_ITEM);
        $items = $table_menu_item->loads($field, $condition,$oderby, null, null);
        return $items;
    }
    
    /**
     * desc: lay 1 menu item
     * $menuItemID:
    */    
    function loadItem($menuItemID = null, $field = "*"){
        $table_menu_item = YiiTables::getInstance(TBL_MENU_ITEM);
        $table_menu_item->load($menuItemID);
        return $table_menu_item;
    }
}
