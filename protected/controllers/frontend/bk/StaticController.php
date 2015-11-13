<?php

class StaticController extends FrontEndController {
    function init() {
        $this->layout = "//resume/default";
        parent::init();
    }

    public function actionDisplay() {
       
    }
    
     public function actionAbout() {
        $this->render('//resume/tpl/about',array());
    }
     public function actionContact() {
        $this->render('//resume/tpl/contact',array());
    }
     public function actionResource() {
        $this->render('//resume/tpl/resource',array());
    }
}
