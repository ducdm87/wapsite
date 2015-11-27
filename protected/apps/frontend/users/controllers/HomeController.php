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
        if (!$mainframe->isLogin()) {
            $this->redirect('/');
        }
        $this->render('profile');
    }

    public function actionRegister() {
        global $mainframe;
        if ($mainframe->isLogin()) {
            $this->redirect(Router::buildLink('users'));
        }
        if (isset($_POST['submitform']))
            $this->registration();
        
      $session = Yii::app()->session;
      $data_user = $session->get('data_user_register',array());       
       unset($session['data_user_register']);        
        $this->render('register', array("data_user"=>$data_user));
    }

    function actionCheckuser() {
        global $user;
        $username = Request::getVar('username', '');
        $obj_return = new stdClass();
        $obj_return->valid = false;
        if ($username == "")
            $obj_return->valid = false;
        else {
            $tbl_user = YiiTables::getInstance(TBL_USERS);
            $cond = " username =  '" . $username . "'";
            $bool = $tbl_user->getTotal($cond);
            if ($bool == false OR $bool == 0)
                $obj_return->valid = true;
        }

        echo json_encode($obj_return);
        die;
    }

    function actionCheckMobile() {
        global $user;
        $mobile = Request::getVar('mobile', '');
        $obj_return = new stdClass();
        $obj_return->valid = false;
        if ($mobile == "")
            $obj_return->valid = false;
        else {
            $tbl_user = YiiTables::getInstance(TBL_USERS);
            $cond = "mobile = '" . $mobile . "'";
            $bool = $tbl_user->getTotal($cond);
            if ($bool == false OR $bool == 0)
                $obj_return->valid = true;
        }

        echo json_encode($obj_return);
        die;
    }

    function actioncheCkcaptcha() {
        $captcha = Request::getVar('captcha', '');
        $obj_return = new stdClass();
        $obj_return->valid = false;

        $obj_captcha = Yii::app()->getController()->createAction("captcha");
        $obj_return->valid = strcasecmp($captcha, $obj_captcha->getVerifyCode()) === 0;
        $obj_return->valid = true;

        //$obj_return->code = $code;
        echo json_encode($obj_return);
        die;
    }

    public function actionLogin() {
        if (isset($_POST['submitform'])) {
            $model = User::getInstance();
            if (!$model->login()) {
                YiiMessage::raseNotice('Invalid username or password !!!');
                $this->redirect(Router::buildLink('users', array('layout' => "login")));
            } else {
                $this->redirect(Router::buildLink('users'));
            }
        }
        $data = array();
        $this->render('login', $data);
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Router::buildLink('users', array('layout' => 'login')));
    }

    public function registration() {
        $model = User::getInstance();
        
        $data_user = array(
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            're_password' => $_POST['re_password'],
            'mobile' => $_POST['mobile'],
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'captcha' => $_POST['captcha'],
            'status' => 1,
            'groupID' => 19
        );
         
        
        if (isset($_POST['meta']) && $_POST['meta']) {
            foreach ($_POST['meta'] as $meta_key => $meta_value) {
                $data_user[$meta_key] = $meta_value;
            }
        }
        
        if (!$model->register($data_user)) {
            Yii::app()->session['data_user_register'] = $data_user;             
            $this->redirect(Router::buildLink('users',array('layout'=>'register')));
        } else {
            $this->redirect(Router::buildLink('users'));
        }
    }

    public function actionChangeinfo() {
        global $mainframe, $user;
        if (!$mainframe->isLogin()) {
            $this->redirect(Router::buildLink('users', array('layout' => 'login')));
        }
        $this->render('changeinfo', $data);
    }

    public function actionChangepass() {
        global $mainframe, $user;
        if (!$mainframe->isLogin()) {
            YiiMessage::raseNotice('Please login before change password !!!');
            $this->redirect(Router::buildLink('users', array('layout' => 'login')));
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
