<?php

class DetailController extends FrontEndController {

    public $item = array();
    public $tablename = "{{gx_info}}";
    public $primary = "id";
    public $scopenews = "tin-kinh-te";

    function init() {
//        $this->layout = "//benhvienphusan/default";
        parent::init();
    } 

    public function actionDisplay() {
        $cid = Request::getVar('id',null);
        $alias = Request::getVar('alias',null);
        $model = Article::getInstance();
        $obj_item = $model->getItem($cid, $alias);
        $obj_category = $model->getCategory($obj_item['catID']);
       
        $data['item'] = $obj_item;
        $data['category'] = $obj_category; 
        
        $page_title = $obj_item['title'];        
        $page_keyword = $obj_item['metakey'] != ""?$obj_item['metakey']:$page_title;
        $page_description = $obj_item['metadesc'] != ""?$obj_item['metadesc']:$page_title;
        
        setSysConfig("seopage.title",$page_title); 
        setSysConfig("seopage.keyword",$page_keyword); 
        setSysConfig("seopage.description",$page_description);
        
        
        $this->render('default', $data);
    } 
}
