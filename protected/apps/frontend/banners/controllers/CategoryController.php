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

    public function actionBlog() {
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
        $this->render('blog', $params);
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
