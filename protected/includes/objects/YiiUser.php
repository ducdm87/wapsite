<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class YiiUser {

    private $items = array();
    private $item = array();
    private $active = 0;
    private $user = null;
    private $arr_group = array();
    private $table = "{{users}}";

    function __construct() {
        $this->table = TBL_USERS;
    }

    static function & getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new YiiUser();
        }

        return $instance;
    }

    // lay tat ca user
    function getUsers($condition = null, $fields = "*", $order = "ID DESC ") {
        $tbl_user = YiiTables::getInstance(TBL_USERS);
        $loadColumn = false;
        if (trim($fields) != "*") {
            $_fields = explode(",", $fields);
            if (count($_fields) == 1)
                $loadColumn = true;
        }
        if ($loadColumn == false)
            $items = $tbl_user->loads($fields, $condition, $order, null);
        else
            $items = $tbl_user->loadColumn($fields, $condition, $order, null);
        return $items;
    }

    function getUser($cid, $field = "*") {
        $tbl_user = YiiTables::getInstance(TBL_USERS);
        $tbl_user->load($cid, $field);
        return $tbl_user;
    }

    function getGroups($condition = null, $fields = "*", $build_tree = false) {
        $tbl_group = YiiTables::getInstance(TBL_USERS_GROUP);
        $items = $tbl_group->loads($fields, $condition, "lft asc ", null);
        return $items;
    }

    function getGroup($cid, $field = "*") {
        if (isset($this->arr_group[$cid]))
            return $this->arr_group[$cid];
        $tbl_group = YiiTables::getInstance(TBL_USERS_GROUP, "id", true);
        $tbl_group->load($cid, $field);
        $this->arr_group[$cid] = $tbl_group;
        return $tbl_group;
    }

    function getUserInGroup($groupID = null, $fields = "*", $allSub = false, $orderBy = "id desc", $conds = null) {
        if ($allSub == false) {
            return $this->getUsers("groupID = $groupID", $fields, $orderBy);
        } else {
            $group = $this->getGroup($groupID);
            $_conds = " lft >= $group->lft AND rgt <= $group->rgt ";

            $tbl_group = YiiTables::getInstance(TBL_USERS_GROUP);
            $list_group = $tbl_group->loadColumn("id", $_conds, "lft asc ", null);
            $list_group = implode(",", $list_group);
            $conds = " groupID in($list_group) ";
            return $this->getUsers($conds, $fields, $orderBy);
        }
    }

    function loadGroup($conditions, $field = "*", $orderby = "") {
        $tbl_group = YiiTables::getInstance(TBL_USERS_GROUP);
        $item = $tbl_group->loadRow($field, $conditions, "", $orderby);
        return $tbl_group;
    }

    function loadUser($conditions, $field = "*", $orderby = "") {
        $tbl_user = YiiTables::getInstance(TBL_USERS);
        $item = $tbl_user->loadRow($field, $conditions, "", $orderby);
        return $tbl_user;
    }

    function login($username = "", $password = "", $remember = false) {
        global $mainframe, $user;

        $password = md5($password);
        $errorCode = 0;
        if ($mainframe->isBackEnd()) {

            $query = "SELECT u.*,g.lft,g.name groupname, g.backend "
                    . "FROM " . TBL_USERS_GROUP . " g right join " . TBL_USERS . " u ON g.id = u.groupID "
                    . " WHERE username = :username ANd password=:password AND u.status = 1 ";
            $conmmand = Yii::app()->db->createCommand($query);
            $conmmand->bindParam(':username', $username);
            $conmmand->bindParam(':password', $password);
            $result = $conmmand->queryRow();

            if (!$result) {
                YiiMessage::raseWarning("Invalid your usename or password");
                $errorCode = 1;
            } else {
                $query = "UPDATE " . TBL_USERS . " SET lastvisit = now() WHERE id = " . $result['id'];
                $command = Yii::app()->db->createCommand($query);
                $command->execute();
                foreach ($result as $field_name => $field_value) {
                    if (strpos($field_name, "_") === 0)
                        continue;
                    $this->$field_name = $field_value;
                }
                $user = Yii::app()->session['userbackend'] = $this;
                $mainframe->set("user", $this);
            }
        }else {
            $query = "SELECT * "
                    . "FROM " . TBL_USERS
                    . " WHERE username = :username ANd password=:password AND status = 1 AND isBlock = 0 ";
            $conmmand = Yii::app()->db->createCommand($query);
            $conmmand->bindParam(':username', $username);
            $conmmand->bindParam(':password', $password);
            $result = $conmmand->queryRow();
 
            if (!$result) {
                $errorCode = 1;
            } else {
                $result['suppliers'] = "";
                foreach ($result as $field_name => $field_value) {
                    if (strpos($field_name, "_") === 0)
                        continue;
                    $this->$field_name = $field_value;
                }
                $user = Yii::app()->session['userfront'] = $this;
                $mainframe->set("user", $this);
            }
        }
        
        return $errorCode;
    }

    function setLogin($cid, $isBackEnd = false) {
        global $mainframe, $user;       
        if ($isBackEnd == true) {
            $user = Yii::app()->session['userbackend'] = $this;
            $mainframe->set("user", $this);
        } else {
            $query = "SELECT * "
                    . "FROM " . TBL_USERS
                    . " WHERE id =  $cid";
            $conmmand = Yii::app()->db->createCommand($query);
            $result = $conmmand->queryRow();
            foreach ($result as $field_name => $field_value) {
                if (strpos($field_name, "_") === 0)
                    continue;
                $this->$field_name = $field_value;
            }
            $user = Yii::app()->session['userfront'] = $this;
            $mainframe->set("user", $this);
        }
    }

    function reloaUserLogin($isBackEnd = 1) {
        global $user;
        if ($isBackEnd) {

            $query = "SELECT u.*,g.lft,g.name groupname, g.backend "
                    . "FROM " . TBL_USERS_GROUP . " g right join " . TBL_USERS . " u ON g.id = u.groupID "
                    . " WHERE u.id = $this->id AND u.status = 1 ";
            $conmmand = Yii::app()->db->createCommand($query);
            $result = $conmmand->queryRow();

            if (!$result) {
                YiiMessage::raseWarning("Your account not have permission to visit backend");
                $this->redirect(Router::buildLink("users", array("view" => "user")));
            } else {
                $query = "UPDATE " . TBL_USERS . " SET lastvisit = now() WHERE id = " . $this->id;
                $command = Yii::app()->db->createCommand($query);
                $command->execute();
                foreach ($result as $field_name => $field_value) {
                    if (strpos($field_name, "_") === 0)
                        continue;
                    $this->$field_name = $field_value;
                }
                $user = Yii::app()->session['userbackend'] = $this;
            }
        }else {
            $query = "SELECT * "
                    . "FROM " . TBL_USERS
                    . " WHERE u.id = $this->id AND status = 1 AND verify = 1 ";
            $conmmand = Yii::app()->db->createCommand($query);
            $result = $conmmand->queryRow();

            if (!$result) {
                
            } else {
                $result['suppliers'] = "";
                foreach ($result as $field_name => $field_value) {
                    if (strpos($field_name, "_") === 0)
                        continue;
                    $this->$field_name = $field_value;
                }
                $user = Yii::app()->session['userfront'] = $this;
            }
        }
    }

    function logout($cid) {
        Yii::app()->user->logout();
        $link = Router::buildLink("users", array("view" => "user", 'layout' => 'login'));
        Yii::app()->getRequest()->redirect($link, true, 302);
    }

    function isLogin($cid = null) {
        if (isset($this->id) AND $this->id != 0)
            return true;
        return false;
    }

    function isLogout($cid = null) {
        
    }

    function isAdmin($cid = null) {
        if ($cid != null)
            $user = $this->getUser($cid);
        else
            $user = $this;

        if ($user->id > 0 AND $user->backend == 1)
            return true;
        return false;
    }

    function isLeader($cid = null) {
        if ($cid != null)
            $user = $this->getUser($cid);
        else
            $user = $this;

        if ($user->id > 0 AND $user->leader == 1)
            return true;
        return false;
    }

    function isSuperAdmin($cid = null) {
        if ($cid != null)
            $user = $this->getUser($cid);
        else
            $user = $this;

        $obj_group = $this->getGroup($user->groupID);
        if ($obj_group->parentID != 1) {
            return false;
        }
        return true;
    }

    function checkPermistion($arr_url) {
        
    }

    function removeGroup($id = null, $condition = "") {
        $table = YiiTables::getInstance(TBL_USERS_GROUP);
        $table->remove($id, $condition);
    }

    function removeUser($id = null, $condition = "") {
        $table = YiiTables::getInstance(TBL_USERS);
        $table->remove($id, $condition);
    }

    /*
     *  kiem tra xem userID co nam trong group la con cua user hien tai khong
     */

    function userChecking($userID) {
        $userID = (int) $userID;
        if ($userID == 0)
            return true;
        if ($this->id == $userID)
            return true;
        $tbl_user = YiiTables::getInstance(TBL_USERS, null, true);
        $tbl_user->load($userID);
        return $this->groupChecking($tbl_user->groupID);
    }

    /*
     *  kiem tra xem groupID co nam trong group la con cua user hien tai khong
     */

    function groupChecking($groupID) {
        $groupID = (int) $groupID;
        if ($groupID == 0)
            return true;
        if ($groupID == $this->groupID) {
            //     echo 'la 1 <hr />';
            return true;
        }
        $group = $this->getGroup($groupID);
        if ($this->groupID == $group->parentID) {
            //  echo 'trung parent <hr />';
            return true;
        }

        if ($group->id == 1) {
            //   echo 'Level 1 <hr />';
            return false;
        }

        return $this->groupChecking($group->parentID);
    }

    // kiem tra xem tai nguyen cua userID co cho user hien tai xem hay khong
    function viewChecking($userID) {
        $userID = (int) $userID;
        if ($userID == 0)
            return true;
        if ($this->id == $userID)
            return true;
        if ($this->userChecking($userID) == false)
            return false;
        return true;
    }

    /*
     * @Desc: kiem tra xem tai nguyen cua userID co cho user hien tai thay doi hay khong
     *      
     * $allowLeader = bool
     *      true: cho phep leader sua tai nguyen cua thanh vien cung nhom(cung level)
     *      false: khong cho phep leader sua tai nguyen cua thanh vien cung nhom(cung level)
     */

    function modifyChecking($userID, $allowLeader = false) {
        $copyright = (int)Yii::app()->params->copyright;
        if($copyright == 0) return true;
        $userID = (int) $userID;
        if ($userID == 0)
            return true;
        // sua tai nguyen cua chinh minh
        if ($this->id == $userID)
            return true;

        // sua tai nguyen cua nguoi khac
        if ($this->leader == false)
            return false; // khong la leader thi khong duoc sua cua nguoi khac

        $tbl_user = YiiTables::getInstance(TBL_USERS, null, true);
        $tbl_user->load($userID);

        if ($tbl_user->groupID == $this->groupID) { // neu nam trong cung 1 nhom            
            if ($allowLeader == false)
                return false;
        }

        // user nhom cha duoc sua tai nguyen user nhom con
        if ($this->groupChecking($tbl_user->groupID) == false)
            return false;

        return true;
    }

    function registration($data_post) {
        $tbl_user = YiiTables::getInstance(TBL_USERS, null, true);
        $cond = "mobile = '" . $data_post['mobile'] . "'";
        $bool = $tbl_user->getTotal($cond);
        if ($bool) {
            YiiMessage::raseNotice("Your telephone number is already registered");
            return false;
        }

        $cond = " username =  '" . $data_post['username'] . "'";
        $bool = $tbl_user->getTotal($cond);
        if ($bool) {
            YiiMessage::raseNotice("username is already registered");
            return false;
        }
        $data_post['password'] = md5($data_post['password']);
        $tbl_user->bind($data_post);
        $tbl_user->store();
        $this->setLogin($tbl_user->id);
    }

    function checkExisting() {
        
    }

}
