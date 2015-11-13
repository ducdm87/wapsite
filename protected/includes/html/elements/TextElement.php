<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TextElement
{
    private $node = "";
    private $value = null;
    
    /*
     * $node: node of xml
     */
    function __construct($node, $value = null) {
        $this->node = $node;
        $this->value = $value;
        if($this->value == null)
            $this->value = $this->node['default'];
    }
    function build($prefix_name = "params", $arr_size = array(5,7))
    {
        
        $name = $prefix_name."[".$this->node['name']."]";
        $id = $prefix_name."-".$this->node['name']."-";

        return '<div class="form-group row"> <div class="col-md-'.$arr_size[0].'" title="'.$this->node['description'].'">'.$this->node['label'].'</div> '
                . '<div class="col-md-'.$arr_size[1].'"> <input type="text" value="'.$this->value.'" name="'.$name.'" id="'.$id.'" '.$this->node['attr'].'  /> </div> '
                ." </div>";
    }
}