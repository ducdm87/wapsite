
<h1><?php echo lang('FUNCTION_EDIT');?></h1>

	<?php if($this->message->has('error')):?>
	<?php echo $this->message->display();?>
	<?php endif;?>

    <div class="tableout">
		<div class="title1">
            <div class="column" style="width:100%;"><?php echo lang('FUNCTION_EDIT');?></div>
        </div>
        <form method="post" action="">
        <div style="width:100%; float:left;">
            <ul class="lineadd2">
                <li>
                    <span class="left"><?php echo lang('FUNCTION_NAME');?></span>
                    <span class="right"><input type="text" name="name" value="<?php echo $row->name;?>" style="width:60%;" /></span>
                </li>
                <li>
                    <span class="left"><?php echo lang('FUNCTION_NAME_ALIAS');?></span>
                    <span class="right"><input type="text" name="name_alias" value="<?php echo $row->name_alias;?>" style="width:60%;" /></span>
                </li>
                <li>
                    <span class="left"><?php echo lang('FUNCTION_ORDER');?></span>
                    <span class="right"><input type="text" name="order" value="<?php echo $row->order?>" style="width:40%;" /></span>
                </li>
            </ul>
            
            
        </div>

        <div class="bottomadd">	
        	<input type="submit" onclick="" name="" value="<?php echo lang('EDIT');?>" class="btnsave" />
        </div>
        </form>
        
    </div>