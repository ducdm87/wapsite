<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getMapsColRight($limit = 10) {
    global $mainframe, $db;
    $query = "SELECT * FROM {{xangdau_bando}} WHERE status = 1"
            . " ORDER BY ordering ASC LIMIT $limit ";
    $query_command = $db->createCommand($query);
    $items = $query_command->queryAll();
    return $items;
}

function modYii_Benhvien($content_module, &$module = null) {
    $moduleClass = "";    
    $module_title = $module['title'];
    $showtitle = $module['showtitle'];
    
//	$moduleClass ... 

    if ($content_module) {
        echo '<div class="module mod-benhvien ' . $moduleClass . '">';
            if ($showtitle) {
                echo '<h3 class="mod-head">'
                . '<span class="bground">'
                . '<strong>' . $module_title . '</strong>'
                . '</span>'
                . '</h3>';
            }
            echo '<div class="mod-body">' . $content_module . '</div>';
        echo '</div>';
    }
}
