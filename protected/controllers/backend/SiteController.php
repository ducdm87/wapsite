<?php

class SiteController extends BackEndController {

    public $item = array();
    public $tablename = "{{gx_info}}";
    public $primary = "id"; 

    function init() {
         
        parent::init();
    }
    
    
    public function actionError() {
        $this->pageTitle = "Page Not Found";        
        $params = array();
        $this->render('error', $params);
    }
}
