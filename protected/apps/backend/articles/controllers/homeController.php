<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HomeController extends BackendController {

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
        
        $this->addIconToolbar("New", Router::buildLink("articles",array('layout'=>'new')), "new");
        $this->addIconToolbar("Edit", Router::buildLink("articles",array('layout'=>'edit')), "edit", 1, 1, "Please select a item from the list to edit");        
        $this->addIconToolbar("Publish", Router::buildLink("articles",array('layout'=>'publish')), "publish");
        $this->addIconToolbar("Unpublish", Router::buildLink("articles",array('layout'=>'unpublish')), "unpublish");
        $this->addIconToolbar("Delete", Router::buildLink("articles",array('layout'=>'remove')), "trash", 1, 1, "Please select a item from the list to Remove");        
        $this->addBarTitle("Articles <small>[manager]</small>", "user"); 
            
        $model = Article::getInstance();
        $items = $model->getItems();
        $data['lists'] = $model->getList();
        $data['items'] = $items;
        $this->render('default', $data);
    }

    public function actionNew() {
        $this->actionEdit();
    }
    
    public function actionEdit($type = false) {
        
        $cid = Request::getVar('cid', "");        
        setSysConfig("sidebar.display", 0);
        
        $this->addIconToolbar("Save", Router::buildLink("articles",array('layout'=>'save')), "save");
        $this->addIconToolbar("Apply", Router::buildLink("articles",array('layout'=>'apply')), "apply");
        $this->addBarTitle("Article <small>[Edit]</small>", "user");
        $this->addIconToolbar("Close", Router::buildLink("articles",array('layout'=>'cancel')), "cancel");
        $this->pageTitle = "Edit article";     
        
        $model = Article::getInstance();
        $item = $model->getItem($cid);
        
         global $user;

         if(!$bool = $user->modifyChecking($item->created_by)){            
            $obj_users = YiiUser::getInstance();
            $item_user = $obj_users->getUser($item->created_by);
            YiiMessage::raseNotice("Your account not have permission to edit resource of: $item_user->username");
            $this->redirect(Router::buildLink("articles"));
            return false;
        }
        
        
        $data['item'] = $item;
        $data['list'] = $model->getListEdit($item);;
        
        $this->render('edit', $data);
    }
    
    
    function actionApply() {
        $cid = $this->store();
        YiiMessage::raseSuccess("Successfully save Article");
        $this->redirect(Router::buildLink("articles",array('layout'=>'edit','cid'=>$cid)));
    }
    
    function actionSave() {
        $cid = $this->store();
        YiiMessage::raseSuccess("Successfully save Article");
        $this->redirect(Router::buildLink("articles"));
    }
    
    function actionCancel()
    {
        $this->redirect(Router::buildLink("articles"));
    }
    
    public function store() {
        global $mainframe, $user;
        
        $cid = Request::getVar("id", 0); 
        
        $obj_table = YiiArticle::getInstance();
       
        $obj_table = $obj_table->loadItem($cid); 
    
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
               $this->redirect(Router::buildLink("articles"));
               return false;
           }
        }
        $obj_table->modified_by = $user->id;
        
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
        $this->redirect(Router::buildLink("articles"));
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
        $this->redirect(Router::buildLink("articles"));
    }
    
    function actionRemove()
    {
        global $user;
        $cids = Request::getVar("cid", 0);
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){
               $cid = $cids[$i];
               $obj_article = YiiArticle::getInstance();               
               $obj_table = $obj_article->loadItem($cid);
 
                if(!$bool = $user->modifyChecking($obj_table->created_by)){
                    $obj_users = YiiUser::getInstance();
                    $item_user = $obj_users->getUser($obj_table->created_by);
                    YiiMessage::raseNotice("Your account not have permission to delete article: $obj_table->title");
                    $this->redirect(Router::buildLink("articles"));
                    return false;
                }
               
               $obj_table->remove($cid);
            }
        }
        YiiMessage::raseSuccess("Successfully delete Article(s)");
        $this->redirect(Router::buildLink("articles"));
    }

    function changeStatus($cid, $value)
    {
        $obj_table = YiiArticle::getInstance();
        $obj_table = $obj_table->loadItem($cid);
       
        // check quyen so huu
        global $user;
        if(!$bool = $user->modifyChecking($obj_table->created_by)){
           $obj_users = YiiUser::getInstance();
           $item_user = $obj_users->getUser($obj_table->created_by);
           YiiMessage::raseNotice("Your account not have permission to modify resource of: $item_user->username");
           $this->redirect(Router::buildLink("articles"));
           return false;
       }
           
        
        $obj_table->status = $value;
        $obj_table->store();
    }
    
    function changeFeature($cid, $value)
    {
        $obj_table = YiiArticle::getInstance();
        $obj_table = $obj_table->loadItem($cid);
       
        // check quyen so huu
        global $user;
        if(!$bool = $user->modifyChecking($obj_table->created_by)){
           $obj_users = YiiUser::getInstance();
           $item_user = $obj_users->getUser($obj_table->created_by);
           YiiMessage::raseNotice("Your account not have permission to modify resource of: $item_user->username");
           $this->redirect(Router::buildLink("articles"));
           return false;
       }
        $obj_table->feature = $value;
        $obj_table->store();
    }
    
}
