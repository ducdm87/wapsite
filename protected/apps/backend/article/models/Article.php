<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Article extends CFormModel {

    private $table = "{{articles}}";
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
            $instance = new Article ();
        }
        return $instance;
    }
    
    function getItems($limit = 20, $start = 0, $where = array()){
        global $user;
        $obj_table = YiiArticle::getInstance();
        
        $filter_created_by = Request::getVar('filter_created_by', $user->id);
        $filter_state = Request::getVar('filter_state', -2);
        $conditions = "";
        $where = array();
        if($filter_state == 2){ $where [] = " A.feature = 1 ";}
        else if($filter_state != -2){  $where [] = " A.status = $filter_state "; }
        
        if($filter_created_by != -2){
             $where [] = " A.created_by = $filter_created_by ";
        }else{
            $obj_user = new YiiUser();
            $all_user = $obj_user->getUserInGroup($user->groupID, 'id', true);
            $all_user = implode(",", $all_user);
            $where [] = " A.created_by IN($all_user) ";
        }
        
        if(count($where) >0) $conditions = implode (" AND ", $where);
        $items = $obj_table->getItems(null, $conditions , $orderBy ="A.id desc", $limit, $start);
        return $items;
    }
    
    function getList()
    {
        global $user;
        $list = array();
        
        $filter_created_by = Request::getVar('filter_created_by', $user->id);
        $filter_state = Request::getVar('filter_state', -2);
        
        $obj_user = new YiiUser();
        $all_user[] = array("value"=>-2, "text"=>"- Select User -");
        //$all_user = array_merge($all_user, $obj_user->getUsers(null, 'id value, username text'));
        $all_user = array_merge($all_user, $obj_user->getUserInGroup($user->groupID, 'id value, username text', true));
        $list['filter_created_by'] = buildHtml::select($all_user, $filter_created_by, "filter_created_by",  "filter_created_by", "onchange=\"document.adminForm.submit();\"");
         
        $items = array();
        $items[] = array("value"=>-2, "text"=>"- Select state -");
        $items[] = array("value"=>0, "text"=>"Unpublish");
        $items[] = array("value"=>1, "text"=>"Publish");
        $items[] = array("value"=>2, "text"=>"Featured");
        $list['filter_state'] = buildHtml::select($items, $filter_state, "filter_state", "filter_state", "onchange=\"document.adminForm.submit();\"");
         
         
        return $list;
    }
    
    
    public function getItem($cid){
        $obj_table = YiiArticle::getInstance();
        $result = $obj_table->loadItem($cid);        
        return $result;
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

    public function deleteRecord($id) {
        $transaction = $this->connection->beginTransaction();
        try {
            $this->command->delete($this->table, 'id=:id', array('id' => $id));

            return $transaction->commit();
            ;
        } catch (Exception $e) {
            Yii::log('Eror!: ' + $e->getMessage());

            return $transaction->rollback();
            ;
        }
    }

}
