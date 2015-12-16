<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * app/article/
 * app/article/category-cha
 * app/article/category-con
 * app/article/category-con/bai-viet
 * 
 * tin-tuc/
 * tin-tuc/category-cha
 * tin-tuc/category-con
 * tin-tuc/category-con/bai-viet
 */

function fnHelperFindVideosMenuDetail($cid) {
    $YiiMenu = YiiMenu::getInstance();
    $menuItem = $YiiMenu->getMenuApp("videos");
    $found = false;

    foreach ($menuItem as $item) {
        $params = $item['params'];
        if ($params->view == "detail" AND $params->id == $cid) {
            return $item['id'];
        }
    }
    return false;
}

function fnHelperFindVideosMenuCategory($catID) {
    // tim menu chuyen muc
    // fnHelperFindMenuArticles()
    // =>  => menu-article/muc-con/
    $YiiMenu = YiiMenu::getInstance();
    $menuItem = $YiiMenu->getMenuApp("videos");
    foreach ($menuItem as $item) {
        $params = $item['params'];
        if ($params->view == "category" AND $params->id == $catID) {
            return $item['id'];
        }
    }
    return false;
}

function fnHelperFindVideosMenuHome() {
    $YiiMenu = YiiMenu::getInstance();
    $menuItem = $YiiMenu->getMenuApp("videos");
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
function VideosBuildRoute(& $query) {
    $segments = array();
    if (isset($query['view'])) {
        if ($query['view'] == "home") {
            if ($menuID = fnHelperFindVideosMenuHome()) {
                $query['menuID'] = $menuID;
            }
        } elseif ($query['view'] == "category") {
            if ($menuID = fnHelperFindVideosMenuCategory($query['id'])) {
                $query['menuID'] = $menuID;
            } else if ($menuID = fnHelperFindVideosMenuHome()) {
                $query['menuID'] = $menuID;
                $segments[] = $query['alias'];
            }
            if (isset($query['page']) AND $query['page'] == 0)
                unset($query['page']);
            if (isset($query['menuID'])) {
                unset($query['alias']);
                unset($query['view']);
                unset($query['id']);
            }
        } elseif ($query['view'] == "detail") {
            if ($menuID = fnHelperFindVideosMenuDetail($query['id'])) {
                $query['menuID'] = $menuID;
                unset($query['view']);
                unset($query['id']);
                unset($query['alias']);
                unset($query['cat_alias']);
                unset($query['catID']);
            } else {
                if ($menuID = fnHelperFindVideosMenuCategory($query['catID'])) {
                    $query['menuID'] = $menuID;
                    $segments[] = $query['id'] . "-" . $query['alias'];
                } else {
                    if ($menuID = fnHelperFindVideosMenuHome()) {
                        $query['menuID'] = $menuID;
                        $segments[] = $query['cat_alias'];
                        $segments[] = $query['id'] . "-" . $query['alias'];
                    }
                }
            }
            if (isset($query['menuID'])) {
                unset($query['view']);
                unset($query['id']);
                unset($query['alias']);
                unset($query['cat_alias']);
                unset($query['catID']);
            }
        }
    } else {
        if ($menuID = fnHelperFindVideosMenuHome()) {
            $query['menuID'] = $menuID;
        }
    }

    return $segments;
}

// $segments: array path from url[0: tin-tuc,1:tin-lam-dep ... ]
function VideosParseRoute($segments, $_params = null) {
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
