<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class YiiElement
{ 
    /*
     * $node: node of xml
     */
    static function render($node, $value = null, $prefix_name = "params", $_w1 = 5, $_w2 = 7) {
             

        $node['type'] =  isset($node['type'])?$node['type']:"text";
        $node['default'] =  isset($node['default'])?$node['default']:null;
        $node['label'] =  isset($node['label'])?$node['label']:"label field";
        $node['value'] =  isset($node['value'])?$node['value']:"";
        $node['name'] =  isset($node['name'])?$node['name']:$node['type'];
        $node['description'] =  isset($node['description'])?$node['description']:"";
        $node['attr'] =  isset($node['attr'])?$node['attr']:"";
         
        $className = ucfirst($node['type'])."Element";   
        
        if(!in_array(strtolower($node['type']), array("menutype", "list",'radio', 'text', "textarea","catid"))) return "";
        if(!class_exists($className))
        {
            YiiMessage::raseWarning("Element ".$node['type']." is not existing ");           
            exit;
        }
        
        $element = new $className($node, $value);
        return $element->build($prefix_name, array($_w1,$_w2));
    }
} 