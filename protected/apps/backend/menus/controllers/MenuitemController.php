<?php

class MenuitemController extends BackEndController {

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
            YiiMessage::raseNotice("Your account not have permission to view menu item");
            $this->redirect(Router::buildLink("menus", array("view"=>'menutype')));
        }
        
        $this->pageTitle = "Menu item";
        $model = MenuItem::getInstance();  
        $menuID = Request::getInt('menu', "");
        if($menuID<=0){
            YiiMessage::raseWarning("Invalid menu id");
            $this->redirect($this->createUrl('menus/menutypes'));
        }
        
        $task = Request::getVar('task', "");
        if ($task == "hidden" OR $task == 'publish' OR $task == "unpublish") {
            $cids = Request::getVar('cid');
            $obj_menu = YiiMenu::getInstance();
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i]; 
                if ($task == "publish")
                    $this->changeStatus($cid, 1);
                else if ($task == "hidden")
                    $this->changeStatus($cid, 2);
                else $this->changeStatus($cid, 0);
            }
            YiiMessage::raseSuccess("Successfully saved changes status for menu item");
        }
        
        $this->addIconToolbar("Creat", Router::buildLink('menus', array("view"=>"menuitem",'menu'=>$menuID, 'layout'=>'new')), "new");
        $this->addIconToolbar("Edit", Router::buildLink('menus', array("view"=>"menuitem",'menu'=>$menuID, 'layout'=>'edit')), "edit", 1, 1, "Please select a item from the list to edit");        
        $this->addIconToolbar("Publish", Router::buildLink('menus', array("view"=>"menuitem",'menu'=>$menuID, 'layout'=>'publish')), "publish");
        $this->addIconToolbar("Unpublish", Router::buildLink('menus', array("view"=>"menuitem",'menu'=>$menuID, 'layout'=>'unpublish')), "unpublish");
        $this->addIconToolbar("Delete", Router::buildLink('menus', array("view"=>"menuitem",'menu'=>$menuID, 'layout'=>'remove')), "trash", 1, 1, "Please select a item from the list to Remove");        
        $this->addBarTitle("Menu items <small>[manager]</small>", "user");   
        
        $obj_menu = YiiMenu::getInstance();
        $items = $obj_menu->loadItems($menuID);
 
        $lists = $model->getList(); 
        
        $this->render('default', array("items"=>$items, "lists"=>$lists));
    }
    
    public function actionNew() {                
        $this->actionEdit();
    }
    
    public function actionEdit() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to edit menu item");
            $this->redirect(Router::buildLink("menus", array("view"=>'menutype')));
        }
        
        $menuID = Request::getInt('menu', "");
        if($menuID<=0){
            YiiMessage::raseWarning("Invalid menu id");
            $this->redirect(Router::buildLink('menus', array("view"=>"menutype")));
        }
        
        $this->addIconToolbar("Save", Router::buildLink('menus', array("view"=>"menuitem",'menu'=>$menuID, 'layout'=>'save')), "save");
        $this->addIconToolbar("Apply", Router::buildLink('menus', array("view"=>"menuitem",'menu'=>$menuID, 'layout'=>'apply')), "apply");
        $items = array();
        setSysConfig("sidebar.display", 0);
        $cid = Request::getVar("cid", 0);
        $menuID = Request::getInt('menu', "");
        if($menuID<=0){
            YiiMessage::raseWarning("Invalid menu id");
            $this->redirect(Router::buildLink('menus', array("view"=>"menutype")));
        }
        
        if (is_array($cid))
            $cid = $cid[0];
        $obj_menu = YiiMenu::getInstance();
        if ($cid == 0) {
            $this->addBarTitle("Menu item <small>[New]</small>", "user");        
            $this->pageTitle = "New menu item";
            $this->addIconToolbar("Cancel", Router::buildLink('menus', array("view"=>"menuitem",'menu'=>$menuID, 'layout'=>'cancel')), "cancel");        
        }else{
            $this->addBarTitle("Menu item <small>[Edit]</small>", "user");        
            $this->pageTitle = "Edit menu item";
            $this->addIconToolbar("Close", Router::buildLink('menus', array("view"=>"menuitem",'menu'=>$menuID, 'layout'=>'cancel')), "cancel");
        }
      
        $obj_tblMenuItem = $obj_menu->loadItem($cid);
        
        $model = MenuItem::getInstance();
        $list = $model->getListEdit($obj_tblMenuItem);
         
        if($obj_tblMenuItem->params != "") $obj_tblMenuItem->params = json_decode($obj_tblMenuItem->params);
        else $obj_tblMenuItem->params = null;
    
        
        $params = array("item"=>$obj_tblMenuItem, "list"=>$list);
        $this->render('edit', $params);
    }
     
    function changeStatus($cid, $value)
    {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify menu item");
            $this->redirect(Router::buildLink("menus", array("view"=>'menutype')));
        }
        
        $obj_menu = YiiMenu::getInstance();        
        $obj_tblMenu = $obj_menu->loadItem($cid, "*", false); 
        $obj_tblMenu->status = $value;
        $obj_tblMenu->store();
    }
    
    function actionApply() {
        $model = MenuItem::getInstance();         
        $result = $model->storeItem();
        if($result == false){
            $this->redirect(Router::buildLink("menus", array("view"=>'menutype')));
        }else{
            list($menuID, $menuItemID) = $result;
            YiiMessage::raseSuccess("Successfully save Menu Item");
            $this->redirect(Router::buildLink('menus', array("view"=>"menuitem",'menu'=>$menuID, 'layout'=>'edit','cid'=>$menuItemID)));
        }
    }
    
    function actionSave() {
        $model = MenuItem::getInstance();
        $result = $model->storeItem();
        if($result == false){
            $this->redirect(Router::buildLink("menus", array("view"=>'menutype')));
        }else{
            list($menuID, $menuItemID) = $result;
            YiiMessage::raseSuccess("Successfully save Menu Item");
            $this->redirect(Router::buildLink('menus', array("view"=>"menuitem",'menu'=>$menuID)));
        }
    }
    
    function actionCancel(){
        $menuID = Request::getInt('menu', "");
        if($menuID<=0){
            YiiMessage::raseWarning("Invalid menu id");
            $this->redirect(Router::buildLink('menus', array("view"=>"menutype")));
        }else{           
            $this->redirect(Router::buildLink('menus', array("view"=>"menuitem",'menu'=>$menuID)));
        }
    } 
     
    
    function actionLoadconfigmenuitem(){
        $model = MenuItem::getInstance();
        $out = $model->getListParamView();
        echo json_encode($out);
    }
    
    function actionRemove()
    {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to remove menu item");
            $this->redirect(Router::buildLink("menus", array("view"=>'menutype')));
        }
        
        $menuID = Request::getInt('menu', "");
        $cids = Request::getVar("cid", 0);
        $table_menu = YiiTables::getInstance(TBL_MENU_ITEM);
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){
                $cid = $cids[$i];
                //check item first
                $table_menu->remove($cid);
            }
        }
        YiiMessage::raseSuccess("Successfully remove Menuitem(s)");
        $this->redirect(Router::buildLink('menus', array("view"=>"menuitem",'menu'=>$menuID)));        
    }
}
