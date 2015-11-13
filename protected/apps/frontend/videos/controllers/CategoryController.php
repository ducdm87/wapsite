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
        $model = Video::getInstance();
       
        $catAlias = Request::getVar('alias',null);
        $catID = Request::getVar("id");
        $currentPage = Request::getVar('page',1);
        $limit = 12;
         
        $data['alias'] = $catAlias;
        $obj_category = $model->getCategory($catID, $catAlias);
        
        if($obj_category == false){
            $this->redirect($this->createUrl("videos/"));
        }
        if($currentPage == 1)
            $data['items'] = $model->getItems($obj_category['id'], true,5);
        $start = ($currentPage - 1)*$limit;
        $data['items2'] = $model->getItems($obj_category['id'], false,$limit, $start);
       
        if($obj_category['total'] > $start  + $limit ){            
            $page = $currentPage + 1;
        }else $page = $currentPage - 1;
        $catAlias = $obj_category['alias'];
        
        $params = array("view"=> "category","id" =>$obj_category['id'], "alias"=>$obj_category['alias'], "page"=>$page);
        $obj_category['pagemore'] = Router::buildLink('videos', $params);
 
        $page_title = $obj_category['title'];
        if($currentPage > 1) $page_title = $page_title . " trang $currentPage";
        $page_keyword = $obj_category['metakey'] != ""?$obj_category['metakey']:$page_title;
        $page_description = $obj_category['metadesc'] != ""?$obj_category['metadesc']:$page_title;
        
        setSysConfig("seopage.title",$page_title); 
        setSysConfig("seopage.keyword",$page_keyword); 
        setSysConfig("seopage.description",$page_description);
        
        $data['category'] = $obj_category;
        $this->render('blog', $data);
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
