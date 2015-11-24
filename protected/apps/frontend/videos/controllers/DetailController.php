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
        $items2 = $model->getItems($obj_item['catID'], false,9);
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
        
        
        $this->render('default', $data);
    } 
}
