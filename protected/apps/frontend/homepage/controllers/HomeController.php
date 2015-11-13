<?php

class HomeController extends FrontEndController {

    public $item = array();
    public $tablename = "{{gx_info}}";
    public $primary = "id";
    public $scopenews = "tin-kinh-te";

    function init() {
        //$this->layout = "//benhvienphusan/default";
        parent::init();
    } 

    public function actionDisplay() {
        global $classSuffix, $db, $user, $mainframe;
         
        $model = HomeModel::getInstance();
        
        $data["items_videos"] = $model->getVideos(5);    
         
        $data["items_news"] = $model->getLastNews(5); 
       // $data['news'] = $list_category;              
        
        setSysConfig("seopage.title","wapsite - trang tổng hợp video, tin tức mới nhất"); 
        setSysConfig("seopage.keyword","wapsite, tổng hợp video, tin tức mới nhất"); 
        setSysConfig("seopage.description","wapsite - trang tổng hợp video, tin tức mới nhất"); 
        
        $this->render('default', $data);  
    }
}
