 
<form name="adminForm" method="post" action="">
    <div class='items-tree user-tree'>
        <?php
        showNodeTree($items);
        ?> 
    </div> 
    <?php
    foreach ($items as $item) {
        
    }
    ?>

    <input type="hidden" value="0" name="boxchecked">
    <input type="hidden" value="" name="filter_order">
    <input type="hidden" value="" name="filter_order_Dir">
    <input type="hidden" value="" name="task" />
</form>

<?php function showNodeTree($items, $level = 0)
{
    $class = $level >1?"line":"";
    echo '<ul class="'.$class.'">';    
        $k = 0; 
        foreach($items as $item){
            $_class = $k==0?"first":($k==count($items)-1?"last":"");
            $img_type = " <img src='/images/icons/affected_$item->affected.png' style='height: 16px;' />";
            $str_title = '';
            $link_edit = Router::buildLink("user", array("view"=>"resource","layout"=>"edit",'cid'=>$item->id));
            if($item->status == 1){
                $img_status = " <img src='/images/jassets/icons/tick.png' style='height: 16px;' />";
                $str_title = ' <a href="'.$link_edit.'">'.$item->title.'</a>' . $img_type . $img_status;
            }else{
                $img_status = " <img src='/images/jassets/icons/publish_x.png' style='height: 16px;' />";
                $str_title = ' <a href="'.$link_edit.'" style="text-decoration: line-through; color: #999;">'.$item->title.'</a>' . $img_type . $img_status;
            }
            if(isset($item->data_child) AND count($item->data_child)>0){                
                    if($level != 0){
                        echo '<li class="folder parent '.$_class.'">';
                        echo '<i class="folder-btn btn-open" rel=""></i>';
                        echo '<input id="cb'.$item->id.'" type="checkbox" value="'.$item->id.'" name="cid[]" onclick="isChecked(this.checked);" />';
                        echo $str_title;
                    }else{                        
                        echo '<li>';                        
                        echo ' <a>'.$item->title.'</a>';
                    }
                    
                    $level++;
                    showNodeTree($item->data_child, $level);
                echo '</li>';
            }else{
                echo '<li class="file '.$_class.'">';
                    echo '<input id="cb'.$item->id.'" type="checkbox" value="'.$item->id.'" name="cid[]" onclick="isChecked(this.checked);" />';
                    echo $str_title;
                echo '</li>';
            }
            $k++;
        }
    echo '</ul>';
    
}




