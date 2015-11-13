<?php

class UserController extends FrontEndController {

    public $item = array();
    public $tablename = "{{users}}";
    public $table_group = "{{users_group}}";
    public $primary = "id";

    function init() {
//echo $this->createUrl('cpanel/display');die;
        $this->item["id"] = 0;
        $this->item["username"] = "";
        $this->item["password"] = "";
        $this->item["email"] = "";
        $this->item["groupID"] = "";
        $this->item["mobile"] = "";
        $this->item["home_phone"] = "";
        $this->item["first_name"] = "";
        $this->item["first_name"] = "";
        $this->item["last_name"] = "";
        $this->item["address"] = "";
        $this->item["city"] = "";
        $this->item["province_state"] = "";
        $this->item["zip_code"] = "";
        $this->item["country"] = "";
        $this->item["status"] = 1;
        $this->item["cdate"] = "";
        $this->item["mdate"] = "";
        $this->item["lastvisit"] = "";
        $this->item["params"] = "";
        parent::init();
    }

    public function actionDisplay() {
        $this->pageTitle = "Home page Display";
        $this->render('default', array("item" => "xin chao"));
        ;
    }

    public function actionLogin() {
        // collect user input data
//        YiiMessage::raseWarning("Type your email and password");
        if (Request::getVar('LoginForm', "")) {
            global $mainframe, $db;
            $model = new UserForm();
            $LoginForm = Request::getVar("LoginForm");
            $bool = true;
            $_POST['LoginForm']['rememberMe'] = 1;
            $model->attributes = $_POST['LoginForm'];
            $str_error = "";
            $session_id = session_id();
            if ($LoginForm['username'] == "" || $LoginForm['password'] == "") {
                $str_error = "Type your email and password";
                $bool = false;
            } else if ($model->validate() && $model->login()) {
                // validate user input and redirect to the previous page if valid
                $this->afterLogin($session_id, session_id());
            } else {
                $str_error = ("Invalid your usename or password");
                $bool = false;
            }
            
            $obj_result = new stdClass();
            $obj_result->result = $bool;
            $obj_result->str_error = $str_error;
            if ($bool == true) {
                $model = User::getInstance();
                $user = $mainframe->getUser();
                $obj_result->total_resume = $model->getAccountInfo();
                $obj_result->full_name = ucwords($user["first_name"]) . " " . ucwords($user['last_name']);
            }
            $obj_json = json_encode($obj_result);
            echo $obj_json;
            die;
        }

        $this->pageTitle = "Page login";
//        ResumeController::actionDisplay();
        $_REQUEST['enablepopup'] = 1;
        $_REQUEST['popuptype'] = "popup-login";
        $_REQUEST['pagetitle'] = "Login";
        $_REQUEST['scriptcommand'] = '$("div.popup-login").css({top: "60px"})';
        $this->forward("resume/display");
//        $this->render('login');
    }

    public function actionRegister() {
        global $mainframe;
        if (Request::getVar('registerForm', "")) {
            $model = User::getInstance();
            $registerForm = Request::getVar("registerForm");
            $bool = true;
            $str_error = "";

            $obj_result = new stdClass();
            $reg_email = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/ism';
            if ($registerForm['email'] == "") {
                $str_error = "Please Type your email";
                $bool = false;
            } else if (!preg_match($reg_email, $registerForm['email'])) {
                $str_error = "Invalid format email! ";
                $bool = false;
            } else if ($registerForm['password'] == "") {
                $str_error = "Please Type your password";
                $bool = false;
            } else if ($registerForm['re-password'] == "" || $registerForm['re-password'] != $registerForm['password']) {
                $str_error = "Password do not matches";
                $bool = false;
            } else {
                if ($resutl = $model->register($registerForm['email'], $registerForm['password'], $registerForm['country'])) {
                    $obj_result->str_message = "Your account was create successfully. Thanks !!! ";
                    $user = $mainframe->getUser();
                    $obj_result->total_resume = $model->getAccountInfo();
                    $obj_result->full_name = ucwords($user["first_name"]) . " " . ucwords($user['last_name']);
                } else {
                    $bool = false;
                    $str_error = $model->str_error;
                }
            }
            $obj_result->result = $bool;
            $obj_result->str_error = $str_error;
            $obj_json = json_encode($obj_result);
            echo $obj_json;
            die;
        }

        $_REQUEST['enablepopup'] = 1;
        $_REQUEST['popuptype'] = "popup-register";
        $_REQUEST['pagetitle'] = "Register";
        $_REQUEST['scriptcommand'] = '$("div.popup-register").css({top: "60px"})';
        $this->forward("resume/display");
    }

