<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getMapsColRight($limit = 10 )
{
    global $mainframe, $db;
    $query = "SELECT * FROM {{xangdau_bando}} WHERE status = 1"
               ." ORDER BY ordering ASC LIMIT $limit ";
    $query_command = $db->createCommand($query);
    $items = $query_command->queryAll();
    return $items;
}