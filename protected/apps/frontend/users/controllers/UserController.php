<?php

class UserController extends FrontEndController {

    

    function init() {
        //$this->layout = "//benhvienphusan/default";
        parent::init();
    } 

    public function actionRegister() {
         die('ss');
        $data = array();
        $this->render('register', $data);  
    }
}
