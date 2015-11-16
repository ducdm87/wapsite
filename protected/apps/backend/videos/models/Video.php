<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Video extends CFormModel {

    private $table = "{{videos}}";
    private $table_episode = "{{episode}}";
    private $table_categories = "{{categories}}";
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
            $instance = new Video();
        }
        return $instance;
    }
  

    public function getItems($limit = 10, $start = 0, $where = array()) {
         $field = "A.*, B.title cat_title, B.alias cat_alias";
        $command = Yii::app()->db->createCommand()->select($field)
                ->from(TBL_VIDEOS ." A")
                ->leftJoin(TBL_CATEGORIES ." B", "A.catID = B.id");
        
        $command->order("id desc");
        if($limit != null)$command->limit($limit, $start);
        
        $results = $command->queryAll();
        
        return $results;
    }

    public function getItem($cid){
        $obj = YiiTables::getInstance(TBL_VIDEOS);        
        $obj->load($cid);
        return $obj;
    }
    
    public function getListEdit($mainItem)
    {
        $list = array();

        $obj_module = YiiCategory::getInstance();
        $items = $obj_module->loadItems('id value, title text');
        $list['category'] = buildHtml::select($items, $mainItem->catID, "catID","","size=7");
         
        $items = array();
        $items[] = array("value"=>0, "text"=>"Unpublish");
        $items[] = array("value"=>1, "text"=>"Publish");
        $items[] = array("value"=>-1, "text"=>"Hidden");
        $list['status'] = buildHtml::select($items, $mainItem->status, "status");
        
        $items = array();
        $items[] = array("value"=>0, "text"=>"Disable");
        $items[] = array("value"=>1, "text"=>"Enable");        
        $list['feature'] = buildHtml::select($items, $mainItem->feature, "feature");        
        return $list;
    }

}
