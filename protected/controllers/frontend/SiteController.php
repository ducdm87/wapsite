<?php

class SiteController extends FrontEndController {

    public $item = array();
    public $tablename = "{{gx_info}}";
    public $primary = "id";

    function init() {
         $scope = Request::getVar('scope',null);
        if($scope != null){
            $this->layout = "//$scope/default";
        } else $this->layout = "//site/default";
        parent::init();
    }
    
    function render($action, $data = NULL, $return = false) {
         $scope = Request::getVar('scope',null);
          
         if($scope != null)
             $view =  "//$scope/tpl/site_$action";
          else $view =  "/tpl/$action";
         
        parent::render($view, $data, $return);
    }

    public function actionError() {
        $this->pageTitle = "Page Not Found";
        $this->metaKey = "Page Not Found";
        $this->metaDesc = "Page Not Found";
        $params = array();
        $this->render('error', $params);
    }
}
