<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RadioElement
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
        $items = $this->node->option; 
        $this->value = (string) $this->value;         
        $name = $prefix_name."[".$this->node['name']."]";
        $id = $prefix_name."-".$this->node['name']."-";

        $html = '<div class="form-group row"> '
                . '<div class="col-md-'.$arr_size[0].'" title="'.$this->node['description'].'">'.$this->node['label'].'</div> '
                . '<div class="col-md-'.$arr_size[1].'"> ';
                    foreach($items as $item){
                        $title = (string)$item;
                        $item['value'] = (string) $item['value'];
                        if($this->value == $item['value']){
                            $html .= '<input type="radio" value="'.$item['value'].'" checked="" name="'.$name.'" /> '.$title;
                        }else $html .= '<input type="radio" value="'.$item['value'].'" name="'.$name.'" /> '.$title;
                        $html .= "&nbsp; &nbsp; &nbsp; ";
                    }
        $html .= '</div> '
              ." </div>";
        return $html;
    }
}