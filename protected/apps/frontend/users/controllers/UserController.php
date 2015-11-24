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
                YiiMessage::raseWarning("Kiểm tra lại thông tin vừa đăng nhập.");
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
    
    
    public function actionCreate() {
         $user = User::getInstance();
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
            
            if (!$user->userRegister($data)) {
                $this->set_userdata($_POST);
                $this->redirect('/app');
            } else {
                $this->redirect('/users');
            }
        }
    }
    
    public function actionProfile() {
        $session = Yii::app()->session->get('user_data');
        $this->render('profile', array('user'=>$session));
    }
    //tim kiem
    public function actionSearch() {
        $media = User::getInstance();
        $data = array();

        if (isset($_GET['q']) && $_GET['q']) {
            $data['videos'] = $media->getMedias(0, 0, array('m.status' => 1), $_GET['q']);
        } else {
            $this->redirect('/app');
        }
        $this->render('default', $data);
    }
}
