<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ArticlesController extends BackendController {

    function init() {
        parent::init();
        yii::import('application.models.backend.article.*');
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
            YiiMessage::raseSuccess("Successfully saved changes video(s)");
        }
        
        $this->addIconToolbar("New", $this->createUrl("/articles/new"), "new");
        $this->addIconToolbar("Edit", $this->createUrl("/articles/edit"), "edit", 1, 1, "Please select a item from the list to edit");        
        $this->addIconToolbar("Publish", $this->createUrl("/articles/publish"), "publish");
        $this->addIconToolbar("Unpublish", $this->createUrl("/articles/unpublish"), "unpublish");
        $this->addIconToolbar("Delete", $this->createUrl("/articles/remove"), "trash", 1, 1, "Please select a item from the list to Remove");        
        $this->addBarTitle("Articles <small>[manager]</small>", "user"); 
            
        $model = Article::getInstance();
        $items = $model->getItems();
        $data['items'] = $items;
        $this->render('default', $data);
    }

    public function actionNew() {
        $this->actionEdit();
    }
    
    public function actionEdit($type = false) {
        
        $cid = Request::getVar('cid', "");        
        setSysConfig("sidebar.display", 0);
        
        $this->addIconToolbar("Save", $this->createUrl("/articles/save"), "save");
        $this->addIconToolbar("Apply", $this->createUrl("/articles/apply"), "apply");
        $this->addBarTitle("Article <small>[Edit]</small>", "user");
        $this->addIconToolbar("Close", $this->createUrl("/articles/cancel"), "cancel");
        $this->pageTitle = "Edit article";     
        
        $model = Article::getInstance();
        $item = $model->getItem($cid);
        
        $data['item'] = $item;
        $data['list'] = $model->getListEdit($item);;
        
        $this->render('edit', $data);
    }
    
    
    function actionApply() {
        $cid = $this->store();
        $this->redirect($this->createUrl('articles/edit') . "?cid=" . $cid);
    }
    
    function actionSave() {
        $cid = $this->store();
        $this->redirect($this->createUrl('articles/'));
    }
    
    function actionCancel()
    {
        $this->redirect($this->createUrl('articles/'));
    }
    
    public function store() {
        global $mainframe;
        
        $cid = Request::getVar("id", 0); 
        
        $obj_table = YiiArticle::getInstance();
       
        $obj_table = $obj_table->loadItem($cid); 
    
        $obj_table->bind($_POST);
        $obj_table->store();
 
        YiiMessage::raseSuccess("Successfully save Article");
        return $obj_table->id;
    }    
    
     function actionPublish()
    {
        $cids = Request::getVar("cid", 0);        
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){
                $this->changeStatus($cids[$i], 1);
            }
        }
        YiiMessage::raseSuccess("Successfully publish Article(s)");
        $this->redirect($this->createUrl('article/'));
    }
    
    function actionUnpublish()
    {
        $cids = Request::getVar("cid", 0);        
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){                
                $this->changeStatus($cids[$i], 0);
            }
        }
        YiiMessage::raseSuccess("Successfully unpublish Article(s)");
        $this->redirect($this->createUrl('article/'));
    }
    
    function actionRemove()
    {
        $cids = Request::getVar("cid", 0);
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){                
               $obj_table = YiiArticle::getInstance();
               $obj_table->remove($cids[$i]);
            }
        }
        YiiMessage::raseSuccess("Successfully delete Article(s)");
        $this->redirect($this->createUrl('articles/'));
    }

    function changeStatus($cid, $value)
    {
        $obj_table = YiiArticle::getInstance();
        $obj_table = $obj_table->loadItem($cid); 
        $obj_table->load($cid); 
        $obj_table->status = $value;
        $obj_table->store();
    }
    
    function changeFeature($cid, $value)
    {
        $obj_table = YiiArticle::getInstance();
        $obj_table = $obj_table->loadItem($cid); 
        $obj_table->load($cid); 
        $obj_table->feature = $value;
        $obj_table->store();
    }
    
}
