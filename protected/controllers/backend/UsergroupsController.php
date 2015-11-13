<?php

class UsergroupsController extends BackEndController {

    var $primary = 'id';
    var $tablename = "{{users_group}}";
    private $model_group;
    private $model;
    private $request;

    function init() {
        parent::init();
        $this->request = Yii::app()->getRequest();
        yii::import('application.models.backend.users.*');
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
        
        
        $this->addIconToolbar("Edit", $this->createUrl("/usergroups/edit"), "edit", 1, 1, "Please select a item from the list to edit");
        $this->addIconToolbar("New", $this->createUrl("/usergroups/new"), "new");
//        $this->addIconToolbarDelete();
        $this->addIconToolbar("Delete", $this->createUrl("/usergroups/remove"), "trash", 1, 1, "Please select a item from the list to Remove");        
        $this->addBarTitle("Group <small>[list]</small>", "user");

        $model = Group::getInstance();
        $items = $model->getItems();

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
        
        $this->addIconToolbar("Save", $this->createUrl("/usergroups/save"), "save");
        $this->addIconToolbar("Apply", $this->createUrl("/usergroups/apply"), "apply");
        $items = array();
        
        $cid = Request::getVar("cid", 0);
        
        if (is_array($cid))
            $cid = $cid[0];

        if ($cid == 0) {
            $this->addIconToolbar("Cancel", $this->createUrl("/usergroups/cancel"), "cancel");
            $this->addBarTitle("User group <small>[New]</small>", "user");        
            $this->pageTitle = "New group";
        }else{
            $this->addIconToolbar("Close", $this->createUrl("/usergroups/cancel"), "cancel");
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
        $this->redirect($this->createUrl('usergroups/edit?cid=' . $cid));
    }
    
    function actionSave(){
        $cid = $this->store();       
        $this->redirect($this->createUrl('usergroups/'));
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
        $tbl_group->store();
       
        return $tbl_group->id; 
    }
   
    function actionCancel(){
        $this->redirect($this->createUrl('usergroups/'));
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
        $this->redirect($this->createUrl('usergroups/'));
    }
    

}
