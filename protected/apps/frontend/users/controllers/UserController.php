<?php
class UserController extends FrontEndController {
    function init() {
        parent::init();
    } 
    public function actionRegister() {
        die('ss');
        $data = array();
        $this->render('register', $data);  
    }
    public function actionLogin() {
        die('ss');
        $data = array();
        $this->render('login', $data);  
    }
}
