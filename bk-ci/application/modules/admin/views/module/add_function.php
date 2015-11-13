
<h1><?php echo lang('FUNCTION_ADD_NEW');?></h1>

	<?php if($this->message->has('error')):?>
	<?php echo $this->message->display();?>
	<?php endif;?>

    <div class="tableout">
		<div class="title1">
            <div class="column" style="width:100%;"><?php echo lang('FUNCTION_ADD_NEW');?></div>
        </div>
        <form method="post" action="">
        <div style="width:100%; float:left;">
            <ul class="lineadd2">
                <li>
                    <span class="left"><?php echo lang('FUNCTION_NAME');?></span>
                    <span class="right"><input type="text" name="name" value="<?php echo set_value('name');?>" style="width:60%;" /></span>
                </li>
                <li>
                    <span class="left"><?php echo lang('FUNCTION_NAME_ALIAS');?></span>
                    <span class="right"><input type="text" name="name_alias" value="<?php echo set_value('name_alias');?>" style="width:60%;" /></span>
                </li>
                <li>
                    <span class="left"><?php echo lang('FUNCTION_ORDER');?></span>
                    <span class="right"><input type="text" name="order" value="" style="width:60%;" /></span>
                </li>
            </ul>
            
            
        </div>

        <div class="bottomadd">	
        	<input type="submit" onclick="" name="" value="<?php echo lang('ADD');?>" class="btnsave" />
        </div>
        </form>
        
    </div>