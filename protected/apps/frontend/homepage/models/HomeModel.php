<?php

class HomeModel {

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
            $instance = new HomeModel();
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
                        ->from(TBL_ARTICLES ." A")
                        ->leftJoin(TBL_CATEGORIES . " B", "A.catID = B.id")
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
     * trang chu
     * $listid: danh sach id chuyen muc
	*/
    function getVideos($limit = 5, $listid = ""){
        global $mainframe, $db;
        $where = " "; 
        if($listid != ""){ $where .= " AND id in($listid) "; }
        
        $query = "SELECT * FROM " . TBL_CATEGORIES 
                    ." WHERE status = 1 AND `scope` ='videos' "
                   ." ORDER BY ordering ASC";
        $query_command = $db->createCommand($query);
        $items = $query_command->queryAll();
          
        $arr_new = array();
         for($i=0;$i<count($items);$i++){
             $item = $items[$i];
             $params = array("view"=> "category","id" =>$item['id'], "alias"=>$item['alias']);
             $item['link'] = Router::buildLink('videos', $params);    
             $item['videos'] = $this->getVideoCategoy($item['id'],0, $limit);
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
    
    function getVideoCategoy($catID, $start = 0, $limit = 10)
    {
        global $mainframe, $db;
        $list_ids = getListObjectID("videos");

        $where = array();
        $where[] = "A.status = 1";
        $where[] = "B.status = 1";
        $where[] = "A.catID = $catID ";
        if($list_ids != false and $list_ids != ""){
        	$where[] = "A.id not in($list_ids)";
        }
        $where = implode(" AND ",$where);
        $query = "SELECT A.*, B.alias cat_alias, B.title cat_title "
                    ."FROM " . TBL_VIDEOS 
                             . " A LEFT JOIN ". TBL_CATEGORIES . " B ON A.catID = B.id "
                    ." WHERE  $where "
                   ." ORDER BY A.cdate DESC LIMIT $start, $limit";
        $query_command = $db->createCommand($query);
        $items = $query_command->queryAll();
        
        if(count($items))
            foreach($items as &$item){
                $params = array("view"=> "detail","id" => $item['id'], "alias" => $item['alias'],"catID" => $item['catID'], "cat_alias"=>$item['cat_alias']);
                $item['link'] = Router::buildLink('videos', $params);    
                addObjectID($item['id'], "video");
            }
        
        return $items;
    } 
}
