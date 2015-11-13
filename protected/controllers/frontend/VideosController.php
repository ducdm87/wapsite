<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VideosController extends FrontEndController {

    public $item = array();
    private $category;
    private $post;
    private $media;

    function init() {
        parent::init();       
       
       // $this->category = Category::getInstance();
        //$this->post = Post::getInstance();
        $this->media = Media::getInstance();
    }

    // trang chu video
    public function actionDisplay() {
         
    }

    // danh muc video
    function actionCategory(){
        $model = Video::getInstance();
        
        $catAlias = Request::getVar('alias',null);
        $currentPage = Request::getVar('page',1);
        $limit = 12;
        
        $data['alias'] = $catAlias;
        $obj_category = $model->getCategory(null, $catAlias);
          
        if($obj_category == false){
            $this->redirect($this->createUrl("app/"));
        }
        if($currentPage == 1)
            $data['items'] = $model->getItems($obj_category['id'], true,5);
        $start = ($currentPage - 1)*$limit;
        $data['items2'] = $model->getItems($obj_category['id'], false,$limit, $start);
       
        if($obj_category['total'] > $start  + $limit ){            
            $page = $currentPage + 1;
        }else $page = $currentPage - 1;
        $catAlias = $obj_category['alias'];
        
        if($page>1){            
            $obj_category['pagemore'] = Yii::app()->createUrl("videos/category", array("alias"=>$catAlias, "page"=>$page));
        }else if($page == 1)
            $obj_category['pagemore'] = Yii::app()->createUrl("videos/category", array("alias"=>$catAlias));
 
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
    
    // chi tiet video
    public function actionDetail() {
        $id = Request::getVar('id',null);
        $alias = Request::getVar('alias',null);

        $model =  Video::getInstance();
        if($id == null OR $id == ""){
            if($alias != null and $alias != ""){
                $obj_item = $model->getItemByAlias($alias);
            }else{
                header("Location: /");
            }
        }else{
            $obj_item = $model->getItem($id);
        }
        
        $items = $model->getItems($obj_item['catID'], true,4);
        $items2 = $model->getItems($obj_item['catID'], false,15);
        $obj_category = $model->getCategory($obj_item['catID']);
        
        $data['item'] = $obj_item;
        $data['items'] = $items;
        $data['items2'] = $items2;
        $data['category'] = $obj_category;
        
        $page_title = $obj_item['title'];        
        $page_keyword = $obj_item['metakey'] != ""?$obj_item['metakey']:$page_title;
        $page_description = $obj_item['metadesc'] != ""?$obj_item['metadesc']:$page_title;
        
        setSysConfig("seopage.title",$page_title); 
        setSysConfig("seopage.keyword",$page_keyword); 
        setSysConfig("seopage.description",$page_description);
        Request::setVar('alias',$obj_category['alias']);
        
        
        $this->render('detail', $data);
    }     
 
    // tang view khi play
    public function actionSetView() {
        $id = Request::getVar('id',null);
        $model = Video::getInstance();
        if ($res = $model->setView($id)) {
            $str_out = "var vsvcdpd = $res; $('.entry-viewed span').text(vsvcdpd) ";
            echo $str_out;
        } else {
            echo json_encode(FALSE);
        }
    }
    
    // like video
    function actionLikevideo(){
        $id = Request::getVar('id',null);
        $model = Video::getInstance();
        
        $like_videos = Yii::app()->session['like-video'];
        
        if($like_videos == null) $like_videos = array();
        if(isset($like_videos[$id])){
            $res = $model->get_readview($id);
        }else{
            $model = Video::getInstance();
            $res = $model->setLike($id);
        }
        
        $like_videos[$id] = $id;
        Yii::app()->session['like-video'] = $like_videos;        
        $str_out = "var vlvcdpd = $res; $('.entry-info .fa-thumbs-o-up').css('color','black') ";
        echo $str_out;
        die;
    }
}
