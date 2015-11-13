<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Group extends CFormModel {

    private $table = '{{users_group}}';
    private $command;
    private $connection;

    function __construct() {
        $this->command = Yii::app()->db->createCommand();
        $this->connection = Yii::app()->db;
    }
    
    static function getInstance(){
        static $instance;

        if (!is_object($instance)) {
            $instance = new Group();
        }
        return $instance;
    } 

    public function getItems() {
        $obj_user = YiiUser::getInstance();
        $groups = $obj_user->getGroups();
        $arr_new = array();
        foreach ($groups as $group) {
            $arr_new[$group['id']] = $group;
        }
        $groups = $arr_new;
        
        return $groups;
    }
    
    function getItem()
    {
        $cid = Request::getVar("cid", 0);
        
        if (is_array($cid))
            $cid = $cid[0];
        
        $obj_user = YiiUser::getInstance();
        $tbl_group = $obj_user->getGroup($cid);
        return $tbl_group;
    }
    
    function getListEdit($main_item)
    {
        $cid = Request::getVar("cid", 0);
        $list = array();
        
        $items = array();
 
        $obj_user = YiiUser::getInstance();
        $condition = ""; 
        if($cid != 0){
            $condition = "(`lft` <" . $main_item->lft . " OR `lft` > ". $main_item->rgt .")";
        }
        
            $results = $obj_user->getGroups($condition, 'id value, name text, level');
            $items = array_merge($items, $results);      
            $list['parentID'] = buildHtml::select($items, $main_item->parentID, "parentID","","size=10", "&nbsp;&nbsp;&nbsp;","-");
        
        
        $items = array();
        if($cid != 0){
            $condition = "parentID = ". $main_item->parentID;
            $results = $obj_user->getGroups($condition, 'id value, name text, level');
            $items = array_merge($items, $results);
            $list['ordering'] = buildHtml::select($items, $cid, "ordering","","size=5");
        }else{
            $list['ordering'] = "Ordering this item after save first";
        }
        
         return $list;
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    public function addGroup($data) {
        $transaction = $this->connection->beginTransaction();
        try {
            $this->command->insert($this->table, $data);
            $transaction->commit();
            return TRUE;
        } catch (Exception $exc) {
            Yii::log('Error! :', var_export($exc->getMessage()));
            $transaction->rollback();
            return false;
        }
    }

    /**
     * 
     * @param type $data
     * @return boolean
     */
    public function updateGroup($data) {
        $transaction = $this->connection->beginTransaction();
        try {
            $this->command->update($this->table, $data, 'id=:id', array('id' => $data['id']));
            $transaction->commit();
            return TRUE;
        } catch (Exception $exc) {
            Yii::log('Error! :', var_export($exc->getMessage()));
            $transaction->rollback();
            return false;
        }
    }

    public function deleteGroup($id) {
        $transaction = $this->connection->beginTransaction();
        try {
            $this->command->delete($this->table, 'id=:id', array('id' => $id));
            $transaction->commit();
            return TRUE;
        } catch (Exception $exc) {
            Yii::log('Error! :', var_export($exc->getMessage()));
            $transaction->rollback();
            return false;
        }
    }
    
    public function getGroupById($id){
        $result = $this->command->select('*')
                ->from($this->table)
                ->where('id=:id',array('id'=>$id))
                ->queryRow();

        return $result;
    }

}
