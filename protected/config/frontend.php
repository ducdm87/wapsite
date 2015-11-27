<?php
  
$settings = array(
    'defaultController' => 'home',
    'components' => array(
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                // home page
                '/' => array('home/display'),
                '/dang-ky/captcha/<v:.*>' => array('home/captcha'),
                '/dang-ky/re-captcha/<refresh:.*>' => array('home/captcha'),

            ),
        ),
        
        'user' => array(
            'loginUrl' => array('user/login'),
        ),
        'session' => array(
            //'class' => 'CHttpSession',
            'class' => 'CDbHttpSession',
            'sessionName' => md5("front-end-yii:193jjo2ue"),
            'connectionID' => "db",
            'sessionTableName' => "tbl_yiisession",
            'timeout'=> 30*24*60*60 ,
//            'autoCreateSessionTable' => false,
        ), 
        
    ),
    'import' => array(
        'application.models.*',
        'application.models.frontend.*',
        'application.includes.*',
        'application.includes.libs.*',
        'application.components.widget.*',        
    ),
    'params' => array(
        // time out minute
        'timeout' => 30*60, 
        'timeout2' => 30*24*60*60, 
        'adminEmail' => 'ducdm@binhhoang.com',        
        'sef' => 1,
        'sef_suffix' => 0,
        'sef_urlsuffix' => ".html",
        'siteoffline' => 0,
        'offlineMessage' => "This site is down for maintenance. Please check back again soon.",
//        'defaultApp' => 'news',
    ),
);
return CMap::mergeArray(
                require(dirname(__FILE__) . '/main.php'), $settings
);
?>