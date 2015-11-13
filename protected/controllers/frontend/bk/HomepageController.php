<?php
class HomepageController extends FrontEndController {

    public function actionDisplay() {  
        $moduletophit = Yii::app()->getModule('tophits');
        
        // renders the view file 'protected/views/homepage/display.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->pageTitle = "Home page Display";
        $this->render('default', array("item" => "xin chao"));
    }
}
