<form action="<?php echo $this->createUrl('users/addgroup') ?>" method="post" name="adminForm">    
    <div class="panel role_group">
        <ul>
            <?php
            foreach ($arr_group as $key => $item) {
                if($item['parentID'] == 0) continue;
                $mg = (($item['level'] - 1)*20)."px";
                $str = "margin: 0 0 0 $mg;";
                if ($item['isActive'] != 0){
                       $link_edit = Yii::app()->createUrl("/usergroups/edit")."?cid=".$item['id'];
                       $link_delete = Yii::app()->createUrl("/usergroups/remove")."?cid=".$item['id'];
                       echo '<li style="'.$str.'"><div class="alert alert-info alert-dismissible" role="alert"><strong>' . $item['name'] . '</strong>';
                       echo '<a href="'.$link_edit.'" class="close" ><span aria-hidden="false">&#10000;</span></a>&nbsp;'
                           . '<a href="'.$link_delete.'" class="close" ><span aria-hidden="false">&times;</span></a>';
                       echo '</div>';
                   }else{
                       echo '<li style="'.$str.'"><div class="alert alert-warning alert-dismissible" role="alert"><strong>' . $item['name'] . '</strong>';                
                            echo '</div>';
                   }               
            }
            ?>
        </ul>
    </div>
</form>

<?php
    function subGroup($items, $id) {
        echo '<ul>';
        foreach ($items as $item) {
            if ($item['parent_id'] == $id) {
                if ($item['isActive'] != 0){
                    $link_edit = Yii::app()->createUrl("/usergroups/edit")."?cid=".$item['id'];
                    $link_delete = Yii::app()->createUrl("/usergroups/remove")."?cid=".$item['id'];
                    echo '<li><div class="alert alert-info alert-dismissible" role="alert"><strong>' . $item['name'] . '</strong>';
                    echo '<a href="'.$link_edit.'" class="close" ><span aria-hidden="false">&#10000;</span></a>&nbsp;'
                        . '<a href="'.$link_delete.'" class="close" ><span aria-hidden="false">&times;</span></a>';
                    echo '</div>';
                }else{
                    echo '<li><div class="alert alert-warning alert-dismissible" role="alert"><strong>' . $item['name'] . '</strong>';                
                         echo '</div>';
                }
                
                subGroup($items, $item['id']);
                echo '</li>';
            }
        }
        echo '</ul>';
    }
?>

<style>
    .role_group ul{
        margin-left: -20px;
    }
    .role_group ul li{
        list-style: none;
    }
    
    .alert {
        border: 1px solid transparent;
        border-radius: 4px;
        margin-bottom: 5px;
        padding: 5px;
    }
</style>