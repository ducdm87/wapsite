 
<div class="mod-menu mod-<?php echo $params->moduleclass_sfx; ?>">
    <?php if($module['showtitle'] == 1){?>
        <div class="mod-title">
            <h3 class="head">
                <span class="bground">
                    <strong><?php echo $module['title']; ?></strong>
                </span>
            </h3>
        </div>
    <?php } ?>
    <div class="mod-body">
        <ul class="nav navbar-nav">
        <?php
            if(count($items))
            foreach($items as $item){
                showNodeMenu($item, $showChildren);
            }
        ?>
        </ul>
    </div>
</div>

<?php

function showNodeMenu($items, $showChildren = 1){
    $url = isset($items->url)?$items->url:$items->link;
    echo '<li>';
        echo '<a class="" href="'.$url.'">'.$items->title.'</a>';
        if($showChildren == 1 AND isset($items->data_child)){
            $level = $items->level + 1;
            echo '<ul class="children level-'.$level.'">';
            foreach($items->data_child as $item){
                showNodeMenu($item, $showChildren);
            }
            echo '</ul>';
        }                    
    echo '</li>';
}