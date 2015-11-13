<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MenutypeElement
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
        $table_menu = YiiTables::getInstance(TBL_MENU);
        $this->value = (string) $this->value;
        $items = $table_menu->loads("id, title");
        
        $name = $prefix_name."[".$this->node['name']."]";
        $id = $prefix_name."-".$this->node['name']."-";

        $html = '<div class="form-group row"> '
                . '<div class="col-md-'.$arr_size[0].'" title="'.$this->node['description'].'">'.$this->node['label'].'</div> '
                . '<div class="col-md-'.$arr_size[1].'"> ';
                    $html .= '<select name="'.$name.'" id="'.$id.'" '.$this->node['attr'].'>';
                    foreach($items as $item){
                        if($this->value == $item['id']){
                            $html .= '<option value="'.$item['id'].'" selected="">'.$item['title'].'</option> ';
                        }else $html .= '<option value="'.$item['id'].'">'.$item['title'].'</option> ';
                    }
                    $html .= "</select>";
        $html .= '</div> '
              ." </div>";
        return $html;
    }
}