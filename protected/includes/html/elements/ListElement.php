<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ListElement
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

        if(strpos($this->node['attr'], "multiple")){
            $name = $name."[]";
        }
        
        if(!is_array($this->value)) $this->value = array($this->value); 
        
        $html = '<div class="form-group row"> '
                . '<div class="col-md-'.$arr_size[0].'" title="'.$this->node['description'].'">'.$this->node['label'].'</div> '
                . '<div class="col-md-'.$arr_size[1].'"> ';
                    $html .= '<select name="'.$name.'" id="'.$id.'" '.$this->node['attr'].'>';
                    foreach($items as $item){
                        $title = (string)$item;
                        $item['value'] = (string) $item['value'];                        
                        if(in_array($item['value'], $this->value)){
                            $html .= '<option value="'.$item['value'].'" selected="">'.$title.'</option> ';
                        }else $html .= '<option value="'.$item['value'].'">'.$title.'</option> ';
                    }
                    $html .= "</select>";
        $html .= '</div> '
              ." </div>";
        return $html;
    }
}