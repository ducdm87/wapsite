<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor. 
 */

function fnHelperFindMenuUser($view, $layout) {
    $YiiMenu = YiiMenu::getInstance();
    $menuItem = $YiiMenu->getMenuApp("users");
    $found = false;
    foreach ($menuItem as $item) {
        $params = $item['params'];
        if ($params->view == $view AND $params->layout == $layout) {
            return $item['id'];
        }
    }
    return false;
}

// $query: array query [view:detail, id:10 ...]
// build
function usersBuildRoute(& $query) {
    $segments = array();
    if (isset($query['view'])) {
        if(!isset($query['layout']))  $query['layout'] = "";
        if($menuID = fnHelperFindMenuUser($query['view'], $query['layout'])){
                $query['menuID'] = $menuID;
        }else{
            $segments[] = $query['view'];
            $segments[] = $query['layout'];            
        }  
        unset($query['view']);   
        unset($query['layout']);  
    }     
    return $segments;
}
// $segments: array path from url[0: tin-tuc,1:tin-lam-dep ... ]
function usersParseRoute($segments, $_params = null) {
    $n = count($segments);
    $params = array(); 
     
    $params['view'] = $segments[0];
    $params['layout'] = $segments[1];
    
    return $params;
}

