<?php

class UserController extends BackEndController {

    var $primary = 'id';
    var $tablename = "{{users}}";
    var $tbl_group = "{{users_group}}"; 


    function init() {
        parent::init();
    } 

    function actionDisplay(){ 
            $this->addIconToolbar("Edit", Router::buildLink("users", array("view"=>"user", "layout"=>"edit")), "edit", 1, 1, "Please select a item from the list to edit");
            $this->addIconToolbar("New", Router::buildLink("users", array("view"=>"user", "layout"=>"new")), "new");
    //        $this->addIconToolbarDelete();
            $this->addIconToolbar("Delete", Router::buildLink("users", array("view"=>"user", "layout"=>"remove")), "trash", 1, 1, "Please select a item from the list to Remove");        
            $this->addBarTitle("User <small>[list]</small>", "user");

            $task = Request::getVar('task', "");
            if ($task == "hidden" OR $task == 'publish' OR $task == "unpublish") {
                $cids = Request::getVar('cid');
                for ($i = 0; $i < count($cids); $i++) {
                    $cid = $cids[$i];
                    if ($task == "publish")
                        $this->changeStatus ($cid, 1);
                    else if ($task == "hidden")
                        $this->changeStatus ($cid, 2);
                    else $this->changeStatus ($cid, 0);
                }
                YiiMessage::raseSuccess("Successfully saved changes status for users");
            }

            $model = new Users();
            $list_user = $model->getUsers();
            $arr_group = $model->getGroups();

            $this->render('list', array("list_user" => $list_user, 'arr_group' => $arr_group)); 
    }
    
     function changeStatus($cid, $value)
    {
        $obj_users = YiiUser::getInstance();
        $item_user = $obj_users->getUser($id);
        $item_user->status = $value;
        $item_user->store();
    }
    
    function actionCancel() {
        $this->redirect(Router::buildLink("users", array("view"=>"user")));
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

        $this->addIconToolbar("Save", Router::buildLink("users", array("view"=>"user",'layout'=>'save')), "save");
        $this->addIconToolbar("Apply", Router::buildLink("users", array("view"=>"user",'layout'=>'apply')), "apply");
  
        if ($cid == 0) {
            $this->addIconToolbar("Cancel", Router::buildLink("users", array("view"=>"user",'layout'=>'cancel')), "cancel");
            $this->addBarTitle("User <small>[New]</small>", "user");        
            $this->pageTitle = "New User";
        }else{
            $this->addIconToolbar("Close", Router::buildLink("users", array("view"=>"user",'layout'=>'cancel')), "cancel");
            $this->addBarTitle("User <small>[Edit]</small>", "user");        
            $this->pageTitle = "Edit User";           
        }

        $model = new Users();
        $item = $model->getItem($cid) ;       
         
        $list = $model->getListEdit($item);

        $this->render('edit', array("item" => $item,"list" => $list));
    }

    function actionApply() {
        $userID = $this->store();        
        $this->redirect(Router::buildLink("users", array("view"=>"user",'layout'=>'edit','cid'=>$userID)));
    }

    function actionSave() {
        $this->store();
        $this->redirect(Router::buildLink("users", array("view"=>"user")));
    }

    function store() {
        global $mainframe;
        $post = $_POST;
        $id = Request::getVar("id", 0);
        $obj_users = YiiUser::getInstance();
        $item_user = $obj_users->getUser($id);
       
        if (!isset($_POST['username'])) {
            YiiMessage::raseWarning("Cannot save the user information");
            $this->redirect(Router::buildLink("users", array("view"=>"user")));
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
            $this->redirect(Router::buildLink("users", array("view"=>"user",'layout'=>'login')));
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
        $this->pageTitle = "Page login";
        $this->render('login');
    }
    
     public function actionLogout() {
//        Yii::app()->session['userbackend'] = null;
        Yii::app()->user->logout();
        $this->redirect(Router::buildLink("users", array("view"=>"user",'layout'=>'login')));        
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
        $this->redirect(Router::buildLink("users", array("view"=>"user")));
    }
    
    function actionTree(){
        global $user;
        $tmpl = Request::getVar('tmpl',null);
        $modelUser = new Users();
        $modelGroup = new Group();
         
        $this->addBarTitle("User <small>[list]</small>", "user");
        
        $groupID = Request::getVar('groupID',null);
        if($groupID == null){
            $groupID = $user['groupID'];
            $group = $modelGroup->getItem($user['groupID']);
            if($group->parentID == 1)
                $groupID = $group->parentID;
        }

        
        
        $group = $modelGroup->getItem($groupID);
        $list_user = $modelUser->getUsers($groupID, " leader DESC, id ASC ");
        $arr_group = $modelUser->getGroups($groupID);
        
        if($tmpl ==null)
            $this->render('tree', array("objGroup"=>$group,"list_user" => $list_user, 'arr_group' => $arr_group));
        else if($tmpl == 'app'){
            $this->render('treegroup', array("objGroup"=>$group,"list_user" => $list_user, 'arr_group' => $arr_group));
            die;
        }
    }
    
}
