<?php

class HomeController extends FrontEndController {

    function init() {
        parent::init();
    }

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 3,
            )
        );
    }

    public function actionDisplay() {
        global $user, $mainframe;
        if(!$mainframe->isLogin()){
            $this->redirect('/');
        }
        $this->render('profile');
    }

    public function actionRegister() {
        if (isset($_POST['submitform']))
            $this->registration();
        $data = array();

        $this->render('register', $data);
    }

    public function actionLogin() {
        if (isset($_POST['submitform'])) {
            $model = User::getInstance();
            if (!$model->login()) {
                $this->redirect('/');
            } else {
                $this->redirect(Router::buildLink('users'));
            }
        }
        $data = array();
        $this->render('login', $data);
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('/');
    }

    public function registration() {
        $model = User::getInstance();
        if (!$model->register()) {
            $this->redirect('');
        } else {
            $this->redirect(Router::buildLink('users'));
        }
    }
    

   
    public function actionChangeinfo() {
        global $mainframe, $user;
        if(!$mainframe->isLogin()){
            $this->redirect('/');
        }
        $this->render('changeinfo', $data);
    }
    public function actionChangepass() {
        global $mainframe, $user;
        if(!$mainframe->isLogin()){
            YiiMessage::raseNotice('Please login before change password !!!');
            $this->redirect('/');
        }
        
        if (isset($_POST['submitform'])) {
            $model = User::getInstance();
            if ($model->changepass()) {
                YiiMessage::raseSuccess('Change pass successfully !!!');
                $this->redirect(Router::buildLink('users'));
            }
        }
        
        $this->render('changepass');
    }

}
