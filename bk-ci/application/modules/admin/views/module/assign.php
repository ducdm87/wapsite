<h1>Phân quyền</h1>

	<?php if($this->message->has('error')):?>
	<div class="error"><h2><?php echo $this->message->display();?></h2></div>
	<?php endif;?>
    
    <script>
	function onCheckAll(name)
	{
		//$('input[type="checkbox"][name="'+name+'"]').attr('checked');
		if($("#a_all_"+name).is(":checked")==false)
		{
			//alert('+++');
			$("#a_add_"+name).removeAttr('checked');
			$("#a_edit_"+name).removeAttr('checked');
			$("#a_delete_"+name).removeAttr('checked');
		}
		else
		{
			$("#a_add_"+name).attr('checked','checked');
			$("#a_edit_"+name).attr('checked','checked');
			$("#a_delete_"+name).attr('checked','checked');
		}
		
	}

	function onCheck(name)
	{
		if($("#a_add_"+name).attr('checked') && $("#a_edit_"+name).attr('checked') && $("#a_delete_"+name).attr('checked'))
		{
			$("#a_all_"+name).attr('checked','checked');
		}
		else
		{
			$("#a_all_"+name).removeAttr('checked');
		}
	}
    </script>
    
    <form method="post" action="">
    <div class="tableout">
		<div class="title1">
            <div class="column" style="width:5%; text-align: center;">No</div>
            <div class="column" style="width:40%;">Tên module</div>
            <div class="column" style="width:34%; text-align: center;">Actions</div>
        </div>
        <?php 
        $CI =& get_instance();
        $CI->load->model('group_module_model','module_model');
        ?>
        <?php foreach($rows as $k => $row):?>
        <div class="linecate2">
            <div class="column" style="width:5%; text-align: center;"><input type="hidden" name="mid[]" value="<?php echo $row->id;?>"/><?php echo ($k+1);?></div>
            <div class="column" style="width:40%;">
            	<a href="javascript:;" class="art"><?php echo $row->name;?></a>
            </div>
            <div class="column" style="width:34%; text-align: center;">
            <?php 
            
            $m	=	$CI->group_module_model->get_by(array('module_id' => $row->id, 'group_id' => $group_id));
            $a_add = false;
            $a_edit = false;
            $a_del = false;
            $a_all	=	false;
            if($m)
            {
            	if($m->actions == 'all')
            	{
            		$a_all = true;
            	}
            	else
            	{
            		$tmp	=	explode(',', $m->actions);
            		foreach($tmp as $v)
            		{
            			if($v == 'add')
            			{
            				$a_add = true;
            			}
            			
            			if($v == 'edit')
            			{
            				$a_edit = true;
            			}
            			
            			if($v == 'delete')
            			{
            				$a_del = true;
            			}
            		}
            	}
            }
            ?>
            	<table style="width: 100%;">
            		<tr>
            			<td>add</td><td><input <?php echo ($a_add || $a_all ? 'checked="checked"' : '');?> onclick="onCheck('<?php echo $row->id;?>');" type="checkbox" id="a_add_<?php echo $row->id;?>" name="a_add_<?php echo $row->id;?>" value="add"/></td>
            			<td>edit</td><td><input <?php echo ($a_edit || $a_all ? 'checked="checked"' : '');?> onclick="onCheck('<?php echo $row->id;?>');" type="checkbox" id="a_edit_<?php echo $row->id;?>" name="a_edit_<?php echo $row->id;?>" value="edit"/></td>
            			<td>delete</td><td><input <?php echo ($a_del || $a_all ? 'checked="checked"' : '');?> onclick="onCheck('<?php echo $row->id;?>');" type="checkbox" id="a_delete_<?php echo $row->id;?>" name="a_delete_<?php echo $row->id;?>" value="delete"/></td>
            			<td>all</td><td><input <?php echo ($a_all ? 'checked="checked"' : '');?> onclick="onCheckAll('<?php echo $row->id;?>');" type="checkbox" id="a_all_<?php echo $row->id;?>" name="a_all_<?php echo $row->id;?>" value="all"/></td>
            			<td></td><td></td>
            		</tr>
            	</table>
            </div>
           
        </div>
        <?php //Funcitons?>
        <?php 
        $functions	=	$CI->module_model->get_many_by(array("pid" => $row->id));
        ?>
        <?php if($functions):?>
        <?php foreach($functions as $k_f => $func):?>
        <div class="linecate2">
            <div class="column" style="width:5%; text-align: center;"><input type="hidden" name="mid[]" value="<?php echo $row->id;?>"/>&nbsp;</div>
            <div class="column" style="width:40%;">
            	<?php echo ($k+1).".".($k_f+1)?>
            	<a href="javascript:;" class="art"><?php echo $func->name;?></a>
            </div>
            <div class="column" style="width:34%; text-align: center;">
            <?php 
            
            ?>
            	<table style="width: 100%;">
            		<tr>
            			<?php 
            			$tmp	=	explode(',', $m->ignore_actions);
            			$ignore = false;
            			foreach($tmp as $v)
            			{
            				if($v == $func->id)
            				{
            					$ignore = true;
            				}
            			}
            			?>
            			<td style="width: 40px;">
            			ignore 
            			</td>
            			<td style="width: 20px; text-align: left;"><input name="fids_<?php echo $row->id;?>[]" type="checkbox" value="<?php echo $func->id;?>" <?php echo ($ignore ? 'checked="checked"' : '');?>/></td>
            		</tr>
            	</table>
            </div>
           
        </div>
        <?php endforeach;?>
        <?php endif?>
        <?php //Functions?>
        <?php endforeach;?>
        <div class="bottom1">
        	<div class="column" style="width:2%;"></div>
            <div class="column" style="width:50%;">
                <input type="submit" name="" value="Apply" class="btn" />
            </div>
            <span class="right1">
            <!--  
                <div class="pagination">
                    <ul>
                        <li><a href="#" class="prevnext disablelink">« Prev</a></li>
                        <li><a href="#" class="currentpage">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a>...</li>
                        <li><a href="#">15</a></li>
                        <li><a href="#">16</a></li>
                        <li><a href="#" class="prevnext">Next »</a></li>
                    </ul>
                </div>-->
            </span>
        </div>
        
    </div>
    <?php echo form_close();?>
    
 <?php //endif;?>