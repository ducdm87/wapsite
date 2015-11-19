<?php

class SysconfigController extends BackEndController {

    var $configs = array();

    function init() {
        $this->configs['main'] = "";
        $this->configs['backend'] = "";
        $this->configs['frontend'] = "";
        parent::init();
    }

    function actionDisplay() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to view setting");
            $this->redirect(Router::buildLink("cpanel"));
        }

        $this->addIconToolbar("Save", Router::buildLink("cpanel", array("view" => "sysconfig", "layout" => "save")), "save");
        $this->addBarTitle("User <small>[list]</small>", "user");
        $this->render('default', array());
    }

    public function actionSave() {
        global $mainframe, $user;
        if (!$user->isSuperAdmin()) {
            YiiMessage::raseNotice("Your account not have permission to modify setting");
            $this->redirect(Router::buildLink("cpanel"));
        }
        
        $post = Request::get();

        $db_info = $post['config']['database'];
        $connectionString = '\'mysql:dbname=' . $db_info['databasename'] . ';host=' . $db_info['hostname'] . '\'';
        $this->setConfig('main', 'connectionString', $connectionString, 'db', "\s*\,\s*\'errorHandler");
        $this->setConfig('main', 'username', '\'' . $db_info['username'] . '\'', 'db', "\s*\,\s*\'errorHandler");
        $this->setConfig('main', 'tablePrefix', '\'' . $db_info['prefix'] . '\'', 'db', "\s*\,\s*\'errorHandler");
        $this->setConfig('main', 'adminEmail', '\'' . $post['config']['other']['adminEmail'] . '\'', 'params');
        $this->writeConfig('main');

        $this->setConfig('backend', 'timeout', '\'' . $post['config']['backend']['sessionlifetime'] . '\'', 'params');
        $this->setConfig('backend', 'sessionName', 'md5("' . $post['config']['backend']['sessionname'] . '")', 'session');
        $this->writeConfig('backend');

        $this->setConfig('frontend', 'timeout', '\'' . $post['config']['site']['sessionlifetime'] . '\'', 'params');
        $this->setConfig('frontend', 'offlineMessage', '\'' . $post['config']['site']['offlinemessage'] . '\'', 'params');
        $this->setConfig('frontend', 'siteoffline', $post['config']['site']['offline'], 'params');
        $this->setConfig('frontend', 'sessionName', 'md5("' . $post['config']['site']['sessionname'] . '")', 'session');
        $this->writeConfig('frontend');

        YiiMessage::raseSuccess("Successfully saved changes config");
//        $this->pageTitle = "Home page Display";        
        $this->redirect(Router::buildLink("cpanel", array("view" => "sysconfig")));
    }

    function writeConfig($from = "mainconfig") {
        $this->configs[$from] = file_put_contents(PATH_SITE . '/config/' . $from . '.php', $this->configs[$from]);
        return $this->configs[$from];
    }

    function detectConfig($from = "mainconfig", $name = "timeout", $parent = "", $after = ",\s*\);", $default = "") {
        if ($this->configs[$from] == "") {
            $this->configs[$from] = file_get_contents(PATH_SITE . '/config/' . $from . '.php');
            $this->configs[$from] = str_replace("\n", "xuong_dong", $this->configs[$from]);
            $this->configs[$from] = preg_replace('/\/\/.*?xuong_dong/ism', '', $this->configs[$from]);
            $this->configs[$from] = str_replace("xuong_dong", "\n", $this->configs[$from]);
        }

        $str_in = $this->configs[$from];

        if ($parent != "") {
            $reg_parent = "/\'$parent\'\s*=>\s*array\((.*?)\)$after/ism";
            if (!preg_match($reg_parent, $str_in, $matches))
                return $default;
            $str_in = $matches[1];
        }

        $reg_name = "/\'$name\'\s*=>\s*(.*?)\,/ism";
        if (!preg_match($reg_name, $str_in, $matches))
            return $default;

        $str_out = $matches[1];
        $str_out = trim($str_out, "\'");
        $str_out = trim($str_out, "\"");
        return $str_out;
    }

    function setConfig($from = "mainconfig", $name = "timeout", $value, $parent = "", $after = ",\s*\);", $default = "") {
        if ($this->configs[$from] == "") {
            $this->configs[$from] = file_get_contents(PATH_SITE . '/config/' . $from . '.php');
            $this->configs[$from] = str_replace("\n", "xuong_dong", $this->configs[$from]);
            $this->configs[$from] = preg_replace('/\/\/.*?xuong_dong/ism', '', $this->configs[$from]);
            $this->configs[$from] = str_replace("xuong_dong", "\n", $this->configs[$from]);
        }

        $block = $this->configs[$from];

        if ($parent != "") {
            $reg_parent = "/\'$parent\'\s*=>\s*array\((.*?)\)$after/ism";
            if (!preg_match($reg_parent, $block, $matches))
                return false;
            $block = $matches[0];
        }
        $reg_name = "/\'$name\'\s*=>\s*(.*?)\,/ism";
        if (!preg_match($reg_name, $block, $matches))
            return false;
        $block = preg_replace($reg_name, '\'' . $name . '\' => ' . $value . ',', $block);
        if ($parent != "") {
            $reg_parent = "/\'$parent\'\s*=>\s*array\((.*?)\)$after/ism";
            $block = preg_replace($reg_parent, $block, $this->configs[$from]);
        }
        $this->configs[$from] = $block;
        return $this->configs[$from];
    }

}
