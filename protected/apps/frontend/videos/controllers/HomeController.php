<?php

class HomeController extends FrontEndController {

    public $item = array();
    public $tablename = "{{gx_info}}";
    public $primary = "id";
    public $scopenews = "tin-kinh-te";

    function init() { 
        parent::init();
    } 

    public function actionDisplay() {
        $this->redirect("/");
    }
}
