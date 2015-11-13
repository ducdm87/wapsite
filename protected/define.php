<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define("ENABLE_MULTISITE", 1);
$domain = "vietbao.vn"; 

if (ENABLE_MULTISITE == 1) {
    $domain = $_SERVER['HTTP_HOST'];
    switch ($domain) {
        case "yiiframework.com";
        default :
            $config_frontend = "frontend.php";
            break;
    }
}

define("MAILFROM", "ducdm87@gmail.com");
define("WEB_SITE", $domain);
define("WEB_URL", "http://$domain");
define("TIME_OUT_ACTIVE_ACCOUNT", "2");
define("TIME_OUT_ACTIVE_UNIT", "days");
define("DEFAULT_GROUPID", 19);
define("PATH_SITE", dirname(__FILE__) . "/");

define("ENABLE_SSO", 0);

define("ROOT_PATH", dirname(dirname(__FILE__)) . "/");
define("PATH_TMP", ROOT_PATH . "tmp/");

define('PATH_APIFILE', ROOT_PATH . "tmp/apifile/");

define('PATH_APPS', dirname(__FILE__) . "/apps/");
define('PATH_MODULES', dirname(__FILE__) . "/extensions/modules/");
define('PATH_APPS_BACKEND', dirname(__FILE__) . "/apps/backend/");
define('PATH_APPS_FRONT', dirname(__FILE__) . "/apps/frontend/");

$os = strtoupper(substr(PHP_OS, 0, 3));
if (!defined('IS_WIN')) {
    define('IS_WIN', ($os === 'WIN') ? true : false);
}

if (!defined('IS_UNIX')) {
    define('IS_UNIX', (IS_WIN === false) ? true : false);
}

global $sys_config, $sys_menu;
$sys_menu = $sys_config = array();

setSysConfig("colright.display", true);
setSysConfig("page.classSuffix", "");
setSysConfig("news.detail.showpath", 1);
setSysConfig("news.limit", 10);
setSysConfig("pages.limit", 15);

setSysConfig("seopage.title","seo page title"); 
setSysConfig("seopage.keyword","seo page keyword"); 
setSysConfig("seopage.description", "seo page description");

/*
 * controll: 0
 * action: 1 
 * page-tpl: 2
 * layout: 3
 *  */

