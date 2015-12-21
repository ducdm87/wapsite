<?php 
//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED & ~E_STRICT);
global $yiiapp; 
error_reporting(E_ALL);
$config_backend = "backend.php";
require_once dirname(__FILE__).'/protected/includes.php'; 

$yii = dirname(__FILE__).'/framework/yii.php';
$config = dirname(__FILE__)."/protected/config/$config_backend";
 
// Remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
 
require_once($yii);
$yiiapp = Yii::createWebApplication($config);
require_once dirname(__FILE__).'/protected/backrouter.php';

$params = Router::parseLink($_SERVER['REQUEST_URI']);

global $pagetype, $cur_temp;
$debug = isset($_REQUEST['debug'])?$_REQUEST['debug']:0;
$pagetype = 1;
 
$app = Request::getVar('app', "cpanel");
$view = Request::getVar('view', "home");
$layout = Request::getVar('layout', "display");
if($app != null AND $pagetype == 1){
   
    $cur_temp = "standard"; 
    setSysConfig("sys.template",$cur_temp); 
    setSysConfig("sys.template.path",ROOT_PATH . "themes/backend/$cur_temp/"); 
    setSysConfig("sys.template.url","/themes/backend/$cur_temp/");
    $_path_controller = ROOT_PATH.'protected/apps/backend/'.$app.'/controllers/';
    if(!is_dir($_path_controller)){ 
        echo '<script> '
            . 'document.write("Please contact administrator!!!"); '
            . 'setTimeout(function(){ document.location.href = "'.WEB_URL.'"; },5000); '
        . '</script>';
        die();
    }
        $yiiapp->setControllerPath($_path_controller);
        if(is_dir(ROOT_PATH."themes/backend/$cur_temp"))                  
          $yiiapp->setViewPath(ROOT_PATH."themes/backend/$cur_temp");
        else $yiiapp->setViewPath(ROOT_PATH.'protected/apps/backend/'.$app.'/views/');
     
    $rt = $view . "/".$layout;
    
    yii::import('application.apps.backend.'.$app.'.models.*');
   
    $yiiapp->runController($rt);
}else{     
    $yiiapp->runEnd('backend');
}