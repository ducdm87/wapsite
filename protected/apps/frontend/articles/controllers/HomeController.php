<?php

class HomeController extends FrontEndController {

    public $item = array();
    public $tablename = "{{gx_info}}";
    public $primary = "id";
    public $scopenews = "tin-kinh-te";

    function init() { 
        parent::init();
    } 

    public function actionDisplay() {
        $model = Article::getInstance();
        $params["items"] = $model->getTinTuc();
         
        $page_title = "wapsite - trang tin tức tổng hợp nhanh nhất";
        
        setSysConfig("seopage.title",$page_title); 
        setSysConfig("seopage.keyword",$page_title); 
        setSysConfig("seopage.description",$page_title);
        
        $this->render('default', $params);
    }
}
