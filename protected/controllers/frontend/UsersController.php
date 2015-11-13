<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UsersController extends FrontEndController {

    var $user;

    function init() {
        parent::init();
        $this->layout = false;
        $this->user = User::getInstance();
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
        $this->render('register', array(
        ));
    }

    public function actionLogin() {
        $this->render('login', array());
    }

    public function actionCheckLogin() {
        $user = User::getInstance();
        if (isset($_POST) && $_POST) {
            $data = array(
                'username' => $_POST['username'],
                'password' => md5($_POST['password'])
            );
            if ($user_data = $user->check_login($data)) {
                $this->set_userdata($user_data);
                $this->redirect('/app');
            } else {
                $this->redirect('/users/login');
            }
        }
    }

    public function actionCreate() {
        if (isset($_POST) && $_POST) {
            $data['user'] = array(
                'username' => $_POST['username'],
                'password' => md5($_POST['password']),
                'mobile' => $_POST['phone'],
                'first_name' => $_POST['firstname'],
                'last_name' => $_POST['lastname'],
                'status' => 1,
                'groupID' => 19
            );
            if (isset($_POST['meta']) && $_POST['meta']) {
                foreach ($_POST['meta'] as $meta_key => $meta_value) {
                    $data['user_meta'][] = array($meta_key => $meta_value);
                }
            }
            if (!$this->user->userRegister($data)) {
                $this->set_userdata($_POST);
                $this->redirect('/app');
            } else {
                $this->redirect('/users');
            }
        }
    }

    /**
     * set Session
     */
    private function set_userdata($data) {
        $session = Yii::app()->session;
        if (!isset($session['user_data']) || count($session['user_data']) == 0) {
            $session['user_data'] = $data;
        }
        return $session;
    }

    public function actionCheckUser() {
        $ivalid = true;
        if (!$this->user->check_user($_GET['username'])) {
            $ivalid = true;
        } else {
            $ivalid = false;
        }
        echo json_encode(array('valid' => $ivalid,));
    }

    public function actionProfile() {
        $session = Yii::app()->session->get('user_data');
        $this->render('profile', array('user'=>$session));
    }

    public function actionLogout() {
        Yii::app()->session->destroy();
        $this->redirect('/app');
    }

    public function actionCheckCaptcha() {
        $captcha = Yii::app()->getController()->createAction("captcha");

        $code = $captcha->verifyCode;

        $ivalid = true;

        if ($code === $_GET['captcha']) {
            $ivalid = true;
        } else {
            $ivalid = false;
        }
        echo json_encode(array('valid' => $ivalid,));
    }

}
