
<h1><?php echo lang('GROUP_EDIT');?></h1>

	<?php if($this->message->has('error')):?>
	<?php echo $this->message->display();?>
	<?php endif;?>

    <div class="tableout">
		<div class="title1">
            <div class="column" style="width:100%;"><?php echo lang('GROUP_EDIT');?></div>
        </div>
        <form method="post" action="">
        <div style="width:100%; float:left;">
            <ul class="lineadd2">
                <li>
                    <span class="left"><?php echo lang('GROUP_NAME');?></span>
                    <span class="right"><input type="text" name="name" value="<?php echo $row->name;?>" style="width:60%;" /></span>
                </li>
            </ul>
            
            
        </div>

        <div class="bottomadd">	
        	<input type="submit" onclick="" name="" value="<?php echo lang('EDIT');?>" class="btnsave" />
        </div>
        </form>
        
    </div>