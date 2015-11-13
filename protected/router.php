<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
class Router{
    
    // khi vào trang bất kỳ, gọi hàm này để parse from url
    static function parseLink($_path)
    {
        $_path = str_replace(".html", "", $_path);
        $YiiMenu = YiiMenu::getInstance();
        $db = Yii::app()->db;
        $params = array();        
        $all_menu = $YiiMenu->getItems();
      //  var_dump($path); die;
        $app = Request::getVar('app',null);
        $menuID = Request::getVar('menuID',null);
        
        if($app != null OR $menuID != null ){
            $params = $_REQUEST;
        }else{
            $path = trim($_path, "/");            
            $arr_path = array($path);
            $paths = explode("/", $path);
            $length = count($paths);
            
            for($i=$length - 1; $i >0; $i--){
                unset($paths[$i]);
                $arr_path[] = implode("/",$paths);
            }
             
            
            $_arr_path = array();
            $found_menu = false;
            if(count($arr_path) >0){
                foreach($arr_path as $path){
                    foreach ($all_menu as $key => $menu) {
                        if($path == trim($menu['path'],"/")){
                            $menuID = $key;
                            $found_menu = true;
                            break 2;
                        }
                    }
                }
            }
           
            if($menuID ==null){
                $menuID = $YiiMenu->getActive();
            }
            
            $item = $YiiMenu->getItem($menuID);
            $app_router = null;
            if($found_menu == true){
                $url1 = trim($item['url'],"/");
                $url2 = trim($_path,"/");
                if($url1 !== $url2){
                    $_app = $item['params']->app;
                    $app_router =  PATH_APPS_FRONT."$_app/router.php"; 
                    $sub_path = preg_replace("|$url1|ism", "", $url2, 1);
                    $params = $item['params'];
                }
            }else{ 
                if(preg_match("/app\/([\d\w]+)(.*?)$/",$_path, $matches)){
                    $_app = $matches[1];                    
                    $app_router =  PATH_APPS_FRONT."$_app/router.php";
                    $sub_path = $matches[2];
                    $params = null;
                }
            }
            if($app_router != null){
                $sub_path = trim($sub_path,"/");
                $segments = explode("/", $sub_path);
                $functionName = $_app."ParseRoute";
                require_once $app_router;
                $params = $functionName($segments, $params);
                $params['app'] = $_app; 
            }else if($item['params'] != null){
                foreach ($item['params'] as $key => $value) {
                    $params[$key] = $value;
                }            
           }
        }
         
        $params['menuID'] = $menuID;
        setSysConfig("sys.menuID", $menuID); 
         
        foreach ($params as $key => $value) {
            $_GET[$key] = $value;
            $_REQUEST[$key] = $value;
            $_POST[$key] = $value;
        }
        if(!isset($params['layout']) OR $params['layout'] == "" ) $params['layout'] = "display";
        return $params;
    }
    
    static function buildLink($app, $query = null)
    {
        $app_router =  PATH_APPS_FRONT."$app/router.php";
        $functionName = $app."BuildRoute";
         
        if(file_exists($app_router)){
            require_once $app_router;
          
            if(function_exists($functionName)){
                $segments = $functionName($query);
                
                $link = "";
               
                if(isset($query['menuID']) AND $query['menuID'] !=0){
                    $YiiMenu = YiiMenu::getInstance();
                    $item = $YiiMenu->getItem($query['menuID']);
                    $link = $item['url'];
                    unset($query['menuID']);
                }else{
                    $link = "/app/$app";
                }
               
                $link .= "/".implode("/", $segments);
                $suffix = "";
                if(isset($query['_suffix'])){
                    $suffix = $query['_suffix'];
                    unset($query['_suffix']);
                }
                if(count($query)){
                    $arr_query = array();
                    foreach ($query as $key => $_query) {
                        $arr_query[] = "$key=$_query";
                    }
                    $link .= "?".implode("&", $arr_query);
                } 
                 
                return $link.$suffix;
            }
        }
        
                   
        $link = "app/$app";
        if(count($query)){
             $arr_query = array();
            foreach ($query as $key => $_query) {
                $arr_query[] = "$key=$_query";
            }
            $link .= "?".implode("&", $arr_query);
        }
        return $link;
        
    }
}
 