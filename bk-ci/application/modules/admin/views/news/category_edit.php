
<h1><?php echo lang($MODULE.'_CATEGORY_EDIT');?></h1>

	<?php if($this->message->has('error')):?>
	<?php echo $this->message->display();?>
	<?php endif;?>
<?php //print_r($row);?>
    <div class="tableout">
		<div class="title1">
            <div class="column" style="width:100%;"><?php echo lang($MODULE.'_CATEGORY_EDIT');?></div>
        </div>
        <form method="post" action="">
        <div style="width:100%; float:left;">
            <ul class="lineadd2">
            	<li>
                    <span class="left"><?php echo lang($MODULE.'_CATEGORY_PARENT');?></span>
                    <span class="right">
                    	<select name="pid">
                    	<option value="0">----ROOT----</option>
                    	<?php foreach($cats_tree as $k => $v):?>
                    		<option <?php echo($row->pid == $v->id ? 'selected="selected"' : '');?> value="<?php echo $v->id;?>"><?php echo $v->name;?></option>
                    		
                    	<?php endforeach;?>
                    	</select>
                    </span>
                </li>
                <li>
                    <span class="left"><?php echo lang($MODULE.'_CATEGORY_NAME');?></span>
                    <span class="right"><input type="text" name="name" value="<?php echo $row->name;?>" style="width:40%;" /></span>
                </li>
                <li>
                    <span class="left"><?php echo lang('ORDER');?></span>
                    <span class="right"><input type="text" name="order" value="<?php echo $row->order;?>" style="width:10%;" /></span>
                </li>
                <li>
                    <span class="left"><?php echo lang('ACTIVE');?></span>
                    <span class="right"><input <?php echo ($row->active == 'yes' ? 'checked="checked"' : '');?> type="checkbox" name="active" value="yes" /></span>
                </li>
            </ul>
            
            
        </div>

        <div class="bottomadd">	
        	<input type="submit" onclick="" name="" value="<?php echo lang('EDIT');?>" class="btnsave" />
        </div>
        </form>
        
    </div>