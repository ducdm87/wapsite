<?php 
//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED & ~E_STRICT);
global $yiiapp; 
error_reporting(E_ALL);
$config_frontend = "frontend.php";
require_once dirname(__FILE__).'/protected/includes.php'; 

$yii = dirname(__FILE__).'/framework/yii.php';
$config = dirname(__FILE__)."/protected/config/$config_frontend";
 
// Remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
 
require_once($yii);
$yiiapp = Yii::createWebApplication($config);
require_once dirname(__FILE__).'/protected/router.php';

$params = Router::parseLink($_SERVER['REQUEST_URI']);

global $pagetype, $cur_temp;
$debug = isset($_REQUEST['debug'])?$_REQUEST['debug']:0;
$pagetype = 1;
if($debug == 0) $pagetype = 1;
else $pagetype = 2;
 
if(isset($params['app']) AND isset($params['view']) AND $pagetype == 1){
    
    $cur_temp = "wapsite"; 
    setSysConfig("sys.template",$cur_temp); 
    setSysConfig("sys.template.path",ROOT_PATH . "themes/$cur_temp/"); 
    setSysConfig("sys.template.url","/themes/$cur_temp/"); 
    
    // thu tu uu tien: theme/$template => protected/apps/frontend/$app/views => /protected/views/frontend
    if(isset($params['app'])){
        $yiiapp->setControllerPath(ROOT_PATH.'protected/apps/frontend/'.$params['app'].'/controllers/');           
        if(is_dir(ROOT_PATH."themes/$cur_temp"))                  
          $yiiapp->setViewPath(ROOT_PATH."themes/$cur_temp");
        else $yiiapp->setViewPath(ROOT_PATH.'protected/apps/frontend/'.$params['app'].'/views/');
    }else{
        $yiiapp->setControllerPath(ROOT_PATH.'protected/controllers/frontend');
        $yiiapp->setViewPath(ROOT_PATH.'protected/views/frontend');
    }
    
//    $rt = $params['controller'] . "/".$params['action'];
    if(!isset($params['layout'])) $params['layout'] = "display";
    $rt = $params['view'] . "/".$params['layout'];
    
    yii::import('application.apps.frontend.'.$params['app'].'.models.*');
   
    $yiiapp->runController($rt);
}else{
    $yiiapp->runEnd('frontend');
}

//  setController  setViewPath  setLayoutPath
//$yiiapp->runEnd('frontend');

//Yii::createWebApplication($config)->runEnd('frontend');