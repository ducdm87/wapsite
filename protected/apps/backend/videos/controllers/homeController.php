<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HomeController extends BackEndController {

    private $film_model;
    private $category;

    function init() {
        parent::init();
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
        
        $this->addIconToolbar("New", Router::buildLink("videos",array('layout'=>'new')), "new");
        $this->addIconToolbar("Edit", Router::buildLink("videos",array('layout'=>'edit')), "edit", 1, 1, "Please select a item from the list to edit");        
        $this->addIconToolbar("Publish", Router::buildLink("videos",array('layout'=>'publish')), "publish");
        $this->addIconToolbar("Unpublish", Router::buildLink("videos",array('layout'=>'unpublish')), "unpublish");
        $this->addIconToolbar("Delete", Router::buildLink("videos",array('layout'=>'remove')), "trash", 1, 1, "Please select a item from the list to Remove");        
        $this->addBarTitle("Videos <small>[manager]</small>", "user"); 
            
        $data = array();
            
        $model = Video::getInstance();
        $items = $model->getItems(); 
        $data['lists'] = $model->getList();
        $data["items"] = $items;
        $this->render('default', $data);
    }
    
    public function actionNew() {
        $this->actionEdit();
    }
    
    public function actionEdit() {
        $cid = Request::getVar('cid', "");        
        setSysConfig("sidebar.display", 0);
        
        $this->addIconToolbar("Save", Router::buildLink("videos",array('layout'=>'save')), "save");
        $this->addIconToolbar("Apply", Router::buildLink("videos",array('layout'=>'apply')), "apply");
        $this->addBarTitle("Video <small>[Edit]</small>", "user");
        $this->addIconToolbar("Close", Router::buildLink("videos",array('layout'=>'cancel')), "cancel");
        $this->pageTitle = "Edit video";           
        
        
        $model = Video::getInstance();
        $item = $model->getItem($cid);
        
        global $user;

         if(!$bool = $user->modifyChecking($item->created_by)){            
            $obj_users = YiiUser::getInstance();
            $item_user = $obj_users->getUser($item->created_by);
            YiiMessage::raseNotice("Your account not have permission to edit resource of: $item_user->username");
            $this->redirect(Router::buildLink("article"));
            return false;
        }
        
        $list = $model->getListEdit($item);
        
        $this->render('edit', array("item" => $item, "list"=>$list));
    }

    function actionApply() {
        $cid = $this->store();
         YiiMessage::raseSuccess("User save succesfully");
        $this->redirect(Router::buildLink("videos",array('layout'=>'edit','cid'=>$cid)));
    }
    
    function actionSave() {
        $cid = $this->store();
         YiiMessage::raseSuccess("User save succesfully");
        $this->redirect(Router::buildLink("videos"));
    }
    
    function actionCancel()
    {
        $this->redirect(Router::buildLink("videos"));
    }
    
    public function store() {
        global $mainframe;
        
        $cid = Request::getVar("id", 0); 
        
        $obj_table = YiiTables::getInstance(TBL_VIDEOS);        
        $obj_table = $obj_table->load($cid); 
        
        $obj_table->bind($_POST);           
       
        if($obj_table->id == 0){
            $obj_table->created_by = $user->id;
        }else{
            // check quyen so huu
            global $user;
            if(!$bool = $user->modifyChecking($obj_table->created_by)){
               $obj_users = YiiUser::getInstance();
               $item_user = $obj_users->getUser($obj_table->created_by);
               YiiMessage::raseNotice("Your account not have permission to modify resource of: $item_user->username");
               $this->redirect(Router::buildLink("article"));
               return false;
           }
        }
        $obj_table->modified_by = $user->id;
        $obj_table->store();
 
        YiiMessage::raseSuccess("Successfully save Video");
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
        YiiMessage::raseSuccess("Successfully publish Cateegory(s)");
        $this->redirect(Router::buildLink("videos"));
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
        $this->redirect(Router::buildLink("videos"));
    }

    function changeStatus($cid, $value)
    {
        $obj_table = YiiTables::getInstance(TBL_VIDEOS);   
        $obj_table->load($cid); 
        
        // check quyen so huu
        global $user;
        if(!$bool = $user->modifyChecking($obj_table->created_by)){
           $obj_users = YiiUser::getInstance();
           $item_user = $obj_users->getUser($obj_table->created_by);
 
           YiiMessage::raseNotice("Your account not have permission to modify resource of: $item_user->username");
           $this->redirect(Router::buildLink("article"));
           return false;
       }
        
        $obj_table->status = $value;
        $obj_table->store();
    }
    function changeFeature($cid, $value)
    {
        $obj_table = YiiTables::getInstance(TBL_VIDEOS);   
        $obj_table->load($cid); 
        
         // check quyen so huu
        global $user;
        if(!$bool = $user->modifyChecking($obj_table->created_by)){
           $obj_users = YiiUser::getInstance();
           $item_user = $obj_users->getUser($obj_table->created_by);
           YiiMessage::raseNotice("Your account not have permission to modify resource of: $item_user->username");
           $this->redirect(Router::buildLink("article"));
           return false;
       }
        
        $obj_table->feature = $value;
        $obj_table->store();
    }
    
    function actionRemove()
    {
        global $user;
         
        $cids = Request::getVar("cid", 0);
        $obj_table = YiiTables::getInstance(TBL_VIDEOS);
       
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){
                $cid = $cids[$i];
                $obj_table->load($cid);
 
                if(!$bool = $user->modifyChecking($obj_table->created_by)){
                    $obj_users = YiiUser::getInstance();
                    $item_user = $obj_users->getUser($obj_table->created_by);
                    YiiMessage::raseNotice("Your account not have permission to delete video: $obj_table->title");
                    $this->redirect(Router::buildLink("videos"));
                    return false;
                }
                //check item first
                $obj_table->remove($cid);
            }
        }
        YiiMessage::raseSuccess("Successfully remove Video(s)");
        $this->redirect(Router::buildLink("videos"));
    }
}
