<?php

class User extends CFormModel {

    var $tablename = "{{users}}";
    var $tbl_resume = "{{rsm_resume}}";
    var $tbl_template = "{{rsm_template}}";
    var $default_groupID = 19;
    var $table_user_meta = "{{user_metas}}";
    var $str_error = "";
    var $db = "";
    var $user = null;
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

    function getAccountInfo() {
        global $mainframe, $db;
        $user = $mainframe->getUser();

        $query = "SELECT count(*) FROM  " . $this->tbl_resume . " WHERE user_id = " . $mainframe->getUserID() . " AND status = 1 ";

        $query = "SELECT count(*) FROM  " . $this->tbl_resume . " a, " . $this->tbl_template . " b "
                . "WHERE a.template_id = b.id AND a.user_id = " . $mainframe->getUserID() . " AND a.status = 1 AND b.status = 1 ";
        $conmmand = $db->createCommand($query);
        return $conmmand->queryScalar();
    }

    function check_login($data) {
        $command = Yii::app()->db->createCommand()
                ->select('*')
                ->from($this->tablename);
        $command->where(
                array(
            'AND',
            'username = :username',
            'password =:password',
            'status=:status'
                ), array(
            ':username' => $data['username'],
            ':password' => $data['password'],
            ':status' => 1
                )
        );
        $result = $command->queryRow();
        return $result;
    }

    function userRegister($data) {
        $transaction = $this->connection->beginTransaction();
        try {
            $this->command->insert($this->tablename, $data['user']);
            $user_id = $this->connection->getLastInsertID();
            if (isset($data['user_meta']) && $data['user_meta']) {
                foreach ($data['user_meta'] as $meta_data) {
                    if (isset($meta_data) && $meta_data) {
                        foreach ($meta_data as $meta_key => $meta_value) {
                            $meta = array(
                                'meta_key' => $meta_key,
                                'meta_value' => $meta_value,
                                'user_id' => $user_id,
                            );
                            $this->command->insert($this->table_user_meta, $meta);
                        }
                    }
                }
            }
            return $transaction->commit();
        } catch (Exception $exc) {
            Yii::log('Error! :', var_export($exc->getMessage()));
            return $transaction->rollback();
        }
    }

