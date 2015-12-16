<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Categories extends CFormModel {

    private $table = "{{categories}}";
    private $tbl_menu = '{{menus}}';
    private $primary = 'id';
    
    private $command;
    private $connection;

    function __construct() {
        parent::__construct();

        $this->command = Yii::app()->db->createCommand();
        $this->connection = Yii::app()->db;
    }

    static function getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new Categories();
        }
        return $instance;
    }
    
    public function getItems() {
        $obj_module = YiiCategory::getInstance();
        $items = $obj_module->loadItems();
        return $items;
    } 
    
     function getListEdit($mainitem){
         
    }
}

?> 