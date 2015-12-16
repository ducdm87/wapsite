
<form action="<?php echo Router::buildLink("users", array("view" => "group")) ?>" method="post" name="adminForm" >
    <div class="row">
        <div class="panel panel-primary">             
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <span><b>Group Info</b></span>                            
                        </div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <label class="control-label left col-md-3">Name</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="form-control title-generate" value="<?php echo $item->name; ?>">
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label class="control-label left col-md-3">Status</label>
                                <div class="col-md-9"><?php echo buildHtml::choseStatus("status", $item->status); ?></div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label left col-md-3">Parent Item</label>
                                <div class="col-md-9"><?php echo $lists['parentID']; ?></div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label left col-md-3">Ordering</label>
                                <div class="col-md-9"><?php echo $lists['ordering']; ?></div>
                            </div>
                            <?php echo buildHtml::renderList("radio", "IS Backend", 'backend', array(array(1, 'Yes'), array(0, 'No')), $item->backend, null, 3, 9); ?>
                        </div>
                    </div>
                </div>

                <?php if($item->parentID != 1){ ?>
                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <span><b>Permission</b></span>                            
                            </div>
                            <div class="panel-body">
                                <?php 
                                $items_status = $lists['item_status'];
                                $ext_default_1 = $lists['ext_default_1']; ?>
                                <div class='items-tree user-tree'>
                                    <?php
                                    showNodeTree($arr_resource, $items_status, $all_granted, $ext_default_1);
                                    ?> 
                                </div> 
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="<?php echo $item->id; ?>">    
    <input type="hidden" name="cid[]" value="<?php echo $item->id; ?>">    
</form>
<?php

function showNodeTree($items, $items_status, $all_granted, $ext_default_1, $level = 0) {
    $class = $level > 1 ? "line" : "";
    echo '<ul class="' . $class . '">';
    $k = 0;
    foreach ($items as $item) {
        $_class = $k == 0 ? "first" : ($k == count($items) - 1 ? "last" : "");
        $img_type = " <img src='/images/icons/affected_$item->affected.png' style='height: 16px;' />";
        $str_title = '';
        $link_edit = Router::buildLink('users', array("view" => "resource", "layout" => "edit", 'cid' => $item->id));
        $ck = -1;
        if (count($all_granted)) {
            if (isset($all_granted['allow'][$item->id]))
                $ck = 1;
            else if (isset($all_granted['deny'][$item->id]))
                $ck = 0;
        }
//        var_dump($ext_default_1); die;
        $_items_status = $items_status;
        if(in_array($item->app, $ext_default_1)){
            $_items_status[0][2] = "success";
        }
        $btn = buildHtml::showBtnGroup('resource-' . $item->id, $_items_status, $ck);
        if ($item->status == 1) {
            $img_status = " <img src='/images/jassets/icons/tick.png' style='height: 16px;' />";
            $str_title = ' <a href="' . $link_edit . '">' . $item->title . '</a>'
                    . $img_type . $img_status . $btn;
        } else {
            $img_status = " <img src='/images/jassets/icons/publish_x.png' style='height: 16px;' />";
            $str_title = ' <a href="' . $link_edit . '" style="text-decoration: line-through; color: #999;">' . $item->title . '</a>'
                    . $img_type . $img_status . $btn;
        }
        if (isset($item->data_child) AND count($item->data_child) > 0) {
            if ($level != 0) {
                echo '<li class="folder parent ' . $_class . '">';
                echo '<i class="folder-btn btn-open" rel=""></i>';
                echo $str_title;
            } else {
                echo '<li>';
                echo ' <a>' . $item->title . '</a>';
            }

            $level++;
            showNodeTree($item->data_child, $items_status, $all_granted, $ext_default_1, $level);
            echo '</li>';
        } else {
            echo '<li class="file ' . $_class . '">';
            echo $str_title;
            echo '</li>';
        }
        $k++;
    }
    echo '</ul>';
}
?>