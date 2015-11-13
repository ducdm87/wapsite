<?php

class ArticlesController extends FrontEndController {

    private $category;
    private $post;

    function init() {
        parent::init();
        // yii::import('application.models.frontend.*');
        $this->category = Category::getInstance();
        $this->post = Article::getInstance();
    }
    
    // trang chu tin tuc
    public function actionDisplay() {
        $model = Article::getInstance();
        $params["items"] = $model->getTinTuc();
         
        $page_title = "wapsite - trang tin tức tổng hợp nhanh nhất";
        
        setSysConfig("seopage.title",$page_title); 
        setSysConfig("seopage.keyword",$page_title); 
        setSysConfig("seopage.description",$page_title);
        
        $this->render('default', $params);
    } 
    
    // trang chuyen muc
    public function actionCategory() { 
        $model = Article::getInstance();
        
        $catAlias = Request::getVar('alias',null);
        $currentPage = Request::getVar('page',1);
         
        $limit = 12;
        
        $data['alias'] = $catAlias;
        $obj_category = $model->getCategory(null, $catAlias);
        if($obj_category == false){
            $this->redirect($this->createUrl("articles/"));
        }
        
        $start = ($currentPage - 1)*$limit;
        $obj_category['items'] = $model->getArticlesCategoy($obj_category['id'],$start, $limit);
        if($obj_category['total'] > $start  + $limit ){            
            $page = $currentPage + 1;
        }else $page = $currentPage - 1;
        $catAlias = $obj_category['alias'];

        if($page>1){
            
            $obj_category['pagemore'] = Yii::app()->createUrl("articles/category", array("alias"=>$catAlias, "page"=>$page));
        }elseif($page == 1)
            $obj_category['pagemore'] = Yii::app()->createUrl("articles/category", array("alias"=>$catAlias));
        
        $page_title = $obj_category['title'];
        if($currentPage > 1) $page_title = $page_title . " trang $currentPage";
        $page_keyword = $obj_category['metakey'] != ""?$obj_category['metakey']:$page_title;
        $page_description = $obj_category['metadesc'] != ""?$obj_category['metadesc']:$page_title;
        
        setSysConfig("seopage.title",$page_title); 
        setSysConfig("seopage.keyword",$page_keyword); 
        setSysConfig("seopage.description",$page_description);
        
        $data['category'] = $obj_category;
        
        $this->render('category', $data);
    }

    // trang chi tiet
    public function actionDetail() {

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
        
        
        $this->render('detail', $data);
    }

}
