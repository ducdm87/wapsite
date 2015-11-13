<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

     public $defaultAction = 'display';
    public $layout = '//default';
    public $menu = array();
    public $breadcrumbs = array();
    public static $permission;
    protected $user;
    protected $iconToolbar = array();
    protected $barTitle = "";
    protected $classIcon = "";
    public $db = null;
    public $secret = "ajdadaqheahdadgabd";
    public $lifetime = 30;  

    function init() {
       global $db, $user, $mainframe, $hideMenu;
        $hideMenu = 0;
        $task = Request::getVar("task", "");        

        if ($task != "") {
            $cmd = "action$task()";
            if (method_exists($this, $cmd))
                $this->$cmd();
        }
        $db = $this->db = Yii::app()->db;
        Yii::app()->name = "Back end";
        $user = $this->user = Yii::app()->session['userbackend'];
        $mainframe = MainFrame::getInstance($this->db, $this->user);

        parent::init();

        $app = Yii::app();
        if (!$mainframe->isLogin()) {            
            $duration = time() + 300; // 365 days            
        } else {                                    
            $remember_admin = (isset($_COOKIE['remember_admin']) AND $_COOKIE['remember_admin'] == 1 )?1:0;
            if($remember_admin == 1)
                $duration = time() + 86400*30; // 365 days
            else $duration = time() + 900; // 15 minutes            
        }
        
        $cookie = new CHttpCookie(session_name(), session_id(), array("expire" => $duration));
        $app->getRequest()->getCookies()->add($cookie->name, $cookie);
    }
    
    function getUser(){
        return $this->user;
    }
    
    function getUserID(){
        return $this->user?$this->user["id"]:null;
    }

    function isLogin(){
        return $this->user?true:false;
    }
    
    function isAdmin(){        
        return $this->user?($this->user['ltf']>=13?true:false):false;
    }
    
    
    public function redirect($url, $message = "", $terminate = true, $statusCode = 302) {
        if ($message != "") {
            Yii::app()->session['message'] = $message;
            Yii::app()->session['rasestatus'] = "notice";
        }
        if (is_array($url)) {
            $route = isset($url[0]) ? $url[0] : '';
            $url = $this->createUrl($route, array_splice($url, 1));
        }
        Yii::app()->getRequest()->redirect($url, $terminate, $statusCode);
    }

    function loadItem($value = 0, $fieldName = "") {
        if ($value === 0 || $value == "") {
            return $this->item;
        }

        if ($fieldName == "")
            $fieldName = $this->primary;
        $query = "SELECT * FROM " . $this->tablename . " WHERE " . $fieldName . " = :fieldvalue ";
        $query_command = $this->db->createCommand($query);
        $query_command->bindParam(':fieldvalue', $value);

        $item = $query_command->queryRow();
        return $item;
    }

    function storeItem() {
        $insterted = array();
        foreach ($this->item as $k => $val) {
            $insterted[] = "$k=:$k";
        }
        $insterted = implode(",", $insterted);
        $query = "";

        if ($this->item[$this->primary] != 0) {
            if (isset($this->item['mdate']))
                $this->item['mdate'] = date("Y-m-d H:i:s");
            $query = "UPDATE " . $this->tablename . " SET " . $insterted . " WHERE " . $this->primary . " = " . $this->item[$this->primary];
        } else {
            if (isset($this->item['cdate']))
                $this->item['cdate'] = date("Y-m-d H:i:s");
            if (isset($this->item['mdate']))
                $this->item['mdate'] = date("Y-m-d H:i:s");
            $query = "INSERT INTO " . $this->tablename . " SET " . $insterted;
        }
        $query_command = $this->db->createCommand($query);
        foreach ($this->item as $key => $value) {
            $query_command->bindParam(':' . $key, $value);
        }

        $query_command->execute();
        if ($this->item[$this->primary] == 0)
            $this->item[$this->primary] = $this->db->lastInsertID;
        return $this->item[$this->primary];
    }

    function bind($toArray, $fromArray) {
        foreach ($toArray as $k => $value) {
            if (isset($fromArray[$k]) and $fromArray[$k] != "" and $fromArray[$k] != null)
                $toArray[$k] = $fromArray[$k];
        }
        return $toArray;
    }
    
    public function actions()
    {
        $subcontroller = Request::getVar("subcontroller", "");       
        $subcontroller = Request::getVar("subcontroller", "");  
        var_dump($subcontroller); die;
        return array(
            'edit'=>'application.controllers.post.'.$subcontroller,
        );
    }

}
