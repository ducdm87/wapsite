<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HomeController extends BackEndController {
 
    var $tablename = "{{modules}}";
    var $tbl_menu = '{{menus}}';
    var $primary = 'id';
    var $item = null;
    
    private $model;

    function init() {
        parent::init();
        $this->model = Module::getInstance();
    }

    public function actionDisplay() { 
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to view menu item");
            $this->redirect(Router::buildLink("menus", array("view"=>'menutype')));
        }
        
        $this->addIconToolbar("Creat", Router::buildLink("modules", array("layout"=>"edit")), "new");
        $this->addIconToolbar("Edit", Router::buildLink("modules", array("layout"=>"edit")), "edit", 1, 1, "Please select a item from the list to edit");        
        $this->addIconToolbar("Publish", Router::buildLink("modules", array("layout"=>"publish")), "publish");
        $this->addIconToolbar("Unpublish", Router::buildLink("modules", array("layout"=>"unpublish")), "unpublish");
        $this->addIconToolbar("Delete", Router::buildLink("modules", array("layout"=>"remove")), "trash", 1, 1, "Please select a item from the list to Remove");        
        $this->addBarTitle("Modules <small>[manager]</small>", "user");   
        
        $items = $this->model->getItems();
        $this->render('default', array("items" => $items));
    } 

    public function actionEdit() {global $mainframe, $user;        
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to add/edit module");
            $this->redirect(Router::buildLink("cpanel"));
        }
        
        $cid = Request::getVar('cid', "");        
        setSysConfig("sidebar.display", 0);
        //check boolean id
        if ($cid) $item = $this->model->getExtensionById($cid);   
 
        $lists = $this->model->getListEdit($item);

        $this->addIconToolbar("Save", Router::buildLink("modules", array("layout"=>"save")), "save");
        $this->addIconToolbar("Apply", Router::buildLink("modules", array("layout"=>"apply")), "apply");
        $this->addBarTitle("Module <small>[Edit]</small>", "user");
        $this->addIconToolbar("Close", Router::buildLink("modules", array("layout"=>"cancel")), "cancel");
        $this->pageTitle = "Edit module";           
        
        $this->render('edit', array("item" => $item, "lists"=>$lists));
    }

    function actionApply() {
        $cid = $this->store();
        $this->redirect(Router::buildLink("modules", array("layout"=>"edit",'cid'=>$cid)));
    }
    
    function actionSave() {
        $cid = $this->store();
        $this->redirect(Router::buildLink("modules"));
    }
    
    function actionCancel()
    {
        $this->redirect(Router::buildLink("modules"));
    }
    
    public function store() {        
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify module");
            $this->redirect(Router::buildLink("cpanel"));
        }
        
        $cid = Request::getVar("id", 0); 
       
        $obj_module = YiiModule::getInstance();
        $obj_row = $obj_module->loadItem($cid);
        $obj_row->bind($_POST);
        
        $menu_selected = Request::getVar('selection-menu-select', 'selected');
        $obj_row->params = json_encode($_POST['params']);
        $obj_row->menu = $menu_selected;
        $obj_row->store();
         
        if($menu_selected == 'all'){
            $query = "DELETE FROM ".TBL_MODULE_MENUITEM_REF." WHERE moduleID = $obj_row->id ";
            Yii::app()->db->createCommand($query)->query();
            
            $query = "INSERT INTO ".TBL_MODULE_MENUITEM_REF." SET moduleID = $obj_row->id, menuID = 0 ";
            Yii::app()->db->createCommand($query)->query();
            
        }else if($menu_selected == 'selected' AND isset ($_POST['selection-menu'])){
            $menuids = $_POST['selection-menu'];
            foreach($menuids as $menuid){
                $query = "REPLACE INTO ".TBL_MODULE_MENUITEM_REF." SET moduleID = $obj_row->id, menuID = $menuid ";
                Yii::app()->db->createCommand($query)->query();
            } 
        }else{
            $query = "DELETE FROM ".TBL_MODULE_MENUITEM_REF." WHERE moduleID = $obj_row->id ";
            Yii::app()->db->createCommand($query)->query();
        }
            
 
        YiiMessage::raseSuccess("Successfully save Module(s)");
        return $obj_row->id;
    }
 
      
    public function actionDelete($id = false) {

        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify module");
            $this->redirect(Router::buildLink("cpanel"));
        }
        
        if ($data = $this->model->getExtensionById($id)) {
            $this->deleteDirectory($data);
        }
        if ($this->model->deleteExtention($id)) {
            YiiMessage::raseSuccess("Delete bean has success!.");
        } else {
            YiiMessage::raseWarning("Error! Delete fail!.");
        }
        $this->redirect(Router::buildLink("modules"));
    } 
}
