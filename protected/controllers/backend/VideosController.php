<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VideosController extends BackEndController {

    private $film_model;
    private $category;

    function init() {
        parent::init();
        yii::import('application.models.backend.medias.*');
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
            YiiMessage::raseSuccess("Successfully saved changes video(s)");
        }
        
        $this->addIconToolbar("New", $this->createUrl("/videos/new"), "new");
        $this->addIconToolbar("Edit", $this->createUrl("/videos/edit"), "edit", 1, 1, "Please select a item from the list to edit");        
        $this->addIconToolbar("Publish", $this->createUrl("/videos/publish"), "publish");
        $this->addIconToolbar("Unpublish", $this->createUrl("/videos/unpublish"), "unpublish");
        $this->addIconToolbar("Delete", $this->createUrl("/videos/remove"), "trash", 1, 1, "Please select a item from the list to Remove");        
        $this->addBarTitle("Videos <small>[manager]</small>", "user"); 
            
        $data = array();
            
        $model = Video::getInstance();
        $items = $model->getItems(); 
        $data["items"] = $items;
        $this->render('default', $data);
    }
    
    public function actionNew() {
        $this->actionEdit();
    }
    
    public function actionEdit() {
        $cid = Request::getVar('cid', "");        
        setSysConfig("sidebar.display", 0);
        
        $this->addIconToolbar("Save", $this->createUrl("/videos/save"), "save");
        $this->addIconToolbar("Apply", $this->createUrl("/videos/apply"), "apply");
        $this->addBarTitle("Video <small>[Edit]</small>", "user");
        $this->addIconToolbar("Close", $this->createUrl("/videos/cancel"), "cancel");
        $this->pageTitle = "Edit video";           
        
        
        $model = Video::getInstance();
        $item = $model->getItem($cid);
        $list = $model->getListEdit($item);
        
        $this->render('edit', array("item" => $item, "list"=>$list));
    }

    function actionApply() {
        $cid = $this->store();
        $this->redirect($this->createUrl('videos/edit') . "?cid=" . $cid);
    }
    
    function actionSave() {
        $cid = $this->store();
        $this->redirect($this->createUrl('videos/'));
    }
    
    function actionCancel()
    {
        $this->redirect($this->createUrl('videos/'));
    }
    
    public function store() {
        global $mainframe;
        
        $cid = Request::getVar("id", 0); 
        
        $obj = YiiTables::getInstance(TBL_VIDEOS);        
        $obj = $obj->load($cid); 
        
        $obj->bind($_POST);           
       
        $obj->store();
 
        YiiMessage::raseSuccess("Successfully save Category");
        return $obj->id;
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
        $this->redirect($this->createUrl('videos/'));
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
        $this->redirect($this->createUrl('videos/'));
    }

    function changeStatus($cid, $value)
    {
        $obj = YiiTables::getInstance(TBL_VIDEOS);   
        $obj->load($cid); 
        $obj->status = $value;
        $obj->store();
    }
    function changeFeature($cid, $value)
    {
        $obj = YiiTables::getInstance(TBL_VIDEOS);   
        $obj->load($cid); 
        $obj->feature = $value;
        $obj->store();
    }
    
    function actionRemove()
    {
        $cids = Request::getVar("cid", 0);
        $table = YiiTables::getInstance(TBL_VIDEOS);
       
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){
                $cid = $cids[$i];
                //check item first
                $table->remove($cid);
            }
        }
        YiiMessage::raseSuccess("Successfully remove Video(s)");
        $this->redirect($this->createUrl('videos/'));
    }
}