    function register($email, $password, $country) {
        global $mainframe;

        $db = $this->db;

        $time = mktime();
        $activeCode = md5($email . ':' . md5($password) . ':' . $time);
        $activeCodeStore = $activeCode . ':' . $time;

        $name = preg_replace("/\@.*$/ism", '', $email);
        // check existing
        $query = "SELECT * FROM " . $this->tablename . " WHERE email =:email";
        $query_command = $db->createCommand($query);
        $query_command->bindParam(':email', $email);
        $user = $query_command->queryRow();
        if ($user != false) {
            $this->str_error = "Your email is existing";
            return false;
        } else {

            $query = "INSERT INTO " . $this->tablename .
                    " SET first_name=:first_name, email =:email , password =:password, countrycode=:countrycode"
                    . ",verify = 1, status = 1, register_time = " . mktime();

            $query_command = $db->createCommand($query);
            $query_command->bindParam(':first_name', $name);
            $query_command->bindParam(':email', $email);
            $query_command->bindParam(':countrycode', $country);
            $pw = md5($password);
            $query_command->bindParam(':password', $pw);
            $return = $query_command->execute();
            $userID = $db->lastInsertID;

            $query = "SELECT * FROM  " . $this->tablename . " WHERE id= $userID";
            $query_command = $db->createCommand($query);

            $result = $query_command->queryRow();
            $result['suppliers'] = "";
            Yii::app()->session['userfront'] = $result;
            $mainframe->set("user", $result);
        }

//        $_link_active = 'http://' . WEB_SITE . CController::createUrl("/user/active");
//        $link_active = $_link_active . "/$activeCode";
//        $message = 'Dear ' . $name;
//        $message .= "<br /> You are register an account effect members on the <b>" . WEB_SITE . "</b>. "
//                . '<br /> Please review this e-mail in its entirety as it contains important information.';
//        $message .= "<br /> " . "To confirm the information an account, please go to the path following:";
//        $message .= " <br /> <br /> <a href='" . $link_active . "' > " . $_link_active . "</a> <br /> <br />";
//        $message .= " <br /> After being click this path, your account is active, and you will be logged on automatically on <b>" . WEB_SITE . "</b>";
//        $message .= " <br /> This path is only be used 1 times to active and timeout after <b style='color: red; '>".TIME_OUT_ACTIVE_ACCOUNT. " " . TIME_OUT_ACTIVE_UNIT ."</b> ";
//        $message .= " <br /> Thank you for signing up to <b>" . WEB_SITE . "</b>";
//        $mainframe->sendMail(MAILFROM, $email, "Welcome To " . WEB_SITE, $message);
        return $return;
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

    function checkActiveCode($random_reset) {
        global $mainframe;
        $db = $this->db;
        $query = "SELECT * FROM " . $this->tablename . " WHERE activeCode like :activeCode";
        $query_command = $db->createCommand($query);
        $activeCode = $random_reset . ":%";
        $query_command->bindParam(':activeCode', $activeCode);
        if (!$row = $query_command->queryRow()) {
            return false;
        }

        $activeCode = $row['activeCode'];
        $activeCode = explode(':', $activeCode);
        $time = mktime() - $activeCode[1];

        if ($time > 86400) {
            return -1;
        }
        $this->user = $row;
        return true;
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
        if (!$mainframe->isLogin()) {
            $this->str_error = "Please login before change password !!!";
            return FALSE;
        }
        $user = $mainframe->getUser();

        $db = $this->db;
        $dataForm = Request::getVar("ChangepassForm");

        if ($user['password'] != "") {
            if (md5($dataForm['password']) != $user['password']) {
                $this->str_error = "Type old password";
                return FALSE;
            }
        }

        if ($dataForm['new-password'] == "") {
            $this->str_error = "Type new password";
            return FALSE;
        }

        if ($dataForm['re-password'] !== $dataForm['new-password']) {
            $this->str_error = "Type verifi password";
            return FALSE;
        }

        $query = "UPDATE " . $this->tablename . " SET password = :password WHERE id = " . $user['id'];
        $pw = md5($dataForm['new-password']);
        $query_command = $db->createCommand($query);
        $query_command->bindParam(':password', $pw);
        $query_command->execute();

        $user['password'] = $pw;
        Yii::app()->session['userfront'] = $user;
        $mainframe->set("user", $user);
        return true;
    }

    function changepass1() {
        global $mainframe, $db;
        $user = $mainframe->getUser();

        $dataForm = Request::getVar("ChangepassForm");
        if ($user['suppliers'] == "" OR $user['password'] != "") {
            if ($dataForm["password"] == "") {
                $this->str_error = "Type old password";
                return FALSE;
            }

            $pass = md5($dataForm["password"]);
            if ($pass !== $user['password']) {
                $this->str_error = "Old password is false";
                return FALSE;
            }
        }

        if ($dataForm['new-password'] == "") {
            $this->str_error = "Type new password";
            return FALSE;
        }

        if ($dataForm['re-password'] !== $dataForm['new-password']) {
            $this->str_error = "Type verifi password";
            return FALSE;
        }

        $query = "UPDATE " . $this->tablename . " SET password = :password WHERE id = " . $user['id'];
        $query_command = $db->createCommand($query);
        $pw = md5($dataForm['new-password']);
        $query_command->bindParam(':password', $pw);
        $query_command->execute();

        $user['password'] = md5($dataForm['new-password']);
        Yii::app()->session['userfront'] = $user;
        $mainframe->set("user", $user);
        return true;
    }

    function check_user($username) {
        $db = $this->db;
        $query = "SELECT * FROM " . $this->tablename . "  WHERE username=:username";
        $query_command = $db->createCommand($query);
        $query_command->bindParam(':username', $username);
        $result = $query_command->queryRow();

        return $result;
    }
}
