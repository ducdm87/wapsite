<?php

class UsersController extends BackEndController {

    var $primary = 'id';
    var $tablename = "{{users}}";
    var $tbl_group = "{{users_group}}"; 

    function init() {
        parent::init();
        yii::import('application.models.backend.users.*');          
    }

    public function actionDisplay() {

//        $this->addIconToolbar("logout", $this->createUrl("/users/logout"),"cancel");
        $this->addIconToolbar("Edit", $this->createUrl("/users/edit"), "edit", 1, 1, "Please select a item from the list to edit");
        $this->addIconToolbar("New", $this->createUrl("/users/new"), "new");
//        $this->addIconToolbarDelete();
        $this->addIconToolbar("Delete", $this->createUrl("/users/remove"), "trash", 1, 1, "Please select a item from the list to Remove");        
        $this->addBarTitle("User <small>[list]</small>", "user");

        $task = Request::getVar('task', "");
        if ($task == "hidden" OR $task == 'publish' OR $task == "unpublish") {
            $cids = Request::getVar('cid');
            for ($i = 0; $i < count($cids); $i++) {
                $cid = $cids[$i];
                $item = $this->loadItem($cid, "id", $this->tablename);

                if ($item['status'] == 0)
                    $item['status'] = 1;
                else if ($item['status'] == 1)
                    $item['status'] = 2;
                else if ($item['status'] == 2)
                    $item['status'] = 0;

                $this->storeItem($item, $this->tablename);
            }
            YiiMessage::raseSuccess("Successfully saved changes status for users");
        }



        $model = new Users();
        $list_user = $model->getUsers();
        $arr_group = $model->getGroups();

//        $this->pageTitle = "Home page Display";        
        $this->render('users', array("list_user" => $list_user, 'arr_group' => $arr_group));
    }
 

    function actionCancel() {
        $this->redirect($this->createUrl('users/'));
    }

    function actionNew() {
        $this->actionEdit();
    }

    function actionEdit() {
        setSysConfig("sidebar.display", 0); 
        $model = new Users();
        $cid = Request::getVar("cid", 0);

        if (is_array($cid))
            $cid = $cid[0]; 

        $this->addIconToolbar("Save", $this->createUrl("/users/save"), "save");
        $this->addIconToolbar("Apply", $this->createUrl("/users/apply"), "apply");
  
        if ($cid == 0) {
            $this->addIconToolbar("Cancel", $this->createUrl("/users/cancel"), "cancel");
            $this->addBarTitle("User <small>[New]</small>", "user");        
            $this->pageTitle = "New User";
        }else{
            $this->addIconToolbar("Close", $this->createUrl("/users/cancel"), "cancel");
            $this->addBarTitle("User <small>[Edit]</small>", "user");        
            $this->pageTitle = "Edit User";           
        }

        $model = new Users();
        $item = $model->getItem($cid) ;       
         
        $list = $model->getListEdit($item);

        $this->render('edit', array("item" => $item,"list" => $list));
    }

    function actionApply() {
        $userID = $this->storeUser();
        $this->redirect($this->createUrl('users/edit') . "?cid=" . $userID);
    }

    function actionSave() {
        $this->storeUser();
        $this->redirect($this->createUrl('users/'));
    }

    function storeUser() {
        global $mainframe;
        $post = $_POST;
        $id = Request::getVar("id", 0);
        $obj_users = YiiUser::getInstance();
        $item_user = $obj_users->getUser($id);
       
        if (!isset($_POST['username'])) {
            YiiMessage::raseWarning("Cannot save the user information");
            $this->redirect($this->createUrl('users/'));
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
            if(($_POST["changepassword"] == $_POST["repassword"] AND $_POST["changepassword"] != "")){
                $item_user->password = md5($_POST["changepassword"]);
            }
           
            YiiMessage::raseSuccess("Successfully saved changes to User: " . $item_user->username);
            $item_user->store();
            return $item_user->id;
        }
    }
    
    public function actionLogin() {
        
        $LoginForm = Request::getVar("LoginForm");
        if (Request::getVar("LoginForm") and ($LoginForm['username'] == "" || $LoginForm['password'] == "")) {
            YiiMessage::raseWarning("Type your username and password");
            $this->redirect(Yii::app()->createUrl("users/login"));
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
                $this->redirect($this->createUrl('cpanel/display'));
//                    $this->redirect("/backend/");
            } else {
                YiiMessage::raseWarning("Invalid your usename or password");
            }
        }
        $this->pageTitle = "Page login";
        $this->render('login');
    }
    
     public function actionLogout() {
//        Yii::app()->session['userbackend'] = null;
        Yii::app()->user->logout();
        $this->redirect($this->createUrl('login'));
    }
    
    function actionRemove()
    {
        $cids = Request::getVar("cid", 0);
        if(count($cids) >0){
            $obj_table = YiiUser::getInstance();
            for($i=0;$i<count($cids);$i++){
               $obj_table->removeUser($cids[$i]);
            }
        }
        YiiMessage::raseSuccess("Successfully delete User(s)");
        $this->redirect($this->createUrl('users/'));
    }
    
}
