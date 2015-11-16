<?php

class HomeController extends BackEndController {

    

    function init() {
//        $this->layout = "//benhvienphusan/default";
        parent::init();
    } 

    function actionDisplay(){
        $this->pageTitle = "Home page Display";       
        $this->render('default', array("item" => "xin chao"));
    } 
}
