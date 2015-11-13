<?php

class MenusController extends BackEndController {

    var $primary = 'id';
    var $tablename = "{{menus}}";
    var $tbl_menuitem = "{{menu_item}}";
    var $item = null;
    var $item2 = null;
    var $items = array();
    
    private $model;
    private $request;

    function init() {        
        yii::import('application.models.backend.menus.*');
        parent::init();
    }
    /*
     * For menu type
     */
    public function actionMenutypes() {
        $this->pageTitle = "Menu manager";        
        $model = MenuType::getInstance();  
        $obj_menu = YiiMenu::getInstance();
        $task = Request::getVar('task', "");
        if ($task == "hidden" OR $task == 'publish' OR $task == "unpublish") {
            $cids = Request::getVar('cid');            
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i];
                if ($task == "publish")
                    $this->changeStatusMenuType ($cid, 1);
                else if ($task == "hidden")
                    $this->changeStatusMenuType ($cid, 2);
                else $this->changeStatusMenuType ($cid, 0);
            }
            YiiMessage::raseSuccess("Successfully saved changes status for menu type");
        }
        
        $this->addIconToolbar("Creat", $this->createUrl("/menus/newmenutype"), "new");
        $this->addIconToolbar("Edit", $this->createUrl("/menus/editmenutype"), "edit", 1, 1, "Please select a item from the list to edit");        
        $this->addIconToolbar("Publish", $this->createUrl("/menus/publishmenutype"), "publish");
        $this->addIconToolbar("Unpublish", $this->createUrl("/menus/unpublishmenutype"), "unpublish");
        $this->addIconToolbar("Delete", $this->createUrl("/menus/removemenutype"), "trash", 1, 1, "Please select a item from the list to Remove");        
        $this->addBarTitle("Menu type <small>[manager]</small>", "user");   
        
        $items = $obj_menu->loadMenus("*",false);        
        $this->render('menutypes', array("items"=>$items));
    }
    
    public function actionNewmenutype() {   
        $this->actionEditmenutype();
    }
    
    public function actionEditmenutype() {   
        setSysConfig("sidebar.display", 0);
        $obj_menu = YiiMenu::getInstance();
        
        $this->addIconToolbar("Save", $this->createUrl("/menus/savemenutype"), "save");
        $this->addIconToolbar("Apply", $this->createUrl("/menus/applymenutype"), "apply");
        $items = array();
        
        $cid = Request::getVar("cid", 0);
        
        if (is_array($cid))
            $cid = $cid[0];

        if ($cid == 0) {
            $this->addIconToolbar("Cancel", $this->createUrl("/menus/cancelmenutype"), "cancel");
            $this->addBarTitle("Menu types <small>[New]</small>", "user");        
            $this->pageTitle = "New menu";
        }else{
            $this->addIconToolbar("Close", $this->createUrl("/menus/cancelmenutype"), "cancel");
            $this->addBarTitle("Menu type <small>[Edit]</small>", "user");        
            $this->pageTitle = "Edit menu";           
        }
        $obj_tblMenu = $obj_menu->loadMenu($cid, "*", false); 
       
        $this->render('editmenutype', array("obj_tblMenu"=>$obj_tblMenu));
    }

    function actionApplymenutype() {
        $cid = $this->storeMenuType();
        $this->redirect($this->createUrl('menus/editmenutype') . "?cid=" . $cid);
    }
    
    function actionSavemenutype() {
        $cid = $this->storeMenuType();
        $this->redirect($this->createUrl('menus/menutypes'));
    }
    
    function actionCancelmenutype()
    {
        $this->redirect($this->createUrl('menus/menutypes'));
    }
   
    
    function storeMenuType() {
        global $mainframe;
        $post = $_POST;
        $obj_menu = YiiMenu::getInstance();
        
        $id = Request::getInt("id", 0);
        $obj_tblMenu = $obj_menu->loadMenu($id, "*", false); 
        $obj_tblMenu->bind($post);
      
        if($obj_tblMenu->title == "" AND $obj_tblMenu->alias == "") return false;
        
        YiiMessage::raseSuccess("Successfully saved changes to menu: " . $this->item['title']);
        $obj_tblMenu->store();
        return $obj_tblMenu->id;
    }
    
    function actionRemovemenutype() {
        $cids = Request::getVar("cid", 0);
        $table_menu = YiiTables::getInstance(TBL_MENU);
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){
                $cid = $cids[$i];
                //check item first
                $table_menu->remove($cid);
            }
        }
        YiiMessage::raseSuccess("Successfully remove Menutype(s)");
        $this->redirect($this->createUrl('menus/menutypes'));
    }
    
    function actionPublishmenutype()
    {
        $cids = Request::getVar("cid", 0);        
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){
                $this->changeStatusMenuType($cids[$i], 1);
            }
        }
        YiiMessage::raseSuccess("Successfully publish Menutype(s)");
        $this->redirect($this->createUrl('menus/menutypes'));
    }
    
    function actionUnpublishmenutype()
    {
        $cids = Request::getVar("cid", 0);        
        if(count($cids) >0){
            for($i=0;$i<count($cids);$i++){                
                $this->changeStatusMenuType($cids[$i], 0);
            }
        }
        YiiMessage::raseSuccess("Successfully unpublish Menutype(s)");
        $this->redirect($this->createUrl('menus/menutypes'));
    }
    
    function changeStatusMenuType($cid, $value)
    {
        $obj_menu = YiiMenu::getInstance();        
        $obj_tblMenu = $obj_menu->loadMenu($cid, "*", false); 
        $obj_tblMenu->status = $value;
        $obj_tblMenu->store();
    }
    
    
    
    /*
     * For menu item
     */

    function actionMenuitems()
    {
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
                    $this->changeStatusMenuItem ($cid, 1);
                else if ($task == "hidden")
                    $this->changeStatusMenuItem ($cid, 2);
                else $this->changeStatusMenuItem ($cid, 0);
            }
            YiiMessage::raseSuccess("Successfully saved changes status for menu item");
        }
        
        $this->addIconToolbar("Creat", $this->createUrl("/menus/newmenuitem?menu=$menuID"), "new");
        $this->addIconToolbar("Edit", $this->createUrl("/menus/editmenuitem?menu=$menuID"), "edit", 1, 1, "Please select a item from the list to edit");        
        $this->addIconToolbar("Publish", $this->createUrl("/menus/publishmenuitem?menu=$menuID"), "publish");
        $this->addIconToolbar("Unpublish", $this->createUrl("/menus/unpublishmenuitem?menu=$menuID"), "unpublish");
        $this->addIconToolbar("Delete", $this->createUrl("/menus/removemenuitem?menu=$menuID"), "trash", 1, 1, "Please select a item from the list to Remove");        
        $this->addBarTitle("Menu items <small>[manager]</small>", "user");   
        
        $obj_menu = YiiMenu::getInstance();
        $items = $obj_menu->loadItems($menuID);
 
        $lists = $model->getList(); 
        
        $this->render('menuitems', array("items"=>$items, "lists"=>$lists));
    }
    
     public function actionNewmenuitem() {                
        $this->actionEditmenuitem();
    }
    
    public function actionEditmenuitem() {
        $menuID = Request::getInt('menu', "");
        if($menuID<=0){
            YiiMessage::raseWarning("Invalid menu id");
            $this->redirect($this->createUrl('menus/menutypes'));
        }
        
        $this->addIconToolbar("Save", $this->createUrl("/menus/savemenuitem?menu=$menuID"), "save");
        $this->addIconToolbar("Apply", $this->createUrl("/menus/applymenuitem?menu=$menuID"), "apply");
        $items = array();
        setSysConfig("sidebar.display", 0);
        $cid = Request::getVar("cid", 0);
        $menuID = Request::getInt('menu', "");
        if($menuID<=0){
            YiiMessage::raseWarning("Invalid menu id");
            $this->redirect($this->createUrl('menus/menutypes'));
        }
        
        if (is_array($cid))
            $cid = $cid[0];
        $obj_menu = YiiMenu::getInstance();
        if ($cid == 0) {
            $this->addBarTitle("Menu item <small>[New]</small>", "user");        
            $this->pageTitle = "New menu item";
            $this->addIconToolbar("Cancel", $this->createUrl("/menus/cancelmenuitem?menu=$menuID"), "cancel");        
        }else{
            $this->addBarTitle("Menu item <small>[Edit]</small>", "user");        
            $this->pageTitle = "Edit menu item";
            $this->addIconToolbar("Close", $this->createUrl("/menus/cancelmenuitem?menu=$menuID"), "cancel");
        }
      
        $obj_tblMenuItem = $obj_menu->loadItem($cid);
        
        $model = MenuItem::getInstance();
        $list = $model->getListEdit($obj_tblMenuItem);
         
        if($obj_tblMenuItem->params != "") $obj_tblMenuItem->params = json_decode($obj_tblMenuItem->params);
        else $obj_tblMenuItem->params = null;
    
        
        $params = array("item"=>$obj_tblMenuItem, "list"=>$list);
        $this->render('editmenuitem', $params);
    }
     
    function changeStatusMenuItem($cid, $value)
    {
        $obj_menu = YiiMenu::getInstance();        
        $obj_tblMenu = $obj_menu->loadItem($cid, "*", false); 
        $obj_tblMenu->status = $value;
        $obj_tblMenu->store();
    }
    
    function actionApplymenuitem() {
        list($menuID, $menuItemID) = $this->storeMenuItem();       
        $this->redirect($this->createUrl('menus/editmenuitem?menu='.$menuID.'&cid=' . $menuItemID));
    }
    
    function actionSavemenuitem() {
        list($menuID, $menuItemID) = $this->storeMenuItem();        
        $this->redirect($this->createUrl('menus/menuitems?menu='.$menuID));
    }
    
    function actionCancelmenuitem(){
        $menuID = Request::getInt('menu', "");
        if($menuID<=0){
            YiiMessage::raseWarning("Invalid menu id");
            $this->redirect($this->createUrl('menus/menutypes'));
        }else{           
            $this->redirect($this->createUrl('menus/menuitems?menu='.$menuID));
        }
    }
   
    
    function storeMenuItem() {
        global $mainframe, $db;
        $post = $_POST;
       
        $id = Request::getVar("id", 0);  
        $params = Request::getVar("params", array());  
        $obj_menu = YiiMenu::getInstance();
        $tbl_menu = $obj_menu->loadItem($id);        
        $tbl_menu->_ordering = isset($post['ordering'])?$post['ordering']:null;
        $tbl_menu->_old_parent = $tbl_menu->parentID;        
        $tbl_menu->bind($post);
        $tbl_menu->app = $params['app'];
        $params = json_encode($params);        
        $tbl_menu->params = $params;  
        $tbl_menu->store();        
        return array($tbl_menu->menuID, $tbl_menu->id);
    }
    
    function actionLoadconfigmenuitem(){
        $model = MenuItem::getInstance();
        $out = $model->getListParamView();
        echo json_encode($out);
    }
    
    function actionRemovemenuitem()
    {
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
        $this->redirect($this->createUrl('menus/menuitems?menu='.$menuID));
    }
     
    
}
