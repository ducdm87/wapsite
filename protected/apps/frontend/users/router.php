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

    foreach ($menuItem as $item) {
        $params = $item['params'];
        if ($layout == "") {
            if ($params->view == $view) {
                $itemid = $item['id'];
            }
            if ($params->view == $view AND(!isset($params->layout) OR $params->layout == "" OR $params->layout == 'display')) {
                return $item['id'];
            }
        } else {
            if ($params->view == $view AND $params->layout == $layout) {
                return $item['id'];
            }
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
    } elseif ($menuID = fnHelperFindMenuUser()) {
        $query['menuID'] = $menuID;
    } else {
        $segments[] = $query['view'];
        $segments[] = $query['layout'];
    }

    unset($query['view']);
    unset($query['layout']);

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