    function actionForgotpass() {
        if (Request::getVar('email', "")) {
            $email = Request::getVar("email");
            $model = User::getInstance();
            $bool = $model->forgotPass($email);

            if ($bool == false) {
                $obj_result->str_error = $model->str_error;
            } else {
                $obj_result->str_message = "We sent instructions for resetting your password to $email.  !!!";
            }
            $obj_result->result = $bool;
            $obj_json = json_encode($obj_result);
            echo $obj_json;
            die();
        }

        $this->pageTitle = "Page login";
//        ResumeController::actionDisplay();
        $_REQUEST['enablepopup'] = 1;
        $_REQUEST['popuptype'] = "popup-forgot-password";
        $_REQUEST['pagetitle'] = "Forgot Password";
        $_REQUEST['scriptcommand'] = '$("div.popup-forgot-password").css({top: "60px"})';
        $this->forward("resume/display");
    }

    function actionResetpassword() {
        $activeCode = Request::getVar('t', '');
        $model = User::getInstance();
        
        $bool = $model->checkActiveCode($activeCode);
        if (Request::getVar('type', '') == "ajax") {            
            $obj_result = new stdClass();
            if ($bool == false OR $bool === -1) {
                $obj_result->result = false;
                $obj_result->str_error = "You have not permission or Your link is too long time";
            } else {
                $newpassword = Request::getVar('newpassword', '');
                $repassword = Request::getVar('repassword', '');
                $bool = $model->resetPass($newpassword, $repassword);
                if ($bool == false) {
                    $obj_result->result = false;
                    $obj_result->str_error = $model->str_error;
                } else {
                    $obj_result->result = true;
                    $obj_result->str_message = 'Password reset successfully !!!';
                }
            }
            $obj_json = json_encode($obj_result);
            echo $obj_json;
            die;
        }
        
        if ($bool == false) {
            $this->redirect('/');
        }
        if ($bool === -1) {
            $this->redirect(Yii::app()->controller->createUrl('/user/forgot-password'));
        }

        $this->pageTitle = "Reset password";
        $_REQUEST['enablepopup'] = 1;
        $_REQUEST['popuptype'] = "resetpass";
        $_REQUEST['pagetitle'] = "Reset password";
        $_REQUEST['scriptcommand'] = '$("div.popup-resetpass").css({top: "60px"})';
        $this->forward("resume/display");
    }

    function actionChangepass() {        
        if (Request::getVar('ChangepassForm', "")) {
            
            $ChangepassForm = Request::getVar("ChangepassForm");
            $model = User::getInstance();
            $bool = $model->changepass();
            
            if ($bool == false) {
                $obj_result->str_error = $model->str_error;
            } else {
                $obj_result->str_message = "Password change successfully !!!";
            }
            $obj_result->result = $bool;
            $obj_json = json_encode($obj_result);
            echo $obj_json;
            die();
        }

        $this->pageTitle = "Page login";
//        ResumeController::actionDisplay();
        $_REQUEST['enablepopup'] = 1;
        $_REQUEST['popuptype'] = "popup-changepass";
        $_REQUEST['pagetitle'] = "Change password";
        $_REQUEST['scriptcommand'] = '$("div.popup-changepass").css({top: "60px"})';
        $this->forward("resume/display");
    }

    public function actionLogout() {
        Yii::app()->session['userfront'] = null;
//        Yii::app()->user->logout();
        $this->redirect("/");
//        $this->redirect($this->createUrl('login'));
    }

}
