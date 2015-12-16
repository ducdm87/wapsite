<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $YII_all_tables;
$YII_all_tables = array();


class YiiTables{
    var $_primary = 'id';
    var $_tablename = "{{menus}}";
    var $_message = "";
    var $_db = null;   
    
    
    function __construct($tbl_name, $primary = "id", $db) {
        $this->_tablename = $tbl_name;
        $this->_primary = $primary;
        
        $this->_db = $db;        
        if($this->_db == null) $this->_db = Yii::app()->db;
        
        $query = "SHOW COLUMNS IN $this->_tablename";
        $query = "DESCRIBE $this->_tablename";
        $query_command = $this->_db->createCommand($query);
        $fields = $query_command->queryColumn();
        foreach ($fields as $field){
            $this->$field = "";
        }
        $this->_message = '';
    }
    
    static function & getInstance($tbl_name, $primary = "id", $noCache = false, $db = null) {
        global $YII_all_tables;
        
        if($primary == null OR $primary == ""){
            $primary = "id";
        }
        
        if($noCache == false){
            $key_obj = md5($tbl_name . $primary);
            if(isset($YII_all_tables[$key_obj])) return $YII_all_tables[$key_obj];
            $obj_table = new YiiTables($tbl_name, $primary, $db);
            $YII_all_tables[$key_obj] = $obj_table;
            return $YII_all_tables[$key_obj];
        }else{
            $obj_table = new YiiTables($tbl_name, $primary, $db);
            return $obj_table;
        }
    }    
    
    function load($id, $field = "*", $returnstd = false){ 
        if ($id === 0 || $id == "") {
            return $this;
        }
        $id = trim($id);
        $query = "SELECT $field FROM $this->_tablename WHERE $this->_primary = :fieldvalue ";
        $query_command = $this->_db->createCommand($query);
        $query_command->bindParam(':fieldvalue', $id);

        $item = $query_command->queryRow();
        if($item == false){
            $this->_message = "Something error to load row width value: $id";
            return $this;
        }
        if($returnstd == false){
            foreach($item as $field => $field_value){
                $this->$field = $field_value;
            }
            return $this;
        }else{
            $obj = new stdClass();
            foreach($item as $field => $field_value){
                $obj->$field = $field_value;
            }
            return $obj;
        }
    }
    
    function loads($field = "*", $conditions = null, $orderBy = "", $limit = 10, $start = 0){
        if($orderBy == "" OR $orderBy == null){
            $pname = $this->_primary;
            if(isset($this->$pname))
                $orderBy = " $this->_primary DESC ";
        }
        $command = $this->_db->createCommand()->select($field)
                ->from($this->_tablename);
        
        if($conditions != null) $command->where($conditions);
        if($orderBy != null AND $orderBy != "") $command->order($orderBy);
        if($limit != null)$command->limit($limit, $start);
        
        $results = $command->queryAll();
        return $results;
    }
    
    function loadColumn($field = "id", $conditions = null, $orderBy = "", $limit = 10, $start = 0){
        if($orderBy == "" OR $orderBy == null){
            $pname = $this->_primary;
            if(isset($this->$pname))
                $orderBy = " $this->_primary DESC ";
        }
        $command = $this->_db->createCommand()->select($field)
                ->from($this->_tablename);
       
        if($conditions != null) $command->where($conditions);
        if($orderBy != null AND $orderBy != "") $command->order($orderBy);
        if($limit != null)$command->limit($limit, $start);
        
        $results = $command->queryColumn();
    
        return $results;
    }
    
    function loadRow($field = "id", $conditions = null, $orderBy = "" ){
        if($orderBy == "" OR $orderBy == null){
            $pname = $this->_primary;
            if(isset($this->$pname))
                $orderBy = " $this->_primary DESC ";
        }
        $command = $this->_db->createCommand()->select($field)
                ->from($this->_tablename);

        if($conditions != null) $command->where($conditions);
        if($orderBy != null AND $orderBy != "") $command->order($orderBy);
        
        $items = $command->queryRow();
        
        return $items;
    }
    
    function getTotal($conditions = null){
        $command = $this->_db->createCommand()->select("count(*)")
                ->from($this->_tablename);
        if($conditions != null) $command->where($conditions);
        $result = $command->queryScalar();
        return $result;
    }
    
    function bind($fromArray){
        foreach ($this as $field_name => $field_value) {            
            if(strpos($field_name, "_") === 0) continue;
           
            if (isset($fromArray[$field_name])){
                $this->$field_name = $fromArray[$field_name];
            }
        }
       
        return $fromArray;
    }
    
