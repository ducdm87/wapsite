<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor. 
 */

function fnHelperFindMenuUser($view = "home", $layout = "") {
    $YiiMenu = YiiMenu::getInstance();
    $menuItem = $YiiMenu->getMenuApp("users");
    $found = false;
    $itemid = false;
//echo '<meta charset="utf-8">';

    foreach ($menuItem as $item) {         
        $params = $item['params'];
        $_view = isset($params->view)?$params->view:"";
        $_layout = isset($params->layout)?$params->layout:"";
        if($_view == "home") $_view = "";
        if($_layout == "display") $_layout = "";
        if ($_view == $view AND $_layout == $layout) {
            return $item['id'];
        }else if($layout == "" AND $view == $_view){
            $itemid = $item['id'];
        }else{            
        }
    }
    return $itemid;
}

// $query: array query [view:detail, id:10 ...]
// build
function usersBuildRoute(& $query) {
    $segments = array();    
    if ($menuID = fnHelperFindMenuUser($query['view'], $query['layout'])) {
        $query['menuID'] = $menuID;
        unset($query['view']);
        unset($query['layout']);
    }

    return $segments;
}

// $segments: array path from url[0: tin-tuc,1:tin-lam-dep ... ]
function usersParseRoute($segments, $_params = null) {
    $n = count($segments);
    $params = array();
  
    if ($segments[0] == "captcha") {
//        $params['view'] = 'user';
        $params['layout'] = 'captcha';
    } else if ($segments[0] == "re-captcha") {
//        $params['view'] = 'user';
        $params['layout'] = 'captcha';
        $params['refresh'] = '1';
    }
    return $params;
}
