<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MenuType extends CFormModel {

    private $table = '{{menus}}';
    private $command;
    private $connection;
    private $item = array();
    private $items = array();

    function __construct() {
        $this->command = Yii::app()->db->createCommand();
        $this->connection = Yii::app()->db;
        
        $this->item["id"]   =  0;
        $this->item["title"]   =   "";
        $this->item["alias"]   =   "";
        $this->item["description"]   =   "";
        $this->item["status"]   =   1;
        $this->item["cdate"]   =   "";
        $this->item["mdate"]   =   "";
    }
    
    static function getInstance(){
        static $instance;

        if (!is_object($instance)) {
            $instance = new MenuType();
        }
        return $instance;
    } 
    
    /**
     * 
     * @param type $limit
     * @param type $offset
     * @param type $where
     * @param type $or_where
     * @param type $order
     * @param type $by
     * @param type $query 
     */
    public function getMenuTypes($limit = 5, $offset = 0, $where = array(), $query = false, $or_where = false, $order = false, $by = false) {

        if ($limit > 0) {
            $this->command->limit($limit, $offset);
        }

        if ($where && is_array($where)) {
            foreach ($where as $key => $value) {
                if (!is_array($value)) {
                    $this->command->where($key, $value);
                } else {
                    foreach ($value as $k => $v) {
                        $this->command->where($k, $v);
                    }
                }
            }
        }
        $results = $this->command->select('*')
                ->from($this->table)
                ->queryAll();

        return $results;
    }

    public function getMenuType()
    {
        
    }
    
    public function getServiceById($id) {
        $result = $this->command->select('*')
                ->from($this->table)
                ->where('id=:id',array('id'=>$id))
                ->queryRow();

        return $result;
    }

    
    public function getCountTotal(){
         $results = $this->command->select('*')
                ->from($this->table)
                ->queryAll();
         
        return count($results);
        
    }
    
    
}
