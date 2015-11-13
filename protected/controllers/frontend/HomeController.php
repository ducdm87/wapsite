<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HomeController extends FrontEndController {

    public $item = array();
    private $category;
    private $post;
    private $media;

    function init() {
        parent::init();
    }

    public function actionDisplay() {         
        $model_videos = Video::getInstance();
        $model_article = Article::getInstance();
         
        $data["items_videos"] = $model_videos->getVideos(5);        
        $data["items_news"] = $model_article->getLastNews(5); 
       // $data['news'] = $list_category;              
        
        setSysConfig("seopage.title","wapsite - trang tổng hợp video, tin tức mới nhất"); 
        setSysConfig("seopage.keyword","wapsite, tổng hợp video, tin tức mới nhất"); 
        setSysConfig("seopage.description","wapsite - trang tổng hợp video, tin tức mới nhất"); 
        
        $this->render('default', $data);        
    }
}
