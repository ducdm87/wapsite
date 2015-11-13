<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CategoriesController extends BackEndController {
 
    var $tablename = "{{categories}}";
    var $tbl_menu = '{{categories}}';
    var $primary = 'id';
    var $item = null;

    function init() {
        parent::init();
        yii::import('application.models.backend.category.*');
    }

    public function actionDisplay() {
        
        $task = Request::getVar('task', "");
        if ($task != "") {
            $cids = Request::getVar('cid');            
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i];
                if ($task == "publish")
                    $this->changeStatus ($cid, 1);
                else if ($task == "hidden")
                    $this->changeStatus ($cid, 2);
                elseif($task == "unpublish") $this->changeStatus ($cid, 0);
                else if($task == "feature.on") $this->changeFeature ($cid, 1);
                else if($task == "feature.off") $this->changeFeature ($cid, 0);
            }
            YiiMessage::raseSuccess("Successfully saved changes category(s)");
        }
        
        
        $this->addIconToolbar("Creat", $this->createUrl("/categories/new"), "new");
        $this->addIconToolbar("Edit", $this->createUrl("/categories/edit"), "edit", 1, 1, "Please select a item from the list to edit");        
        $this->addIconToolbar("Publish", $this->createUrl("/categories/publish"), "publish");
        $this->addIconToolbar("Unpublish", $this->createUrl("/categories/unpublish"), "unpublish");
        $this->addIconToolbar("Delete", $this->createUrl("/categories/remove"), "trash", 1, 1, "Please select a item from the list to Remove");        
        $this->addBarTitle("Categories <small>[manager]</small>", "user");   
        
        $model = Categories::getInstance();
        $items = $model->getItems();
        
        $this->render('default', array("items" => $items));
    }
 
    public function actionNew() {
        $this->actionEdit();
    }

    public function actionEdit() {
        $cid = Request::getVar('cid', "");        
        setSysConfig("sidebar.display", 0);
        
        $this->addIconToolbar("Save", $this->createUrl("/categories/save"), "save");
        $this->addIconToolbar("Apply", $this->createUrl("/categories/apply"), "apply");
        
        if ($cid == 0) {
            $this->addBarTitle("Category <small>[New]</small>", "user");        
            $this->pageTitle = "New menu item";
            $this->addIconToolbar("Cancel", $this->createUrl("/categories/cancel"), "cancel");        
        }else{
            $this->addBarTitle("Category <small>[Edit]</small>", "user");        
            $this->pageTitle = "Edit menu item";
            $this->addIconToolbar("Close", $this->createUrl("/categories/cancel"), "cancel");
        }
        
        $obj = YiiCategory::getInstance();        
        $item = $obj->loadItem($cid, "*", false);
        $model = Categories::getInstance();
        $lists = $model->getListEdit($item);
        
        $this->render('edit', array("item" => $item, "lists"=>$lists));
    }

    function actionApply() {
        $cid = $this->store();
        $this->redirect($this->createUrl('categories/edit') . "?cid=" . $cid);
    }
    
    function actionSave() {
        $cid = $this->store();
        $this->redirect($this->createUrl('categories/'));
    }
    
    function actionCancel()
    {
        $this->redirect($this->createUrl('categories/'));
    }
    
    public function store() {
        global $mainframe;
        
        $cid = Request::getVar("id", 0); 
        
        $obj_category = YiiCategory::getInstance();        
        $obj_category = $obj_category->loadItem($cid, "*", false); 
         
        $obj_category->bind($_POST);           
        $obj_category->store(); 
 
        YiiMessage::raseSuccess("Successfully save Category");
        return $obj_category->id;
    }
    
    
     function actionPublish()
    {
        $cids = Request::getVar("cid", 0);        
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){
                $this->changeStatus($cids[$i], 1);
            }
        }
        YiiMessage::raseSuccess("Successfully publish Cateegory(s)");
        $this->redirect($this->createUrl('categories/'));
    }
    
    function actionUnpublish()
    {
        $cids = Request::getVar("cid", 0);        
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){                
                $this->changeStatus($cids[$i], 0);
            }
        }
        YiiMessage::raseSuccess("Successfully unpublish Cateegory(s)");
        $this->redirect($this->createUrl('categories/'));
    }
    
    function changeStatus($cid, $value)
    {
        $obj = YiiCategory::getInstance();        
        $obj = $obj->loadItem($cid, "*", false); 
        $obj->status = $value;
        $obj->store();
    }
    function changeFeature($cid, $value)
    {
        $obj = YiiCategory::getInstance();        
        $obj = $obj->loadItem($cid, "*", false); 
        $obj->feature = $value;
        $obj->store();
    }
}
