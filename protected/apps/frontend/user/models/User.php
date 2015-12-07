<?php

class User extends CFormModel {

    var $tablename = "{{users}}";
    //var $tablenamesearch = "{{videos}}";
    var $tbl_resume = "{{rsm_resume}}";
    var $tbl_template = "{{rsm_template}}";
    var $default_groupID = 19;
    var $table_user_meta = "{{user_metas}}";
    //search
    var $tablenamesearch = "{{videos}}";
    var $table_categories = "{{categories}}";
//    var $table_episode = "{{episode}}";
//    var $table_like = "{{like}}";
    //end search

    var $str_error = "";
    var $db = "";
    var $user = null;
    var $_identity = null;
    private $command;
    private $connection;

    function __construct() {
        $this->default_groupID = DEFAULT_GROUPID;
//        dbuser
        $this->db = Yii::app()->db;
        $this->command = Yii::app()->db->createCommand();
        $this->connection = Yii::app()->db;
    }

    static function getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new User();
        }
        return $instance;
    } 

    function login() {
        $username = Request::getVar('username', '');
        $password = Request::getVar('password', '');
        $remembre = Request::getVar('remembre', 0);

        $tbl_user = YiiUser::getInstance();
        $erCode = $tbl_user->login($username, $password);
        if ($erCode) {
            return false;
        }

        $app = Yii::app();
        if ($remembre === 0) {
            $cookie = new CHttpCookie('remember_user', 0, array("expire" => time() - 1));
            $app->getRequest()->getCookies()->add($cookie->name, $cookie);
        } else {
            $timeout = isset(Yii::app()->params->timeout2)?Yii::app()->params->timeout2:43200; // 30 ngay
            $duration = time() + $timeout * 60; // 30 days
            $cookie = new CHttpCookie('remember_user', 1, array("expire" => $duration));
            $app->getRequest()->getCookies()->add($cookie->name, $cookie);
        }

        return true;
    }

    function register($data_user) {
        global $mainframe;
        
        $captcha = Request::getVar('captcha', null);

        $obj_captcha = Yii::app()->getController()->createAction("captcha");
        
        if ($obj_captcha->validate($captcha,0) == false) {
            YiiMessage::raseNotice("Please enter verify code");
            return false;
        }
 
        if ($_POST['password'] == "") {
            YiiMessage::raseNotice("Please enter password");
            return false;
        }
        if ($_POST['phone'] == "") {
            YiiMessage::raseNotice("Please enter your mobile");
            return false;
        }

        if (Request::getVar('agree', null) == null) {
            YiiMessage::raseNotice("You must agree to Our Terms of Service.");
            return false;
        }

        $tbl_user = YiiUser::getInstance();
        if (!$tbl_user->registration($data_user)) {
            return false;
        }
        return true;
    }

    
    
    
    
    function forgotPass($email) {
        global $mainframe;
        $db = $this->db;
        $query = "SELECT count(*) FROM " . $this->tablename . " WHERE email=:email";
        $query_command = $db->createCommand($query);
        $query_command->bindParam(':email', $email);
        $bool = $query_command->queryScalar();
        // check email existing
        if ($bool < 1) {
            $this->str_error = "Oh, sorry! We couldn't find $email in my system. Please try again.";
            return false;
        }


        $titlemail = 'Your password on ' . WEB_SITE . ' was changed';
        $body_email = 'As requested, here is a link to allow you to select a new ' . WEB_SITE . ' password: ';
        $random_reset = md5(uniqid($email));
        $activeCode = trim($random_reset) . ':' . mktime();
        $link_reset = WEB_URL . Yii::app()->controller->createUrl("/user/resetpassword") . "?t=$random_reset";

        $query = "UPDATE " . $this->tablename . " SET activeCode=:activeCode WHERE email=:email";
        $query_command = $db->createCommand($query);
        $query_command->bindParam(':email', $email);
        $query_command->bindParam(':activeCode', $activeCode);
        $query_command->execute();
        $body_email .= '<br /> <br /> <a href="' . $link_reset . '" >' . $link_reset . '</a>. <br /> <br /> This link is only available in 24 hours';
        $mainframe->sendMail('no-reply@' . WEB_SITE, $email, $titlemail, $body_email);
        return true;
        ;
        // send email
    }
  
    function resetPass($newpassword, $repassword) {
        $db = $this->db;
        if ($newpassword == "") {
            $this->str_error = "Type new password";
            return FALSE;
        }
        if ($newpassword !== $repassword) {
            $this->str_error = "Type verifi password";
            return FALSE;
        }
        $query = "UPDATE " . $this->tablename . " SET password = :password, activeCode='' WHERE id = " . $this->user['id'];
        $query_command = $db->createCommand($query);
        $pw = md5($newpassword);
        $query_command->bindParam(':password', $pw);
        $query_command->execute();
        return true;
    }

    function changepass() {
        global $mainframe;
        
        $user = $mainframe->getUser();
          
        $db = $this->db;
        $password = Request::getVar("password");
        $newpassword = Request::getVar("new-password");
        $renewpassword = Request::getVar("renew-password");
        
        if ($password != "") {
            if (md5($password) != $user->password) {
                YiiMessage::raseNotice('Type old password !!!');
                return FALSE;
            }
        }

        if ($newpassword == "") {
            YiiMessage::raseNotice('Type new password !!!');
            return FALSE;
        }

        if ($newpassword !== $renewpassword) {
            YiiMessage::raseNotice('Type verifi password !!!');
            return FALSE;
        }
 
        $tbl_user = YiiTables::getInstance(TBL_USERS, null, true);
        $tbl_user->load($user->id);
        $tbl_user->password = md5($newpassword);
        $tbl_user->store();
        
        return true;
    } 

     
}
