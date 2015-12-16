<?php

class ResourceController extends BackEndController {

    var $primary = 'id';
    var $tablename = "{{menus}}";
    var $tbl_menuitem = "{{menu_item}}";
    var $item = null;
    var $item2 = null;
    var $items = array();

    function init() {
        parent::init();
    }
    /*
     * For menu type
     */
    public function actionDisplay() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to visit page");
            $this->redirect(Router::buildLink("cpanel"));
        }
         $this->addIconToolbar("New", Router::buildLink("users",array('view'=>'resource','layout'=>'new')), "new");
        $this->addIconToolbar("Edit", Router::buildLink("users",array('view'=>'resource','layout'=>'edit')), "edit", 1, 1, "Please select a item from the list to edit");        
        $this->addIconToolbar("Publish", Router::buildLink("users",array('view'=>'resource','layout'=>'publish')), "publish");
        $this->addIconToolbar("Unpublish", Router::buildLink("users",array('view'=>'resource','layout'=>'unpublish')), "unpublish");
        $this->addIconToolbar("Delete", Router::buildLink("users",array('view'=>'resource','layout'=>'remove')), "trash", 1, 1, "Please select a item from the list to Remove");        
         $this->addBarTitle("Resource <small>[tree]</small>", "user"); 
         
         $model = Resource::getInstance();
         $items = $model->getItems();
         
        $this->render('default', array('items'=>$items));
    } 
    
    
    
    
     public function actionNew() {
        $this->actionEdit();
    }
    
    public function actionEdit($type = false) {
        
        $cid = Request::getVar('cid', "");
        if(is_array($cid)) $cid = $cid[0];
        setSysConfig("sidebar.display", 0);
        
        $this->addIconToolbar("Save", Router::buildLink("users",array('view'=>'resource','layout'=>'save')), "save");
        $this->addIconToolbar("Apply", Router::buildLink("users",array('view'=>'resource','layout'=>'apply')), "apply");
        $this->addBarTitle("Permission <small>[Edit]</small>", "user");
        $this->addIconToolbar("Close", Router::buildLink("users",array('view'=>'resource','layout'=>'cancel')), "cancel");
        $this->pageTitle = "Edit resource";     
        
        $model = Resource::getInstance();  
         
        $item = $model->getItem($cid);
        $data['lists'] = $model->getListEdit($item);  
        $data['item'] = $item; 
        
        $this->render('edit', $data);
    }
    
    
    function actionApply() {
        $cid = $this->store();
        YiiMessage::raseSuccess("Successfully save Permission");
        $this->redirect(Router::buildLink("users",array('view'=>'resource','layout'=>'edit','cid'=>$cid)));
    }
    
    function actionSave() {
        $cid = $this->store();
        YiiMessage::raseSuccess("Successfully save Permission");
        $this->redirect(Router::buildLink("users",array('view'=>'resource')));
    }
    
    function actionCancel()
    {
        $this->redirect(Router::buildLink("users",array('view'=>'resource')));
    }
    
    public function store() {
        global $mainframe, $user;
        
        $cid = Request::getVar("id", 0); 
        
        $obj_table = YiiTables::getInstance(TBL_RSM_RESOURCES);
       
        $obj_table = $obj_table->load($cid); 
    
        $obj_table->bind($_POST);
         
        if($obj_table->id == 0){
            $obj_table->created_by = $user->id;
        } 
        $obj_table->modified_by = $user->id;
        $obj_table->app = $_POST['params_app'];
        
        $obj_table->store();
 
        YiiMessage::raseSuccess("Successfully save Permission");
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
        YiiMessage::raseSuccess("Successfully publish Permission(s)");
        $this->redirect(Router::buildLink("users",array('view'=>'resource')));
    }
    
    function actionUnpublish()
    {
        $cids = Request::getVar("cid", 0);        
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){                
                $this->changeStatus($cids[$i], 0);
            }
        }
        YiiMessage::raseSuccess("Successfully unpublish Permission(s)");
        $this->redirect(Router::buildLink("users",array('view'=>'resource')));
    }
    
    function actionRemove()
    {
        global $user;
        $cids = Request::getVar("cid", 0);
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){
               $cid = $cids[$i];
               $obj_article = YiiResource::getInstance();
               $obj_article->remove($cid);
            }
        }
        YiiMessage::raseSuccess("Successfully delete Permission(s)");
        $this->redirect(Router::buildLink("users",array('view'=>'resource')));
    }

    function changeStatus($cid, $value)
    {
        $obj_table = YiiResource::getInstance();
        $obj_table->status = $value;
        $obj_table->store();
    }
    
}
