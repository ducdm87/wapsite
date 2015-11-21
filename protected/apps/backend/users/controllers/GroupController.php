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
        $this->addBarTitle("Group <small>[list]</small>", "group");

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
        global $user;
        
        $obj_user = YiiUser::getInstance();
        $tbl_group = $obj_user->getGroup($cid);
        $bool = $user->groupChecking($cid);
        if($bool == true){
            if($user->groupID == $cid) $bool = false;
            else if($user->leader == 0) $bool = false;
        }
        
        if($bool == false){            
            YiiMessage::raseNotice("Your account not have permission to change status of this group: $tbl_group->name");
            $this->redirect(Router::buildLink("users", array('view'=>'group')));
            return false;
        } 
         
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
        // chi useradmin moi duoc tao/sua group
       global $user;
       $group_currentUser = $model->getItem($user->groupID);
       if($group_currentUser->parentID != 1){
           YiiMessage::raseNotice("Your account not have permission to add/edit group");
           $this->redirect(Router::buildLink("users", array('view'=>'group')));
       }
       
        $this->render('edit', array("item"=>$item,"list"=>$list));
    }
    
    function actionApply(){         
        $cid = $this->store();
        YiiMessage::raseSuccess("Group save succesfully");
        $this->redirect(Router::buildLink("users", array("view"=>"group", "layout"=>"edit", 'cid'=> $cid)));
    }
    
    function actionSave(){
        $cid = $this->store();
        YiiMessage::raseSuccess("Group save succesfully");
        $this->redirect(Router::buildLink("users", array("view"=>"group")));
        
    }
    
    function store(){
        global $mainframe, $db, $user;
        $post = $_POST;
       
        $model = new Group();
       // chi useradmin moi duoc tao/sua group
       $group_currentUser = $model->getItem($user->groupID);
       if($group_currentUser->parentID != 1){
           YiiMessage::raseNotice("Your account not have permission to add/edit group");
           $this->redirect(Router::buildLink("users", array('view'=>'group')));
       }
       
        $id = Request::getVar("id", 0);
        
        $obj_user = YiiUser::getInstance();
        $tbl_group = $obj_user->getGroup($id);        
        $tbl_group->_ordering = isset($post['ordering'])?$post['ordering']:null;
        $tbl_group->_old_parent = $tbl_group->parentID;        
                
        $tbl_group->bind($post); 
    
        $tbl_group->store();
       
        return $tbl_group->id; 
    }
   
    function actionCancel(){
        $this->redirect(Router::buildLink("users", array("view"=>"group")));
    }
    
    function actionRemove()
    {
       global $user;
       $model = new Group();
       $mode_user = new Users();
       // chi useradmin moi duoc tao/sua group
       $group_currentUser = $model->getItem($user->groupID);
       if($group_currentUser->parentID != 1){
           YiiMessage::raseNotice("Your account not have permission to add/edit group");
           $this->redirect(Router::buildLink("users", array('view'=>'group')));
       }
       
        $cids = Request::getVar("cid", 0);
        if(count($cids) >0){
            $obj_table = YiiUser::getInstance();
            for($i=0;$i<count($cids);$i++){
                $cid = $cids[$i];
                $list_user = $mode_user->getUsers($cid,null, true);
                $list_group = $model->getItems($cid);                 
                if(empty($list_user) AND empty($list_group))
                {
                    $obj_table->removeGroup($cid);
                }else{
                    YiiMessage::raseNotice("Group user have something account/sub group");
                    $this->redirect(Router::buildLink("users", array('view'=>'group'))); 
                    return false;
                }
            }
        }
        YiiMessage::raseSuccess("Successfully delete GroupUser(s)");
        $this->redirect(Router::buildLink("users", array("view"=>"group")));
    }
    

}
