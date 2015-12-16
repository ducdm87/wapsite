<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MenuItem extends CFormModel {

    private $table = '{{menu_item}}';
    private $tbl_menu = '{{menus}}';
    private $tbl_menu_xref = '{{module_menuitem_ref}}';
    private $tbl_ext = '{{extensions}}';

    function __construct() {
        
    }

    static function getInstance() {
        static $instance;

        if (!is_object($instance)) {
            $instance = new MenuItem();
        }
        return $instance;
    }

    /**
     * 
     * @param type $limit
     * @param type $offset
     * @param type $where
     * @param type $or_where
     * @param type $order
     * @param type $by
     * @param type $query 
     */
    public function getMenuItems() {

        $where = $this->_buildWhere();
        $limit = Request::getInt('limit', getSysConfig("pages.limit", 15));
        $limitstart = Request::getInt('limitstart', 0);

        $results = $this->command->select('*')
                ->from($this->table)
                ->where($where)
                ->order("lft ASC")
                ->queryAll();

        return $results;
    }

    function _buildWhere() {
        $where = array();
        $menuID = Request::getInt('menu', "");
        if ($menuID > 0)
            $where[] = " menuID = $menuID ";

        $status = Request::getInt('filter_status', -1);
        if ($status != -1) {
            $where[] = " status = $status ";
        }

        $sarch = Request::getVar('filter_search', "");
        if ($sarch != "") {
            $w = "( `title` like :filter_search ";
            $w .= " OR `controller` like :filter_search  ";
            $w .= " OR `params` like :filter_search  )";
            $where[] = " $w ";
        }
        if (count($where) > 0)
            return "  " . implode(" AND ", $where);
        else
            return "";
    }

    function getList() {
        $menuID = Request::getInt('menu', "");

        $list = array();
        $command = Yii::app()->db->createCommand();
        $results = $command->select('id value, title text')
                ->from($this->tbl_menu)
                ->queryAll();
        $list['filrer_menu'] = buildHtml::select($results, $menuID, "menu", "", " onchange='this.form.submit();' ");

        return $list;
    }

    function getListEdit($main_item) {
        $cid = Request::getVar("cid", 0);
        $menuID = Request::getInt('menu', "");

        $list = array();
        $items[] = array("value" => "-1", "text" => "-- Select Menu --");
        $obj_menu = YiiMenu::getInstance();
        $results = $obj_menu->loadMenus('id value, title text', false);
        $items = array_merge($items, $results);
        $list['menuID'] = buildHtml::select($items, $menuID, "menuID");

        $condition = null;
        if ($main_item->id != 0) {
            $items = array();
            $condition = "parentID = " . $main_item->parentID;
            $results = $obj_menu->loadItems($menuID, 'id value, title text, level', $condition);
            $items = array_merge($items, $results);
            $list['ordering'] = buildHtml::select($items, $cid, "ordering", "", "size=5");

            $condition = "(`lft` <" . $main_item->lft . " OR `lft` > " . $main_item->rgt . ")";
        } else {
            $list['ordering'] = " New Menu Items default to the last position. Ordering can be changed after this Menu Item is saved.";
        }

        $items = array();
        $items[] = array("value" => "1", "text" => "Top", "level" => 0);
        $results = $obj_menu->loadItems($menuID, 'id value, title text, level', $condition);
        $items = array_merge($items, $results);
        $list['parentID'] = buildHtml::select($items, $main_item->parentID, "parentID", "", "size=10", "&nbsp;&nbsp;&nbsp;", "-");


        // danh sach app
        $obj_ext = YiiTables::getInstance(TBL_EXTENSIONS);
        $list['apps'] = $obj_ext->loads("*", "type = 'app'", "ordering ASC");

        foreach ($list['apps'] as $k => $app) {
            if(!is_dir(PATH_APPS_FRONT . "/" . $app['folder'])){
                unset($list['apps'][$k]);
                continue;
            }
            $file_xml = PATH_APPS_FRONT . "/" . $app['folder'] . "/" . $app['folder'] . ".xml";
            if (!file_exists($file_xml)) {
                YiiMessage::raseSuccess("Invalid xml: " . $app['folder']);
                break;
            }
            $xml = simplexml_load_file($file_xml);
            $views = array();
            foreach ($xml->views->view as $view) {
                $obj_view = new stdClass();
                $obj_view->name = (string) $view->attributes()->name;
                $obj_view->title = (string) $view->attributes()->title;
                $obj_view->desc = (string) $view->attributes()->desc;
                if ($view->layouts) {
                    $obj_view->layouts = array();
                    foreach ($view->layouts->layout as $layout) {
                        $obj_layout = new stdClass();
                        $obj_layout->value = (string) $layout->attributes()->value;
                        $obj_layout->desc = (string) $layout->attributes()->desc;
                        $obj_layout->title = (string) $layout;
                        $obj_view->layouts[] = $obj_layout;
                    }
                }
                $views[] = $obj_view;
            }
            $app['views'] = $views;
            $list['apps'][$k] = $app;
        }
        $app = array();
        $app['name'] = "System";
        $app['title'] = "System Link";
        $app['views'] = array();
        $obj_view = new stdClass();
        $obj_view->name = "ExternalURL";
        $obj_view->title = "External URL";
        $obj_view->desc = "An external or internal URL.";
        $app['views'][] = $obj_view;

        $obj_view = new stdClass();
        $obj_view->name = "MenuItemAlias";
        $obj_view->title = "Menu Item Alias";
        $obj_view->desc = "Create an alias to another menu item.";
        $app['views'][] = $obj_view;
        $list['apps'][] = $app;

        return $list;
    }

    function getListParamView() {
        $cid = Request::getVar("menuID", 0);
        $app_name = Request::getVar("pr_app", "");
        $view_name = Request::getVar("pr_view", "");

        $obj_menu = YiiMenu::getInstance();
        $obj_tblMenuItem = $obj_menu->loadItem($cid);
        $obj_tblMenuItem->params = json_decode($obj_tblMenuItem->params);

        $view = $this->getParamView($app_name, $view_name);
        $_view = (string) $view->attributes()->name;
        $html_field = "";
        $title_param = "Advance";
        if (count($view->param->field)) {
            foreach ($view->param->field as $field) {
                $field_name = (string) $field['name'];
                $field_value = isset($obj_tblMenuItem->params->$field_name) ? $obj_tblMenuItem->params->$field_name : null;
                // $arr_field[] = YiiElement::render($field, $field_value);
                $html_field .= YiiElement::render($field, $field_value, "params", 3, 9);
            }
        } else
            $html_field = "No parameter";


        return array($title_param, $html_field);
    }

    function getParamView($app_name, $view_name) {
        $file_xml = PATH_APPS_FRONT . "/" . $app_name . "/" . $app_name . ".xml";
        if (!file_exists($file_xml)) {
            YiiMessage::raseSuccess("Invalid xml: " . $app_name);
            return null;
        }
        $xml = simplexml_load_file($file_xml);
        $views = array();
        foreach ($xml->views->view as $view) {
            $_view = (string) $view->attributes()->name;
            if ($_view == $view_name) {
                return $view;
            }
        }
    }

    function storeItem() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify menu item");
            return false;
        }

        $post = $_POST;

        $id = Request::getVar("id", 0);
        $obj_menu = YiiMenu::getInstance();
        $tbl_menu = $obj_menu->loadItem($id);
        $tbl_menu->_ordering = isset($post['ordering']) ? $post['ordering'] : null;
        $tbl_menu->_old_parent = $tbl_menu->parentID;
        $tbl_menu->bind($post);
        
        if ($_POST['menu_type'] != "System") {
            $params = Request::getVar("params", array());
            $app_name = $params['app'];
            $view_name = $params['view']?$params['view']:'home';
            $layout_name = $params['layout'];
            $view_param = $this->getParamView($app_name, $view_name);
            $tbl_menu->link = "/index.php?app=$app_name";
            if($view_name != "home" AND $view_name != "")
                $tbl_menu->link .= "&view=$view_name";
            if($view_name != "home" AND $view_name != "")
                $tbl_menu->link .= "&layout=$layout_name";
            $_params = array();
            if (count($view_param->param->field)) {
                foreach ($view_param->param->field as $field) {
                    $field_name = (string) $field['name'];
                    $_request = (bool) $field['request'];
                    if (!isset($params[$field_name]))
                        continue;
                    $val = $params[$field_name];
                    $_params[$field_name] = $val;
                    if (empty($val))
                        continue;
                    if($_request == true){
                        $tbl_menu->link .= "&$field_name=$val";
                    }
                }
            }
        }
 
        foreach ($params as $k => $v) {
            if (empty($v))
                unset($params[$k]);
        }

        $tbl_menu->app = $params['app'];
        $params = json_encode($params);
        $tbl_menu->params = $params;
        $tbl_menu->store();
        return array($tbl_menu->menuID, $tbl_menu->id);
    }

}
