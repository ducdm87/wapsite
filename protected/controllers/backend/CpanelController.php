<?php

class CpanelController extends BackEndController {

    public function actionDisplay() {
        $this->pageTitle = "Home page Display";       
        $this->render('default', array("item" => "xin chao"));
    }
    public function actionAbc() {        
        // renders the view file 'protected/views/homepage/display.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->pageTitle = "Home page Display";
        $this->render('default', array("item" => "xin chao"));
    }
}
