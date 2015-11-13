<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TextareaElement
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
        
        $cols = $this->node['cols']?(int)$this->node['cols']:20;
        $rows = $this->node['rows']?(int)$this->node['rows']:2;
         

        return '<div class="form-group row"> <div class="col-md-'.$arr_size[0].'" title="'.$this->node['description'].'">'.$this->node['label'].'</div> '
                . '<div class="col-md-'.$arr_size[1].'"> <textarea cols="'.$cols.'" rows="'.$rows.'" type="text" name="'.$name.'" id="'.$id.'" '.$this->node['attr'].'  />'.$this->value.'</textarea> </div> '
                ." </div>";
    }
}