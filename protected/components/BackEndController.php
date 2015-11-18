<?php

class BackEndController extends CController {

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
        setSysConfig("sidebar.display", 1);
        $task = Request::getVar("task", "");        

        if ($task != "") {
            $cmd = "action$task()";
            if (method_exists($this, $cmd))
                $this->$cmd();
        }
        $db = $this->db = Yii::app()->db;
        Yii::app()->name = "Back end";
        $user = $this->user = Yii::app()->session['userbackend'];
         
        if(is_object($user))
            $user->reloaUserLogin(); 
         
        $mainframe = MainFrame::getInstance($this->db, $user);

        parent::init();

        $YiiApp = Yii::app();
        if (!$mainframe->isLogin()) {            
            $duration = time() + 300; // 365 days            
        } else {
            $remember_admin = (isset($_COOKIE['remember_admin']) AND $_COOKIE['remember_admin'] == 1 )?1:0;
            if($remember_admin == 1)
                $duration = time() + 86400*30; // 365 days
            else $duration = time() + 900; // 15 minutes            
        }
        
        $cookie = new CHttpCookie(session_name(), session_id(), array("expire" => $duration));
        $YiiApp->getRequest()->getCookies()->add($cookie->name, $cookie);
    } 
    
    function render($layout = "blog", $data = NULL, $return = false) {
         $YiiApp = Request::getVar('app',"cpanel");
         $controller = Request::getVar('controller',null);
         $view = Request::getVar('view',"home");
         $controller = $controller?$controller:$view;
         
          global $pagetype, $cur_temp, $yiiapp, $cur_temp;
          
          if($pagetype == 1){
            $found = false;
            if(is_dir(ROOT_PATH."themes/backend/$cur_temp")){
                $file_layout = $yiiapp->getViewPath()."/html/$YiiApp/$controller/$layout.php";
                
                if(file_exists($file_layout)){
                    $found = true;
                    $view =  "//html/$YiiApp/$controller/$layout"; 
                }
            }
           
            if($found == false){
                $file_layout = $yiiapp->getViewPath()."/$controller/$layout.php";                
                if(file_exists($file_layout)){
                    $found = true;
                    $view =  "/$controller/$layout";
                }
            }
            if($found == false){                
                $YiiApp_viewpath = PATH_APPS_FRONT . "/$YiiApp/views";
                $file_layout = "$YiiApp_viewpath/$controller/$layout.php"; 
                if(file_exists($file_layout)){
                    $found = true;
                    $yiiapp->setViewPath($YiiApp_viewpath);
                    $view =  "/$controller/$layout";
                }                
            }
            if($found == false){
                die("Invalid view");
            }
          }else $view =  $layout;

        parent::render($view, $data, $return);
    }

    public function actions()
    {
        $subcontroller = Request::getVar("subcontroller", "");       
        $action = Request::getVar("action", "");  
        var_dump($subcontroller, $action); die("back end controller");
        return array(
            $action=>'application.controllers'.$subcontroller.'post.'.$subcontroller,
        );
    }
    
    public function filters() {        
        return array(
            'accessControl',
        );        
    }

    public function accessRules() {

        global $db, $user, $mainframe;
        
        $YiiApp = Yii::app();
        $app = Request::getVar('app','cpanel');
        $view = Request::getVar('view','cpanel');
        $layout = Request::getVar('layout','cpanel');
        
        if (is_object($user) AND $user->isLogin()) {
            if (!$user->isAdmin()) {
                YiiMessage::raseWarning("Your account not have permission to visit backend page");
                Yii::app()->session['userbackend'] = null;                
                $this->redirect(Router::buildLink("users",array("view"=>'user','layout'=>'logout')));
//                $this->redirect(array('users/logout'));
                return;
            }            
            if ($app == "users" and $view == "user" AND $layout == "login") {
                $this->redirect(Router::buildLink("cpanel"));
//                $this->redirect(array('/cpanel'));
                return;
            }
            return array();
            $return = array(
                array('allow', // allow all users to access all actions.
                    'actions' => array("templates"),
                    'users' => array('*'),
                )
            );
            return $return;
        } else if ($app == "users" and $view == "user" AND $layout == "login") {

            return array(
                array('allow', // allow all users to access 'formlogin' and 'login' actions.
                    'actions' => array("login"),
                    'users' => array('*'),
                ),
                array('allow', // allow authenticated users to access all actions
                    'users' => array('@'),
                ),
                array('deny', // deny all users
                    'users' => array('*'),
                ),
            );
        } else {            
            $this->redirect(Router::buildLink("users",array("view"=>'user','layout'=>'login')));
//            return array();
        }
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

    function addIconToolbar($title, $task, $class, $type = 1, $checkForm = 0, $alert = "Please select a item from the list to edit") {

        $script = 'submitbutton(\'' . $task . '\',\'' . $type . '\')';
        if ($checkForm == 1) {
            $script = 'if (document.adminForm.boxchecked.value == 0) {
                                alert(\'' . $alert . '\');
                            } else {
                                submitbutton(\'' . $task . '\',\'' . $type . '\')
                            }';
        }

        $this->iconToolbar[] = ' <td id="toolbar-' . $class . '" class="button">
                                     <a class="toolbar" onclick="javascript:' . $script . '" href="#">
                                        <span title="' . $title . '" class="icon-32-' . $class . '">
                                        </span>
                                        ' . $title . '
                                    </a>
                                </td>';
    }

    function addIconToolbarDelete($alert = "Please select a item from the list to delete", $title = "delete") {
        $this->iconToolbar[] = ' <td id="toolbar-delete" class="button">
                                     <a class="toolbar" onclick="javascript:if (document.adminForm.boxchecked.value == 0) {
                                        alert(\'' . $alert . '\');
                                    } else {
                                        submitbutton(\'delete\')
                                    }" href="#">
                                        <span title="delete" class="icon-32-delete">
                                        </span>
                                        '.$title.'
                                    </a>
                                </td>';
    }

    function showIconToolbar() {
        if (count($this->iconToolbar)) {
            ?>
            <div id="toolbar" class="toolbar">
                <table class="toolbar"><tbody>
                        <tr>
                            <?php
                            foreach ($this->iconToolbar as $item)
                                echo $item;
                            ?>
                        </tr>
                    </tbody></table>
            </div>
            <?php
        }
    }

    function addBarTitle($title = "", $class = "generic") {
        $this->barTitle = $title;
        $this->classIcon = $class;
    }

    function showBarTitle() {
        if ($this->barTitle != "")
            echo '<div class="header icon-48-' . $this->classIcon . '"> ' . $this->barTitle . ' </div>';
    }

    function showToolbar() {
        if (count($this->iconToolbar) || $this->barTitle != "") {
            ?>
            <div id="toolbar-box" >
                <div class="t"><div class="t"><div class="t"></div></div> </div>
                <div class="m">
                    <?php $this->showIconToolbar(); ?>
                    <?php $this->showBarTitle(); ?>
                    <div class="clr"></div>
                </div>
                <div class="b"><div class="b"> <div class="b"></div> </div> </div>
            </div>
            <?php
        }
    }

    function loadItem($value = 0, $fieldName = "", $tablename = "") {
        if ($value === 0 || $value == "") {
            return $this->item;
        }

        if ($fieldName == "")
            $fieldName = $this->primary;
        
        if ($tablename == "")
            $tablename = $this->tablename;
        $value = trim($value);
        $query = "SELECT * FROM " . $tablename . " WHERE " . $fieldName . " = :fieldvalue ";
        $query_command = $this->db->createCommand($query);
        $query_command->bindParam(':fieldvalue', $value);
 
        $item = $query_command->queryRow();
        return $item;
    }

    function storeItem($_item = null, $tableName = null, $primary = null) {
        if ($_item == null)
            $item = $this->item;
        else $item = $_item;
 
        if ($tableName == null)
            $tableName = $this->tablename;
        if ($primary == null)
            $primary = $this->primary;
        
        $insterted = array();
        foreach ($item as $k => $val) {
            $insterted[] = "$k=:$k";
        }
        $insterted = implode(",", $insterted);
        $query = "";

        if ($item[$primary] != 0) {
            if (isset($item['mdate']))
                $item['mdate'] = date("Y-m-d H:i:s");
            $query = "UPDATE " . $tableName . " SET " . $insterted . " WHERE " . $primary . " = " . $item[$primary];
        } else {
            if (isset($item['cdate']))
                $this->item['cdate'] = date("Y-m-d H:i:s");
            if (isset($item['mdate']))
                $item['mdate'] = date("Y-m-d H:i:s");
            $query = "INSERT INTO " . $tableName . " SET " . $insterted; 
        }
        
        $query_command = $this->db->createCommand($query);
        
        foreach ($item as $key => $value) {
            $query_command->bindParam(':' . $key, $item[$key] );
        }

        $query_command->execute();
        if ($item[$primary] == 0)
            $item[$primary] = $this->db->lastInsertID;

        if ($_item == null)
            $this->item = $item;
        return $item[$primary];
    }
    
    function removeItem($id, $tableName = null, $primary = null) {
        if ($tableName == null)
            $tableName = $this->tablename;
        if ($primary == null)
            $primary = $this->primary;
        $query = "DELETE FROM $tableName WHERE $primary = $id";
        $query_command = $this->db->createCommand($query);
        $query_command->execute();
        return true;
    }

    function saveOrder($arr_cid, $tbl_name) {
        global $mainframe, $db;
        $ordering = 1;
        for ($i = 0; $i < count($arr_cid); $i++) {
            $cid = $arr_cid[$i];
            $query = "UPDATE $tbl_name SET ordering=$ordering WHERE id = " . $cid;
            $query_command = $db->createCommand($query);
            $query_command->execute();
            $ordering++;
        }
        return true;
    }

    function convertalias($string) {
        $alias = $string;

        $coDau = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
            "ằ", "ắ", "ặ", "ẳ", "ẵ",
            "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ",
            "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
            , "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
            , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
            , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ", "ê", "ù", "à");

        $khongDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
            , "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
            , "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
            , "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
            , "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D", "e", "u", "a");

        $alias = str_replace($coDau, $khongDau, $alias);

        $coDau = array("̀", "́", "̉", "̃", "̣", "“", "”", ".");
        $khongDau = array("", "", "", "", "", "", "", "");
        $alias = str_replace($coDau, $khongDau, $alias);

        $alias = preg_replace('/[^a-zA-Z0-9-.]/', '-', $alias);
        $alias = preg_replace('/^[-]+/', '', $alias);
        $alias = preg_replace('/[-]+$/', '', $alias);
        $alias = preg_replace('/[-]{2,}/', '-', $alias);
        return $alias;
    }

    function afterLogin($old_session_id, $new_session_id) {
        return true;
    }

    public function gen_pagination($pagination, $paged = 1, $get = false, $range = 4) {
        if ($pagination['total'] > 0) {
            $max_page = ceil($pagination['total'] / $pagination['limit']);

            $return = '<ul class="pagination">';

            // Previous Button
            $return .= '<li class="paginate_button previous ' . ($paged <= 1 ? 'disabled' : '') . '">';
            $return .= '<a href="' . ($paged <= 1 ? 'javascript:void(0)' : (($get ? '' : '/') . ($paged - 1))) . '">' . $this->lang->line('previous_text') . '</a>';
            $return .= '</li>';

            if ($max_page > $range) {
                if ($paged < $range) {
                    for ($i = 1; $i <= ($range + 1); $i++) {
                        $current = $i == $paged ? 'active' : '';
                        $return .= '<li class="paginate_button ' . $current . '">';
                        $return .= '<a href="' . ($i == $paged ? 'javascript:void(0)' : $url . ($get ? '' : '/') . $i) . '">' . $i . '</a>';
                        $return .= '</li>';
                    }
                } elseif ($paged >= ($max_page - ceil(($range / 2)))) {
                    for ($i = $max_page - $range; $i <= $max_page; $i++) {
                        $current = $i == $paged ? 'active' : '';
                        $return .= '<li class="paginate_button ' . $current . '">';
                        $return .= '<a href="' . ($i == $paged ? 'javascript:void(0)' : $url . ($get ? '' : '/') . $i) . '">' . $i . '</a>';
                        $return .= '</li>';
                    }
                } elseif ($paged >= $range && $paged < ($max_page - ceil(($range / 2)))) {
                    for ($i = ($paged - ceil($range / 2)); $i < ($paged + ceil(($range / 2))); $i++) {
                        $current = $i == $paged ? 'active' : '';
                        $return .= '<li class="paginate_button ' . $current . '">';
                        $return .= '<a href="' . ($i == $paged ? 'javascript:void(0)' : $url . ($get ? '' : '/') . $i) . '">' . $i . '</a>';
                        $return .= '</li>';
                    }
                }
            } else {
                for ($i = 1; $i <= $max_page; $i++) {
                    $current = $i == $paged ? 'active' : '';
                    $return .= '<li class="paginate_button ' . $current . '">';
                    $return .= '<a href="' . ($i == $paged ? 'javascript:void(0)' : $url . ($get ? '' : '/') . $i) . '">' . $i . '</a>';
                    $return .= '</li>';
                }
            }

            $return .= '<li class="paginate_button next ' . ($paged >= $max_page ? 'disabled' : '') . '">';
            $return .= '<a href="' . ($paged < $max_page ? ($url . ($get ? '' : '/') . ($paged + 1)) : 'javascript:void(0)') . '">' . $this->lang->line('next_text') . '</a>';
            $return .= '</li>';

            $return .= '</ul>';

            return $return;
        } else {
            return '';
        }
    }
    
}
