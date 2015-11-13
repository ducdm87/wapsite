<?php

class Article {

    var $tablename = TBL_ARTICLES;
    var $tbl_category = TBL_CATEGORIES;   
    var $str_error = "";
    var $str_return = "";
    var $return_data = "";
    var $arr_resumes = array();

    function __construct() { 
    }

    static function getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new Article();
        }
        return $instance;
    }
    
    // trang chu goi den
    function getLastNews($limit = 10)
    {
        global $mainframe, $db;
        $list_ids = getListObjectID("article");
        
        $where = array();
        $where[] = "A.status = 1";
        $where[] = "B.status = 1";
        if($list_ids != false and $list_ids != ""){
        	$where[] = "A.id not in($list_ids)";
        }
        $where = implode(" AND ",$where);
        
        $query_command = Yii::app()->db->createCommand();
        $query_command->select("A.*, B.alias cat_alias, B.title cat_title")
                        ->from($this->tablename ." A")
                        ->leftJoin($this->tbl_category . " B", "A.catID = B.id")
                        ->where($where)
                        ->order("A.created DESC, A.ordering DESC")
                        ->limit($limit);
        $items = $query_command->queryAll();
        
        if(count($items))
            foreach($items as &$item){
                $params = array("view" =>"detail", "id" => $item['id'], "alias"=>$item['alias'],"catID" => $item['catID'], "cat_alias"=>$item['cat_alias']) ;
                $item['link'] = Router::buildLink('article', $params);                
                addObjectID($item['id'], "article");
            }
        return $items;
    }
    
    /*
     * trang tin tuc goi den
     * $listid: danh sach id chuyen muc
	*/
    function getTinTuc($scope = "article", $listid = "", $limit = 6){
        global $mainframe, $db;
        $where = array();
        $where[] = "status = 1";
        if($scope != "*"){
            $where[] = "`scope` = '$scope'";
            $where[] = "`alias` != 'uncategorised'";          
        }
        
        if($listid != ""){ $where[] = " id in($listid) "; }
        $where = implode(" AND ",$where);
        
        $query_command = Yii::app()->db->createCommand();
        $query_command->select("*")
                        ->from($this->tbl_category)                        
                        ->where($where)
                        ->order("ordering ASC")
                        ->limit($limit);
        $items = $query_command->queryAll();
        
        $arr_new = array();
         for($i=0;$i<count($items);$i++){
             $item = $items[$i];
             $params = array("view" =>"category", "id" => $item['id'], "alias"=>$item['alias']) ;
             $item['link'] = Router::buildLink('article', $params);             
             $item['items'] = $this->getArticlesCategoy($item['id'],0, $limit);
             $arr_new[$item['id']] = $item;
         }
         $items = $arr_new;
         
         if($listid != ""){
             $listid = explode(",", $listid);
             $arr_new = array();
             foreach ($listid as $k=>$id){
                 if(isset($items[$id]))
                    $arr_new[$id] = $items[$id];
             }
             $items = $arr_new;
         }
         
        return $items;
    }
 
    function getArticlesCategoy($catID, $start = 0, $limit = 10)
    {
        global $mainframe, $db;
        $list_idnews = getListObjectID("news");

        $where = array();
        $where[] = "A.status = 1";
        $where[] = "B.status = 1";
        $where[] = "A.catid = $catID ";
        if($list_idnews != false and $list_idnews != ""){
        	$where[] = "A.id not in($list_idnews)";
        }
        $where = implode(" AND ",$where);
        
        $query_command = Yii::app()->db->createCommand();
        $query_command->select("A.*, B.alias cat_alias, B.title cat_title")
                        ->from($this->tablename ." A")   
                        ->leftJoin($this->tbl_category . " B", "A.catID = B.id")
                        ->where($where)
                        ->order("A.created DESC, A.ordering DESC")
                        ->limit($limit, $start);
        $items = $query_command->queryAll();
        
        if(count($items))
            foreach($items as &$item){
                $params = array("view" =>"detail", "id" => $item['id'], "alias"=>$item['alias'],"catID" => $item['catID'], "cat_alias"=>$item['cat_alias']) ;
                $item['link'] = Router::buildLink('article', $params);
                addObjectID($item['id'], "news");
            }
        
        return $items;
    } 
    
    function getCategory($catID, $alias = null)
    {
        global $mainframe, $db;
        $obj_table = YiiTables::getInstance(TBL_CATEGORIES);
        $obj_content = YiiTables::getInstance(TBL_ARTICLES);
        
        if(intval($catID) >0 )
            $item = $obj_table->loadRow("*", " status = 1 AND `id` = $catID");
        else
            $item = $obj_table->loadRow("*", " status = 1 AND `alias` = '$alias'");
        
       if($item)
       {
           $params = array("view" =>"category", "id" => $item['id'], "alias"=>$item['alias']) ;
           $item['link'] = Router::buildLink('article', $params);           
           $item['total'] = $obj_content->getTotal(" status = 1 AND `catID` = ".$item['id']);
       }
        return $item;
    }
    
    function getItem($cid, $alias = null){
        global $mainframe, $db;
        
        $where = array();
        $where[] = "A.status = 1";
        $where[] = "B.status = 1";
        
        if(intval($cid) != 0){ $where[] = " A.id = $cid"; }
        else{ $where[] = " A.alias = '$alias'"; }

        $where = implode(" AND ", $where);
        $query_command = Yii::app()->db->createCommand();
        $query_command->select("A.*, B.alias cat_alias, B.title cat_title")
                        ->from($this->tablename ." A")   
                        ->leftJoin($this->tbl_category . " B", "A.catID = B.id")
                        ->where($where);
        
        $item = $query_command->queryRow();
        if($item == FALSE) return false;        
        $params = array("view" =>"category", "id" => $item['catID'], "alias"=>$item['cat_alias']) ;
        $item['cat_link'] = Router::buildLink('article', $params);        
       
        $params = array("view" =>"detail", "id" => $item['id'], "alias"=>$item['alias'], "catID" => $item['catID'], "cat_alias"=>$item['cat_alias']) ;
        $item['link'] = Router::buildLink('article', $params);
        addObjectID($item['id'], "article");
        return $item;
    } 
}
