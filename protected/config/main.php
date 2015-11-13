<?php

define("TBL_MENU", "{{menus}}");
define("TBL_MENU_ITEM", "{{menu_item}}");
define("TBL_ARTICLES", "{{articles}}");
define("TBL_CATEGORIES", "{{categories}}");
define("TBL_EXTENSIONS", "{{extensions}}");
define("TBL_MODULES", "{{modules}}");
define("TBL_MODULE_MENUITEM_REF", "{{module_menuitem_ref}}");
define("TBL_SESSION", "{{session}}");
define("TBL_USERS", "{{users}}");
define("TBL_USERS_GROUP", "{{users_group}}");
define("TBL_VIDEOS", "{{videos}}");
define("TBL_MODULE_POSITION", "{{module_position}}");
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Web Application',
        'preload' => array('log'),
        'import' => array(
        'application.models.*',
        'application.components.*',
        'application.includes.*',        
        'application.includes.jui.*',        
        'application.includes.libs.*',
        'application.includes.html.*',
        'application.includes.html.elements.*',         
        'application.includes.objects.*',
        //'application.apps.frontend.homepage.models.*',
    ),
    'modules' => array(
            'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'admin',
            'generatorPaths' => array(
                'ext.gtc'             ),
                        'ipFilters' => array('127.0.0.1', '::1'),
            'newFileMode' => 0666,
            'newDirMode' => 0777,
        ),
        'tophits',
    ),
    'defaultController' => 'index',
    'behaviors' => array(
        'runEnd' => array(
            'class' => 'application.components.WebApplicationEndBehavior',
        ),
    ),
    'components' => array(
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'caseSensitive' => false,
        ),
        'user' => array(
                        'allowAutoLogin' => true,
        ), 
//            'db'=>array(
//                    'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//            ),
            'db' => array(
            'connectionString' => 'mysql:dbname=wapsite_dev;host=localhost',
            'emulatePrepare' => true,
            'username' => 'wapsite_dev',
            'password' => 'wapsite_dev',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ),
        'errorHandler' => array(
             'errorAction'=>'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
            'params' => array(
                'adminEmail' => 'ducdm87@gmail.com',
    ),
);