    function store(){
        $id = $this->{$this->_primary};
        if(isset($this->lft) AND isset($this->rgt) 
                AND isset($this->_old_parent)  AND isset($this->parentID)){
            $change_ordering = false;
             if($this->parentID == 0){
                $this->level = 1;            
                $item_parent = $this->loadRow("*","parentID = 0");
                $item_parent = (object) $item_parent;
                $parent_rgt = $item_parent->rgt;
                $this->parentID = $item_parent->id;
            }else{
                $item_parent = $this->load($this->parentID, "*", true);

                $this->level = $item_parent->level +1;
                $parent_rgt = $item_parent->rgt;           
            }
           
            if($id == 0 OR $this->_old_parent != $this->parentID){ // tao moi hoac thay doi parent
                $this->lft = $parent_rgt;
                $this->rgt = $this->lft + 1;
                $item_parent->rgt = $parent_rgt + 2;
                $change_ordering = true;
            }else if(isset ($this->_ordering) AND $this->_ordering != $id){ // xu ly thay doi trong khoi cua no
                $tbl_item2 = $this->load($this->_ordering, "*", true);;
                 
                $change_type = $this->lft>$tbl_item2->lft?2:-2;
                $min_lft = $this->lft<$tbl_item2->lft?$this->lft:$tbl_item2->lft;
                $max_rgt = $this->rgt>$tbl_item2->rgt?$this->rgt:$tbl_item2->rgt;

                $this->lft = $tbl_item2->lft;
                $this->rgt = $tbl_item2->rgt;

                $query = "UPDATE " . $this->_tablename
                        . " SET `lft` = `lft` + $change_type, `rgt` = `rgt` + $change_type "
                        . " WHERE `lft` >=  $min_lft AND `lft` < $max_rgt ";
 
                $this->lft = $tbl_item2->lft;
                $this->rgt = $tbl_item2->rgt;
                $query_command = $this->_db->createCommand($query);
                $query_command->execute();
            }
        }
        
        
        $insterted = array();
        foreach ($this as $field_name => $field_value) {
            if(strpos($field_name, "_") === 0) continue;
            $insterted[] = "`$field_name`=:$field_name";
        }
        $insterted = implode(",", $insterted); 
       
        $id = $this->{$this->_primary};
        
        $query = "";
        if ($id != 0) {
            if (isset($this->mdate))
                $this->mdate = date("Y-m-d H:i:s");
            $query = "UPDATE $this->_tablename SET " . $insterted . " WHERE $this->_primary = $id";
        } else {
            if (isset($this->cdate))
                $this->cdate = date("Y-m-d H:i:s");
            if (isset($this->mdate))
                $this->mdate = date("Y-m-d H:i:s");
            $query = "INSERT INTO $this->_tablename SET " . $insterted;
        }
        $query_command = $this->_db->createCommand($query);
        //$current_query = $query;
        foreach ($this as $field_name => $field_value) {
            if(strpos($field_name, "_") === 0) continue;
            $query_command->bindParam(':' . $field_name, $this->$field_name);
           // $current_query = str_replace(':' . $field_name, $this->$field_name, $current_query);
        }
        
        $query_command->execute();
        if ($id == 0)
            $id = $this->_db->lastInsertID;
         
        $this->{$this->_primary} = $id;
        
        if(isset($this->lft) AND isset($this->rgt) 
                AND isset($this->_old_parent)  AND isset($this->parentID)
                AND $change_ordering == true){
            $this->updateLftRgt($this->parentID);
        }
        
        return $this;
    }
    
    function updateLftRgt($id = 0)
    {  
         $obj_tbl = YiiTables::getInstance($this->_tablename,$this->_primary,true);

        $item2 = $obj_tbl->load($id);
        $itemParent = null;
        if($item2->parentID != 0){
            $obj_tbl = YiiTables::getInstance($this->_tablename,$this->_primary,true);
            $itemParent = $obj_tbl->load($item2->parentID);
        }
 
        $query = "UPDATE ".$this->_tablename." SET `rgt` = `rgt` + 2 WHERE `$this->_primary` =  $id ";
        $query_command = $this->_db->createCommand($query);
        $query_command->execute();         
        if($itemParent != null) {            
            $query = "UPDATE ".$this->_tablename." SET `lft` = `lft` + 2, `rgt` = `rgt` + 2 "
                        . " WHERE `lft`> " . $item2->rgt . " AND `lft` < " . $itemParent->rgt;
            $query_command = $this->_db->createCommand($query);
            $query_command->execute();                  
            $this->updateLftRgt($item2->parentID);
        }
    }
    
    
    function moveItem($id = null, $item = null, $new_parentID = null){
        if($id == null AND $item ==null ) return false;
        if($new_parentID == null) return false;
        if($item == null){
            $item = $this->load($id);
        }
    }
    
    function remove($id = null, $condition = "")
    {
        if($id == null OR $id == 0 or $id == ""){
            $id = $this->{$this->_primary};
        }
        
        if($id != null and $id != 0 and $id != ""){
            $query = "DELETE FROM $this->_tablename WHERE  $this->_primary = $id ";
            $query_command = $this->_db->createCommand($query);
            $query_command->execute();
            return true;
        }else if($condition != ""){
            $query = "DELETE FROM $this->_tablename WHERE $condition ";
            $query_command = $this->_db->createCommand($query);
            $query_command->execute();
            return true;
        }
        return false;
    }
}
