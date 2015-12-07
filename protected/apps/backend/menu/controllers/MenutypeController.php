<?php

class MenutypeController extends BackEndController {

    var $primary = 'id';
    var $tablename = "{{menus}}";
    var $tbl_menuitem = "{{menu_item}}";
    var $item = null;
    var $item2 = null;
    var $items = array();
    
    private $model;
    private $request;

    function init() {        
        
         
        parent::init();
    }
    /*
     * For menu type
     */
    public function actionDisplay() {
         global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to view menu");
            $this->redirect(Router::buildLink("cpanel"));
        }
        
        $this->pageTitle = "Menu manager";        
        $model = MenuType::getInstance();  
        $obj_menu = YiiMenu::getInstance();
        $task = Request::getVar('task', "");
        if ($task == "hidden" OR $task == 'publish' OR $task == "unpublish") {
            $cids = Request::getVar('cid');            
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i];
                if ($task == "publish")
                    $this->changeStatus($cid, 1);
                else if ($task == "hidden")
                    $this->changeStatus($cid, 2);
                else $this->changeStatus($cid, 0);
            }
            YiiMessage::raseSuccess("Successfully saved changes status for menu type");
        }
        
        $this->addIconToolbar("Creat", Router::buildLink("menu", array("view"=>"menutype", 'layout'=>'new')), "new");        
        $this->addIconToolbar("Edit", Router::buildLink("menu", array("view"=>"menutype", 'layout'=>'edit')), "edit", 1, 1, "Please select a item from the list to edit");        
        $this->addIconToolbar("Publish", Router::buildLink("menu", array("view"=>"menutype", 'layout'=>'publish')), "publish");
        $this->addIconToolbar("Unpublish", Router::buildLink("menu", array("view"=>"menutype", 'layout'=>'unpublish')), "unpublish");
        $this->addIconToolbar("Delete", Router::buildLink("menu", array("view"=>"menutype", 'layout'=>'remove')), "trash", 1, 1, "Please select a item from the list to Remove");        
        $this->addBarTitle("Menu type <small>[manager]</small>", "user");   
        
        $items = $obj_menu->loadMenus("*",false);        
        $this->render('default', array("items"=>$items));
    }
    
    public function actionNew() {
        $this->actionEdit();
    }
    
    public function actionEdit() {  
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to add/edit menu");
            $this->redirect(Router::buildLink("cpanel"));
        }
        setSysConfig("sidebar.display", 0);
        $obj_menu = YiiMenu::getInstance();
        
        $this->addIconToolbar("Save", Router::buildLink("menu", array("view"=>"menutype", 'layout'=>'save')), "save");
        $this->addIconToolbar("Apply", Router::buildLink("menu", array("view"=>"menutype", 'layout'=>'apply')), "apply");
        $items = array();
        
        $cid = Request::getVar("cid", 0);
        
        if (is_array($cid))
            $cid = $cid[0];

        if ($cid == 0) {
            $this->addIconToolbar("Cancel", Router::buildLink("menu", array("view"=>"menutype", 'layout'=>'cancel')), "cancel");
            $this->addBarTitle("Menu types <small>[New]</small>", "user");        
            $this->pageTitle = "New menu";
        }else{
            $this->addIconToolbar("Close", Router::buildLink("menu", array("view"=>"menutype", 'layout'=>'cancel')), "cancel");
            $this->addBarTitle("Menu type <small>[Edit]</small>", "user");        
            $this->pageTitle = "Edit menu";           
        }
        $obj_tblMenu = $obj_menu->loadMenu($cid, "*", false); 
       
        $this->render('edit', array("obj_tblMenu"=>$obj_tblMenu));
    }

    function actionApply() {
        $this->store();
        $this->redirect(Router::buildLink("menu", array("view"=>"menutype", 'layout'=>'edit','cid'=>$this->item["id"])));
    }
    
    function actionSave() {
        $this->store();
        $this->redirect(Router::buildLink("menu", array("view"=>"menutype")));
    }
    
    function actionCancel()
    {
        $this->redirect(Router::buildLink("menu", array("view"=>"menutype")));
    }
   
    
    function store() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify menu");
            $this->redirect(Router::buildLink("cpanel"));
        }
        
        $post = $_POST;
       
        $id = Request::getInt("id", 0);
        $bool = true;
        $this->item = $this->loadItem($id); 
        
        $this->item = $mainframe->bind($this->item, $post); 
        if($this->item['title'] == "" AND $this->item['alias'] == "") return false;
        $this->item["id"] = $id;
        
        YiiMessage::raseSuccess("Successfully saved changes to menu: " . $this->item['title']);
        $this->item["id"] = $this->storeItem();
    }
    
    function actionRemove() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission remove menu");
            $this->redirect(Router::buildLink("cpanel"));
        }
        
        $cids = Request::getVar("cid", 0);
        
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){
                $cid = $cids[$i];
                //check item first
                $item = $this->removeItem($cid);               
            }
        }
        YiiMessage::raseSuccess("Successfully remove Menutype(s)");
        $this->redirect(Router::buildLink("menu", array("view"=>"menutype")));
    }
    
    function actionPublish()
    {
        $cids = Request::getVar("cid", 0);
        
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){
                $cid = $cids[$i];
                //check item first
                $this->item = $this->loadItem($cid);            
                $this->item['status'] = 1;
                $this->item["id"] = $this->storeItem();
            }
        }
        YiiMessage::raseSuccess("Successfully publish Menutype(s)");
        $this->redirect(Router::buildLink("menu", array("view"=>"menutype")));
    }
    
    function actionUnpublish()
    {
        $cids = Request::getVar("cid", 0);
        
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){
                $cid = $cids[$i];
                //check item first
                $this->item = $this->loadItem($cid);            
                $this->item['status'] = 0;
                $this->item["id"] = $this->storeItem();
            }
        }
        YiiMessage::raseSuccess("Successfully unpublish Menutype(s)");
        $this->redirect(Router::buildLink("menu", array("view"=>"menutype")));
    } 
    
    function changeStatus($cid, $value)
    {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify menu");
            $this->redirect(Router::buildLink("cpanel"));
        }
        
        $obj_menu = YiiMenu::getInstance();        
        $obj_tblMenu = $obj_menu->loadMenu($cid, "*", false); 
        $obj_tblMenu->status = $value;
        $obj_tblMenu->store();
    }
}
