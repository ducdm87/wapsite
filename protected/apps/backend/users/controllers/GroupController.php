<?php

class GroupController extends BackEndController {

    var $primary = 'id';
    var $tablename = "{{users_group}}";
    private $model;

    function init() {
        parent::init();
    }

    public function actionDisplay() {
        
         $task = Request::getVar('task', "");
         if ($task == "hidden" OR $task == 'publish' OR $task == "unpublish") {
            $cids = Request::getVar('cid');            
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i];
                if ($task == "publish")
                    $this->changeStatus ($cid, 1);
                else if ($task == "hidden")
                    $this->changeStatus ($cid, 2);
                else $this->changeStatus ($cid, 0);
            }
            YiiMessage::raseSuccess("Successfully saved changes status for user group");
        }
        
        
        $this->addIconToolbar("Edit", Router::buildLink("users", array("view"=>"group", "layout"=>"edit")), "edit", 1, 1, "Please select a item from the list to edit");        
        $this->addIconToolbar("New", Router::buildLink("users", array("view"=>"group", "layout"=>"new")), "new");
//        $this->addIconToolbarDelete();
        $this->addIconToolbar("Delete", Router::buildLink("users", array("view"=>"group", "layout"=>"remove")), "trash", 1, 1, "Please select a item from the list to Remove");        
        $this->addBarTitle("Group <small>[list]</small>", "user");

        $model = Group::getInstance();
        global $user;
        $groupID = $user->groupID;
        $group = $model->getItem($user->groupID);
        if($group->parentID == 1){ $items = $model->getItems(); }
        else $items = $model->getItems($groupID);

        $this->render('list', array('items' => $items));
    }
    
    function changeStatus($cid, $value)
    {
        $obj_user = YiiUser::getInstance();
        $tbl_group = $obj_user->getGroup($cid);
        $tbl_group->status = $value;
        $tbl_group->store();
    }
    
    
    public function actionNew() {   
        $this->actionEdit();
    }
    
    public function actionEdit() {   
        setSysConfig("sidebar.display", 0); 
        
        $this->addIconToolbar("Save", Router::buildLink("users", array("view"=>"group", "layout"=>"save")), "save");
        $this->addIconToolbar("Apply", Router::buildLink("users", array("view"=>"group", "layout"=>"apply")), "apply");
        $items = array();
        
        $cid = Request::getVar("cid", 0);
        
        if (is_array($cid))
            $cid = $cid[0];

        if ($cid == 0) {
            $this->addIconToolbar("Cancel", Router::buildLink("users", array("view"=>"group", "layout"=>"cancel")), "cancel");
            $this->addBarTitle("User group <small>[New]</small>", "user");        
            $this->pageTitle = "New group";
        }else{
            $this->addIconToolbar("Close", Router::buildLink("users", array("view"=>"group", "layout"=>"cancel")), "cancel");
            $this->addBarTitle("User group <small>[Edit]</small>", "user");        
            $this->pageTitle = "Edit group";           
        }

        $model = new Group();
        $item = $model->getItem(); 
        $list = $model->getListEdit($item);
       
        $this->render('edit', array("item"=>$item,"list"=>$list));
    }
    
    function actionApply(){         
        $cid = $this->store();       
        $this->redirect(Router::buildLink("users", array("view"=>"group", "layout"=>"edit", 'cid'=> $cid)));
    }
    
    function actionSave(){
        $cid = $this->store();   
        $this->redirect(Router::buildLink("users", array("view"=>"group")));
    }
    
    function store(){
        global $mainframe, $db;
        $post = $_POST;
       
        $id = Request::getVar("id", 0);
        
        $obj_user = YiiUser::getInstance();
        $tbl_group = $obj_user->getGroup($id);        
        $tbl_group->_ordering = isset($post['ordering'])?$post['ordering']:null;
        $tbl_group->_old_parent = $tbl_group->parentID;        
        
        $tbl_group->bind($post); 
//        $tbl_group->parentID = intval($tbl_group->parentID);
//        if($tbl_group->parentID >0){
//            $tbl_group_parent = $obj_user->getGroup($tbl_group->parentID);
//            if($tbl_group->parentID == 1)
//                $tbl_group->backend = 1;
//            else $tbl_group->backend = $tbl_group_parent->backend;
//        }else{
//            $tbl_group->backend = 0;
//        }
//        
        $tbl_group->store();
       
        return $tbl_group->id; 
    }
   
    function actionCancel(){
        $this->redirect(Router::buildLink("users", array("view"=>"group")));
    }
    
    function actionRemove()
    {
        $cids = Request::getVar("cid", 0);
        if(count($cids) >0){
            $obj_table = YiiUser::getInstance();
            for($i=0;$i<count($cids);$i++){
               $obj_table->removeGroup($cids[$i]);
            }
        }
        YiiMessage::raseSuccess("Successfully delete GroupUser(s)");
        $this->redirect(Router::buildLink("users", array("view"=>"group")));
    }
    

}
