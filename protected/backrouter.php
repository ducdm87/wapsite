<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
class Router{ 
    static function parseLink($_path)
    {
        return $_path;
    }
    
    static function buildLink($app, $query = null)
    {
         $link = "/backend/?app=$app";
         if(is_array($query) AND count($query)>0){
             $arr_query = array();
            foreach ($query as $key => $_query) {
                if($_query != null AND $_query != "" AND strpos($_query, "-") !== 0)
                $arr_query[] = "$key=$_query";
            }
            if(count($arr_query))
                $link .= "&".implode("&", $arr_query);
         }
         
        return $link;
        
    }
}
 