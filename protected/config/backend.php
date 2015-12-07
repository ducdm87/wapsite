<?php

$settings = array(
    'defaultController' => 'cpanel',
    'components' => array(
        'urlManager' => array(
            'urlFormat' => 'path',
                      'rules' => array(
                'backend/ ' => 'cpanel/display',
                'backend' => 'cpanel/display',
                
                                                               
                'backend/<controller>' => '<controller>',
                'backend/<controller>/<action>' => '<controller>/<action>',
                                
                                             
            ),
        ),
        'user' => array(
            'loginUrl' => "backend?app=user&view=user&layout=login",
        ),
        'session' => array(
            'class' => 'CHttpSession',
            'sessionName' => md5("back-end-yii:bdasbdabdba"),
        ),
    ),
    'import' => array(
        'application.models.*',
        'application.models.backend.*',        
        'application.includes.*',
    ),
    'params' => array(
        'timeout' => '86400',       
        'timeout2' => '8640000',
    ),
);
return CMap::mergeArray(
                require(dirname(__FILE__) . '/main.php'), $settings
);
