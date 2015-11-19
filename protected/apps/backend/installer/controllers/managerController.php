<?php

class ManagerController extends BackEndController {

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
            YiiMessage::raseNotice("Your account not have permission to manager extension");
            $this->redirect(Router::buildLink("cpanel"));
        }
        
        $task = Request::getVar('task', "");
        $task = Request::getVar('task', "");
        if ($task == "hidden" OR $task == 'publish' OR $task == "unpublish") {
            $cids = Request::getVar('cid');
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i];
                if ($task == "publish")
                    $this->changeStatus($cid, 1);
                else if ($task == "hidden")
                    $this->changeStatus($cid, 2);
                else
                    $this->changeStatus($cid, 0);
            }
            YiiMessage::raseSuccess("Successfully saved changes status for extention");
        }else if ($task == "delete") {
            var_dump($_POST);
            die;
        }
 
        $obj_ext = YiiExtensions::getInstance();
        $extension = $obj_ext->loadExts();

        $this->addIconToolbarDelete("Uninstall",'Uninstall');
        $this->addBarTitle("Extension Manager <small>[Manage]</small>", "user");

        $this->render('default', array("extentions" => $extension));
    }

    function changeStatus($cid, $value) {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify extension");
            $this->redirect(Router::buildLink("cpanel"));
        }
        
        $obj_ext = YiiExtensions::getInstance();
        $obj_tblExt = $obj_ext->loadExt($cid);
        $obj_tblExt->status = $value;
        $obj_tblExt->store();
    }
}
