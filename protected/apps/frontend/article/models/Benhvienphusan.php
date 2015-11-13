<?php

class Benhvienphusan {

    var $tablename = "{{xangdau}}";
    var $tbl_thegioi = "{{xangdau_thegioi}}";
    var $tbl_bieudo = "{{xangdau_bieudo}}";
    var $tbl_bando = "{{xangdau_bando}}";
    var $tbl_news_category = "{{categories}}";
    var $tbl_news_content = "{{news_content}}";
    var $str_error = "";
    var $str_return = "";
    var $return_data = "";
    var $arr_resumes = array();

    function __construct() {
        if(isset($_REQUEST['debug'])){
            $this->debug = $_REQUEST['debug'];
        }
    }

    static function getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new Benhvienphusan();
        }
        return $instance;
    }

    function getGiaBanLe() {
        global $mainframe, $db;
        $query = "SELECT * FROM " . $this->tablename . " WHERE status = 1 ORDER BY ordering ASC ";
        $query_command = $db->createCommand($query);
        $items = $query_command->queryAll();
        return$items;
    }
    function getGiaTheGioi() {
        global $mainframe, $db;
        $query = "SELECT * FROM " . $this->tbl_thegioi . " WHERE status = 1 ORDER BY ordering ASC ";
        $query_command = $db->createCommand($query);
        $items = $query_command->queryAll();
        return$items;
    }
    
    function getBieuDo()
    {
        global $mainframe, $db;
        $query = "SELECT * FROM " . $this->tbl_bieudo ." WHERE status = 1"
                   ." ORDER BY ordering ASC ";
        $query_command = $db->createCommand($query);
        $items = $query_command->queryAll();
        return $items;
    }
    
    function getBanDo()
    {
         global $mainframe, $db;
        $query = "SELECT * FROM " . $this->tbl_bando ." WHERE status = 1"
                   ." ORDER BY ordering ASC ";
        $query_command = $db->createCommand($query);
        $items = $query_command->queryAll();
        return $items;
    }
    
}
