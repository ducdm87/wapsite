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
 

function fnHelperFindMenuUsers() {
    $YiiMenu = YiiMenu::getInstance();
    $menuItem = $YiiMenu->getMenuApp("users");
    foreach ($menuItem as $item) {
        $params = $item['params'];
        if ($params->view == "home") {
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
        }        
    }
        
    unset($query['view']);   
    unset($query['layout']);   
    return $segments;
}

// $segments: array path from url[0: tin-tuc,1:tin-lam-dep ... ]
function usersParseRoute($segments, $_params = null) {
    $n = count($segments);
    $params = array();
    $segment = array_pop($segments);

    if ($_params == null) {
        if ($n == 1) {
            $params['view'] = "category";
            $params['alias'] = $segment;
            $params['id'] = intval($segment);
        } else {
            $params['view'] = "detail";
            $params['id'] = intval($segment);
        }
    } else {

        if ($_params->view == "category") {
            $params['view'] = "detail";
            $params['id'] = intval($segment);
        } else if ($_params->view == "home") {
            if ($n == 1) {
                $params['view'] = "category";
                $params['alias'] = $segment;
                $params['id'] = intval($segment);
            } else {
                $params['view'] = "detail";
                $params['id'] = intval($segment);
            }
        }
    }
    return $params;
}
