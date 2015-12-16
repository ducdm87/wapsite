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
    private $_items = array();

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

    public function getItems($groupID = null) {
        $obj_user = YiiUser::getInstance();
        $cond = null;
        if($groupID != null){
            $group = $this->getItem($groupID);
            if($group->parentID > 1)
                $cond = " lft >=  $group->lft AND rgt <= $group->rgt ";
        }       
        $groups = $obj_user->getGroups($cond);
        $arr_new = array();
        foreach ($groups as $group) {
            $arr_new[$group['id']] = $group;
        }
        $groups = $arr_new;
        
        return $groups;
    }
    
    function getItem($cid = null)
    {
        if($cid == null OR $cid == "")
            $cid = Request::getVar("cid", 0);
        
        if (is_array($cid))
            $cid = $cid[0];
        if(isset($this->_items[$cid])) return $this->_items[$cid];
        
        $obj_user = YiiUser::getInstance();
        $tbl_group = $obj_user->getGroup($cid);
        $this->_items[$cid] = $tbl_group;
        return $tbl_group;
    }
    
    function getGranted(){
        $cid = Request::getVar('cid',0);
        $obj_res_xref = YiiTables::getInstance(TBL_RSM_RESOURCE_XREF);
        $items = $obj_res_xref->loads("*"," object_type = 2 AND objectID = $cid");        
        if(count($items)){
            $arr_new = array();
            $arr_new['allow'] = array();
            $arr_new['deny'] = array();
            foreach($items as $item){
                if($item['value'] == 1)
                    $arr_new['allow'][$item['resourceID']] = $item['resourceID'];
                else $arr_new['deny'][$item['resourceID']] = $item['resourceID'];
            }
            $items = $arr_new;
        }
        return $items;
    }
    
    function getListEdit($main_item)
    {
        $cid = Request::getVar("cid", 0);
        $lists = array();
        
        $items = array();
 
        $obj_user = YiiUser::getInstance();
        $condition = ""; 
        if($main_item ->id != 0){
            $condition = "(`lft` <" . $main_item->lft . " OR `lft` > ". $main_item->rgt .")";
        }
        
            $results = $obj_user->getGroups($condition, 'id value, name text, level');
            $items = array_merge($items, $results);      
            $lists['parentID'] = buildHtml::select($items, $main_item->parentID, "parentID","","size=10", "&nbsp;&nbsp;&nbsp;","-");
        
        
        $items = array();
        if($main_item ->id != 0){
            $condition = "parentID = ". $main_item->parentID;
            $results = $obj_user->getGroups($condition, 'id value, name text, level');
            $items = array_merge($items, $results);
            $lists['ordering'] = buildHtml::select($items, $cid, "ordering","","size=5");
        }else{
            $lists['ordering'] = "Ordering this item after save first";
        }
        
        $items_status = array();
        $items_status[] = array(-1,'Default','danger');
        $items_status[] = array(1,'Allow','success');
        $items_status[] = array(0,'Deny','danger');
        $lists['item_status'] = $items_status;
        
        $table_ext = YiiTables::getInstance(TBL_EXTENSIONS);                
        $lists['ext_default_1'] = $table_ext->loadColumn("name", "allowall = 1 ");
         return $lists;
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
