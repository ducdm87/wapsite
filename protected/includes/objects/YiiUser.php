<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 



class YiiUser{  
    private $items = array();
    private $item = array();
    private $active = 0;
    
    private $table = "{{users}}";
    
    function __construct() {
         $this->table = TBL_USERS;
    }
    
    static function & getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new YiiUser();
        }

        return $instance;
    }
    
    // lay tat ca user
    function getUsers($condition = null, $fields = "*")
    {
        $tbl_user = YiiTables::getInstance(TBL_USERS);
        $items = $tbl_user->loads($fields, $condition, "ID DESC ", null);
        return $items;
    }
    
    function getUser($cid, $field = "*")
    {
        $tbl_user = YiiTables::getInstance(TBL_USERS);
        $tbl_user->load($cid, $field);
        return $tbl_user;
    }
    
    function getGroups($condition = null, $fields = "*", $build_tree = false){ 
        $tbl_group = YiiTables::getInstance(TBL_USERS_GROUP);
        $items = $tbl_group->loads($fields, $condition, "lft asc ", null);
        return $items;
    }
    
    function getGroup($cid, $field = "*"){ 
        $tbl_group = YiiTables::getInstance(TBL_USERS_GROUP,"id",true);
        $tbl_group->load($cid, $field);
        return $tbl_group;
    }
    
    function loadGroup($conditions,$field = "*", $orderby = "" ){
        $tbl_group = YiiTables::getInstance(TBL_USERS_GROUP);
        $item = $tbl_group->loadRow($field, $conditions, "", $orderby);
        return $tbl_group;
    }
    
    function loadUser($conditions,$field = "*", $orderby = "" ){
        $tbl_user = YiiTables::getInstance(TBL_USERS);
        $item = $tbl_user->loadRow($field, $conditions, "", $orderby);
        return $tbl_user;
    }
            
    function login($username = "", $password = "", $remember = false){}
    
    function logout($cid){}
    
    function isLogin($cid = null){}
    
    function isLogout($cid = null){}
    
    function isAdmin($cid = null){}
    
    function isLeader($cid = null){ }
    
    function checkPermistion($arr_url){ }
    
    function removeGroup($id = null, $condition = ""){
        $table = YiiTables::getInstance(TBL_USERS_GROUP);
        $table->remove($id, $condition);
    }
    
    function removeUser($id = null, $condition = ""){
        $table = YiiTables::getInstance(TBL_USERS);
        $table->remove($id, $condition);
    }
}
