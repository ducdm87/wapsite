<?php

class UserController extends BackEndController {

    var $primary = 'id';
    var $tablename = "{{users}}";
    var $tbl_group = "{{users_group}}";

    function init() {
        parent::init();
    }

    function actionDisplay() {
        $this->addIconToolbar("Edit", Router::buildLink("user", array("view" => "user", "layout" => "edit")), "edit", 1, 1, "Please select a item from the list to edit");
        $this->addIconToolbar("New", Router::buildLink("user", array("view" => "user", "layout" => "new")), "new");
        //        $this->addIconToolbarDelete();
        $this->addIconToolbar("Delete", Router::buildLink("user", array("view" => "user", "layout" => "remove")), "trash", 1, 1, "Please select a item from the list to Remove");
        $this->addBarTitle("User <small>[list]</small>", "user");

        $task = Request::getVar('task', "");
        if ($task == "hidden" OR $task == 'publish' OR $task == "unpublish") {
            $cids = Request::getVar('cid');
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i];
                if ($task == "publish")
                    $this->changeStatus($cid, 1);
                else
                    $this->changeStatus($cid, 0);
            }
            YiiMessage::raseSuccess("Successfully saved changes status for users");
        }
        global $user;

        $model = new Users();
        $modelGroup = new Group();

        $groupID = $user->groupID;
        $group = $modelGroup->getItem($user->groupID);
        if ($group->parentID == 1) {
            $groupID = Request::getVar('filter_group', 0);
            if ($groupID == 0)
                $list_user = $model->getUsers(null, null, true);
            else
                $list_user = $model->getUsers($groupID);
        }else {
            $_groupID = Request::getVar('filter_group', 0);

            if ($_groupID == 0 OR $user->groupChecking($_groupID) == false)
                $list_user = $model->getUsers($groupID, null, true);
            else
                $list_user = $model->getUsers($_groupID);
        }
        $lists = $model->getList();

        $arr_group = $model->getGroups();

        $this->render('list', array("list_user" => $list_user, 'arr_group' => $arr_group, "lists" => $lists));
    }

    function changeStatus($cid, $value) {
        global $user;
        $groupID = $user->groupID;
        $obj_users = YiiUser::getInstance();
        $item_user = $obj_users->getUser($cid);

        if (!$bool = $user->modifyChecking($cid)) {
            YiiMessage::raseNotice("Your account not have permission to change status of this user: $item_user->username");
            $this->redirect(Router::buildLink("user", array('view' => 'user')));
            return false;
        }

        $item_user->status = $value;
        $item_user->store();
    }

    function actionCancel() {
        $this->redirect(Router::buildLink("user", array("view" => "user")));
    }

    function actionNew() {
        $this->actionEdit();
    }

    function actionEdit() {
        global $user;
        setSysConfig("sidebar.display", 0);
        $model = new Users();
        $cid = Request::getVar("cid", 0);

        if (is_array($cid))
            $cid = $cid[0];

        $this->addIconToolbar("Save", Router::buildLink("user", array("view" => "user", 'layout' => 'save')), "save");
        $this->addIconToolbar("Apply", Router::buildLink("user", array("view" => "user", 'layout' => 'apply')), "apply");

        if ($cid == 0) {
            $this->addIconToolbar("Cancel", Router::buildLink("user", array("view" => "user", 'layout' => 'cancel')), "cancel");
            $this->addBarTitle("User <small>[New]</small>", "user");
            $this->pageTitle = "New User";
        } else {
            $this->addIconToolbar("Close", Router::buildLink("user", array("view" => "user", 'layout' => 'cancel')), "cancel");
            $this->addBarTitle("User <small>[Edit]</small>", "user");
            $this->pageTitle = "Edit User";
        }

        $model = new Users();
        $model_resource = Resource::getInstance();

        $item = $model->getItem($cid);

        if (!$user->isSuperAdmin()) { // super duoc lam moi thu
            if ($item->id != 0) { // account da duoc tao
                if ($item->id != $user->id) { //ko phai chinh no
                    if (!$bool = $user->modifyChecking($item->id) OR $item->status != -1) {
                        // user leader nhom cha duoc sua user con khi no chua duoc active
                        YiiMessage::raseNotice("Your account not have permission to modify this account");
                        $this->redirect(Router::buildLink("cpanel"));
                    }
                }
            } else if ($user->leader == 0) { // tao moi va khong phai leader => chi super va leader cua nhom moi tao duoc acc moi
                YiiMessage::raseNotice("Your account not have permission to make account");
                $this->redirect(Router::buildLink("cpanel"));
            }
        }

        $arr_resource = $model_resource->getItems();
        $all_granted = $model->getGranted();

        $lists = $model->getListEdit($item);

        $this->render('edit', array("item" => $item, "lists" => $lists, 'arr_resource' => $arr_resource, "all_granted" => $all_granted));
    }

    function actionApply() {
        $userID = $this->store();
        YiiMessage::raseSuccess("User save succesfully");
        $this->redirect(Router::buildLink("user", array("view" => "user", 'layout' => 'edit', 'cid' => $userID)));
    }

    function actionSave() {
        $this->store();
        YiiMessage::raseSuccess("User save succesfully");
        $this->redirect(Router::buildLink("user", array("view" => "user")));
    }

    function store() {
        global $mainframe, $user;
        $post = $_POST;
        $id = Request::getVar("id", 0);
        $obj_users = YiiUser::getInstance();
        $item_user = $obj_users->getUser($id);

        if (!isset($_POST['username'])) {
            YiiMessage::raseWarning("Cannot save the user information");
            $this->redirect(Router::buildLink("user", array("view" => "user")));
        }

        $bool = true;
        $item_user->bind($post);
        $item_by_uname = $item_user->loadRow("*", "username = '$item_user->username'");


        if (trim($_POST['username']) == "") {
            YiiMessage::raseWarning("You must provide an username.");
            $bool = false;
        } else if ($_POST["changepassword"] != $_POST["repassword"] AND $_POST["changepassword"] != "") {
            YiiMessage::raseWarning("Passwords Do Not Match.");
            $bool = false;
        } else if (trim($_POST['email']) == "") {
            YiiMessage::raseWarning("You must provide an e-mail address.");
            $bool = false;
        } else if ($item_by_uname and $item_by_uname['id'] != $item_user->id) {
            YiiMessage::raseWarning("This username is already in use.");
            $bool = false;
        }

        if ($bool != false) {
            if (($_POST["changepassword"] == $_POST["repassword"] AND $_POST["changepassword"] != "")) {
                $item_user->password = md5($_POST["changepassword"]);
            }

            // kiem tra xem co duoc tao trong group do khong va gan la leader khong
            $modelGroup = new Group();
            $obj_user = YiiUser::getInstance();
            $group = $modelGroup->getItem($user->groupID);

            // khong phai la super admin
            if (!$user->isSuperAdmin()) { // super duoc lam moi thu
                if ($item_user->id != 0) { // account da duoc tao
                    if ($item_user->id != $user->id) { //ko phai chinh no
                        if (!$bool = $user->modifyChecking($item_user->id) OR $item_user->status != -1) {
                            // user leader nhom cha duoc sua user con khi no chua duoc active
                            YiiMessage::raseNotice("Your account not have permission to modify this account");
                            $this->redirect(Router::buildLink("cpanel"));
                        }
                    }
                } else if ($user->leader == 0) { // phai la leader
                    YiiMessage::raseNotice("Your account not have permission to make account");
                    $this->redirect(Router::buildLink("cpanel"));
                }
            }

            $item_user->store();

            if ($user->isSuperAdmin()) {
                $query = "DELETE FROM " . TBL_RSM_RESOURCE_XREF . " WHERE objectID = $item_user->id AND object_type = 1";
                Yii::app()->db->createCommand($query)->execute();
                if (isset($_POST['formPsermission'])) {
                    $list_permission = $_POST['formPsermission'];
                    $list_permission = json_decode($list_permission);

                    if (count($list_permission)) {
                        foreach ($list_permission->allow as $rsm_id) {
                            $query = "INSERT INTO " . TBL_RSM_RESOURCE_XREF . " "
                                    . "SET objectID = $item_user->id"
                                    . ", object_type = 1"
                                    . ", resourceID = $rsm_id"
                                    . ", value = 1";
                            Yii::app()->db->createCommand($query)->execute();
                        }
                        foreach ($list_permission->deny as $rsm_id) {
                            $query = "INSERT INTO " . TBL_RSM_RESOURCE_XREF . " "
                                    . "SET objectID = $item_user->id"
                                    . ", object_type = 1"
                                    . ", resourceID = $rsm_id"
                                    . ", value = 0";
                            Yii::app()->db->createCommand($query)->execute();
                        }
                    }
                }
            }

            YiiMessage::raseSuccess("Successfully saved changes to User: " . $item_user->username);
            return $item_user->id;
        }
    }

    public function actionLogin() {

        $LoginForm = Request::getVar("LoginForm");
        if (Request::getVar("LoginForm") and ($LoginForm['username'] == "" || $LoginForm['password'] == "")) {
            YiiMessage::raseWarning("Type your username and password");
            $this->redirect(Router::buildLink("user", array("view" => "user", 'layout' => 'login')));
            return;
        }

        $model = new UserForm();
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            $session_id = session_id();
            // validate user input and redirect to the previous page if valid  

            if ($model->validate() && $model->login()) {
                $this->afterLogin($session_id, session_id());
                $this->redirect(Router::buildLink("cpanel"));
//                    $this->redirect("/backend/");
            } else {
                YiiMessage::raseWarning("Invalid your usename or password");
            }
        }
        $this->layout = "//login";
        $this->pageTitle = "Page login";
        $this->render('login');
    }

    public function actionLogout() {
//        Yii::app()->session['userbackend'] = null;
        Yii::app()->user->logout();
        $this->redirect(Router::buildLink("user", array("view" => "user", 'layout' => 'login')));
    }

    function actionRemove() {
        global $user;

        $cids = Request::getVar("cid", 0);
        if (count($cids) > 0) {
            $obj_users = YiiUser::getInstance();
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i];
                $item_user = $obj_users->getUser($cid);
                if (!$user->isSuperAdmin()) { // neu khong phai super admin
                    if ($item_user->status != -1) { // neu != -1 thi khong duoc xoa
                        YiiMessage::raseNotice("Please contact your administrator,\"$item_user->username\" is active");
                        $this->redirect(Router::buildLink("user", array('view' => 'user')));
                        return false;
                    } elseif (!$bool = $user->modifyChecking($cid)) { // neu =-1 thi user leader nhom cha duoc xoa user con
                        YiiMessage::raseNotice("Your account not have permission to remove user: $item_user->username");
                        $this->redirect(Router::buildLink("user", array('view' => 'user')));
                        return false;
                    }
                }
                $obj_users->removeUser($cid);
            }
        }
        YiiMessage::raseSuccess("Successfully delete User(s)");
        $this->redirect(Router::buildLink("user", array("view" => "user")));
    }

    function actionTree() {
        global $user;
        $tmpl = Request::getVar('tmpl', null);
        $modelUser = new Users();
        $modelGroup = new Group();

        $this->addBarTitle("Users <small>[tree]</small>", "user");

        $groupID = Request::getVar('groupID', $user->groupID);
        $group = $modelGroup->getItem($user->groupID);

        if ($group->parentID != 1) {
            if (!$user->groupChecking($groupID)) {
                $group = $modelGroup->getItem($user->groupID);
                YiiMessage::raseNotice("Your account not have permission to visit page");
                $this->redirect(Router::buildLink("cpanel"));
            }
        }

        $group = $modelGroup->getItem($groupID);
        $list_user = $modelUser->getUsers($groupID, " leader DESC, id ASC ");
        $arr_group = $modelUser->getGroups($groupID);

        if ($tmpl == null)
            $this->render('tree', array("objGroup" => $group, "list_user" => $list_user, 'arr_group' => $arr_group));
        else if ($tmpl == 'app') {
            $this->render('treegroup', array("objGroup" => $group, "list_user" => $list_user, 'arr_group' => $arr_group));
            die;
        }
    }

}
