<?php

class AboutController extends BackEndController {

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
         $this->addBarTitle("About <small>[resource manager]</small>", "user"); 
        $this->render('default');
    } 
    
}
