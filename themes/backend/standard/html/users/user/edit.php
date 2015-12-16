
<form action="<?php echo $this->createUrl('users/save') ?>" method="post" name="adminForm" >
    <div class="col-md-7">                    
        <div class="panel">
            <div class="panel-heading">
                <span><b>User Info</b></span>
                <?php
                global $mainframe, $user;
                if ($user->isSuperAdmin()){
                ?>
                <div class="caption pull-right">
                    <a href="javascript:void(0)" class="label label-primary" role="button" data-toggle="modal" data-target="#changePermission">Permission</a>
                </div>
                <?php } ?>
            </div>
            <div class="panel-body">
                <?php echo buildHtml::renderField("text", "username", $item->username, "User Name", "form-control title-generate"); ?>
                <?php echo buildHtml::renderField("password", "changepassword", "", "Password"); ?>
                <?php echo buildHtml::renderField("password", "repassword", "", "Retype Password"); ?>

                <?php echo buildHtml::renderField("text", "first_name", $item->first_name, "First Name"); ?>
                <?php echo buildHtml::renderField("text", "last_name", $item->last_name, "Last Name"); ?>
                <?php echo buildHtml::renderField("text", "email", $item->email, "Email"); ?>                
                <?php echo buildHtml::renderField("text", "mobile", $item->mobile, "Mobile"); ?>
                <?php echo buildHtml::renderField("textarea", "address", $item->address, "Address"); ?>                
                <?php echo buildHtml::renderField("text", "city", $item->city, "City"); ?>

            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="panel">
            <div class="panel-heading">
                <span><b>More info</b></span>                            
            </div>
            <div class="panel-body">
                <?php
                global $user;
                $modelGroup = new Group();
                $group = $modelGroup->getItem($user->groupID);
                ?>
                <?php echo buildHtml::renderField("label", "id", $item->id, "ID"); ?>                 
                <?php echo buildHtml::renderField("label", "cdate", $item->cdate, "Created"); ?>
                <?php echo buildHtml::renderField("label", "mdate", $item->mdate, "Modified"); ?>
                <?php echo buildHtml::renderField("label", "lastvisit", $item->lastvisit, "Last visit"); ?>                 

                <?php
                if ($group->parentID == 1) {
                    echo buildHtml::renderField("label", "status", $lists['status'], "status");
                }

                echo buildHtml::renderList("radio", "Leader", "leader", array(array(1, 'Yes'), array(0, 'No')), $item->leader);

                if ($group->parentID != 1) {
                    echo '<font style="color: red; ">Just create a group leader for children group</font>';
                }
                ?>

            </div>
        </div>

        <div class="panel">
            <div class="panel-heading">
                <span><b>Group</b></span>                            
            </div>
            <div class="panel-body">
                <div class="form-group row">
                    <label class="control-label left col-md-3">Choose</label>
                    <div class="col-md-9"><?php echo $lists['groupID']; ?></div>
                </div>
            </div>
        </div>


    </div>
    <input type="hidden" name="id" value="<?php echo $item->id; ?>">    
    <input type="hidden" name="cid[]" value="<?php echo $item->id; ?>">    
    <input type="hidden" name="formPsermission" id="formPsermission" value='<?php echo json_encode($all_granted); ?>'>    

    <div class="modal fade" id="changePermission" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="uploadExtentionLabel">
        <div class='model-blind hide'></div>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-label="Apply" data-dismiss="modal" class="btn-form close" type="button">
                        <i class="glyphicon glyphicon-remove-sign" style="color: #d43f3a"></i>
                    </button>
                    <button class="btn-form apply-form" type="button">
                        <i class="glyphicon glyphicon-ok-sign" style="color: #4cae4c"></i>
                    </button>
                    <h4 id="myModalLabel" class="modal-title">Change Permission</h4>
                </div>
                <div class="modal-body">
                    <div class="panel-group panel-items-app">
                        <?php 
                        $items_status = $lists['item_status']; 
                        $ext_default_1 = $lists['ext_default_1'];
                         
                        ?>
                        <div class='items-tree user-tree'>
                            <?php
                            showNodeTree($arr_resource, $items_status, $all_granted, $ext_default_1);
                            
                            ?> 
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php function showNodeTree($items, $items_status, $all_granted, $ext_default_1, $level = 0)
{
    $class = $level >1?"line":"";
    echo '<ul class="'.$class.'">';    
        $k = 0; 
        foreach($items as $item){
            $_class = $k==0?"first":($k==count($items)-1?"last":"");
            $img_type = " <img src='/images/icons/affected_$item->affected.png' style='height: 16px;' />";
            $str_title = '';
            $link_edit = Router::buildLink('users', array("view"=>"resource","layout"=>"edit",'cid'=>$item->id));
            $ck = -1;
            if(count($all_granted)){
                if(isset($all_granted['allow'][$item->id])) $ck = 1;
                else if(isset($all_granted['deny'][$item->id])) $ck = 0;
            }
            $_items_status = $items_status;  
             
            if(in_array($item->app, $ext_default_1)){
                $_items_status[0][2] = "success";
            }
            $btn = buildHtml::showBtnGroup('resource-' . $item->id, $_items_status, $ck);
            if($item->status == 1){
                $img_status = " <img src='/images/jassets/icons/tick.png' style='height: 16px;' />";
                $str_title = ' <a href="'.$link_edit.'">'.$item->title."---     ".$item->app.'</a>' 
                        . $img_type . $img_status . $btn;
            }else{
                $img_status = " <img src='/images/jassets/icons/publish_x.png' style='height: 16px;' />";
                $str_title = ' <a href="'.$link_edit.'" style="text-decoration: line-through; color: #999;">'.$item->title.'</a>' 
                        . $img_type . $img_status . $btn;
            }
            if(isset($item->data_child) AND count($item->data_child)>0){                
                    if($level != 0){
                        echo '<li class="folder parent '.$_class.'">';
                        echo '<i class="folder-btn btn-open" rel=""></i>';                        
                        echo $str_title;
                    }else{                        
                        echo '<li>';                        
                        echo ' <a>'.$item->title.'</a>';
                    }
                    
                    $level++;
                    showNodeTree($item->data_child,$items_status, $all_granted, $ext_default_1, $level);
                echo '</li>';
            }else{
                echo '<li class="file '.$_class.'">';
                    echo $str_title;
                echo '</li>';
            }
            $k++;
        }
    echo '</ul>';
}
?>