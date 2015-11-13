<?php

class CategoryController extends FrontEndController {

    public $item = array();
    public $tablename = "{{gx_info}}";
    public $primary = "id";
    public $scopenews = "tin-kinh-te";

    function init() {
//        $this->layout = "//benhvienphusan/default";
        parent::init();
    } 

    function actionDisplay(){
        $this->actionBlog();
    }
    public function actionBlog() {
        $model = Article::getInstance();
         
        $catAlias = Request::getVar('alias',null);
        $currentPage = Request::getVar('page',1);
        
        $limit = 12;
        
        $data['alias'] = $catAlias;
        $catID = Request::getVar("id");
        
        $obj_category = $model->getCategory($catID, $catAlias);
         
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
         
        $this->render('default', $data);
    }
    
    public function actionList() {
        global $classSuffix;
        $classSuffix = "homepage";
        $this->pageTitle = "Giá xăng dầu hôm nay, gia xang dau";
        $this->metaKey = "giá xăng hôm nay, gia xang, gia xang dau, giá xăng, giá xăng hiện tại, giá xăng dầu hôm nay, gia xang hom nay, giá xăng dầu, giá xăng a92";
        $this->metaDesc = "Giá xăng hôm nay, cập nhật nhanh nhất bảng gia xang dau mới nhất, chính xác nhất, giá xăng hiện tại, giá xăng a92";
        $params = array();
        $model = Benhvienphusan::getInstance();
       
        $modelNews = News::getInstance();
         
        $params['giabanle'] = $model->getGiaBanLe();
        $params['giathegioi'] = $model->getGiaTheGioi();
//        $arrNews = $modelNews->getTinTuc($this->scopenews);
        $arrNews = $modelNews->getTinTuc("*", "1,8,19,3");
        $str_tintuc = "";
        $k=0;
        foreach ($arrNews as $dataCart) {
            if($k == 0) $str_tintuc .= "<div style='overflow: hidden;'>";
            $str_tintuc .= $modelNews->buildHtmlHome($dataCart);
            if($k == 1) $str_tintuc .= "</div>";
            $k = 1 - $k;
        }
        $params['tintuc'] = $str_tintuc;
        $this->render('list', $params);
    }
 

}
