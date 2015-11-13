<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 



class YiiObject extends stdClass{ 
      
    function __construct($db = null) {
    }
    
    function bind($fromArray){
        foreach ($this as $field_name => $field_value) {
            if(strpos($field_name, "_") !== false) continue;
            if (isset($fromArray[$field_name]) and $fromArray[$field_name] != "" and $fromArray[$field_name] != null)
                $this->$field_name = $fromArray[$field_name];
        }
        return $fromArray;
    }
}
