<?php
class UserController extends FrontEndController {
    function init() {
        parent::init();
    } 
    public function actionRegister() {
        $data = array();
        $this->render('register', $data);  
    }
    public function actionLogin() {
        $data = array();
        $this->render('login', $data);  
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
     public function actionCheckLogin() {
        $user = User::getInstance();
        if (isset($_POST) && $_POST) {
            $data = array(
                'username' => $_POST['username'],
                'password' => md5($_POST['password'])
            );
            if ($user_data = $user->check_login($data)) {
                $this->set_userdata($user_data);
                $this->redirect("/app");
            } else {
                YiiMessage::raseWarning("Passwords Do Not Match.");
                $this->redirect(Router::buildLink("users", array("view"=>"user",'layout'=>'login')));
            }
        }
    }
    private function set_userdata($data) {
        $session = Yii::app()->session;
        if (!isset($session['user_data']) || count($session['user_data']) == 0) {
            $session['user_data'] = $data;
        }
        return $session;
    }
      public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Router::buildLink("users", array("view"=>"user",'layout'=>'login')));
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
