
<div class="editcate_top">
    <h2><?php //echo lang($MODULE.'_EDIT');?></h2>
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>

<div id="div_message" style="width: 673px;"></div>

<form enctype="multipart/form-data" method="post" action="<?php echo current_url();?>" id="user_form">
<div class="editcate_ct" style="width: 673px;">
	<div class="boxadd">
    	<ul class="metatags">
    		<li>
                <span class="left"><b><?php echo lang($MODULE."_CATEGORY");?></b></span>
                <span class="right">
                	<select name="pid">
                		<option value="0">---Root---</option>
                		<?php foreach($rows as $k => $v):?>
                			<option value="<?php echo $v->id;?>" <?php echo isset($row->pid) && $row->pid == $v->id ? 'selected="selected"' : ''?>><?php echo $v->stt.$v->name;?></option>
                		<?php endforeach;?>
                	</select>
                </span>
            </li>
            <li>
                <span class="left"><b><?php echo lang($MODULE."_NAME");?></b></span>
                <span class="right"><input type="text" name="name"  value="<?php echo $row->name; ?>" style="width:100%;" />
                	
                </span>
            </li>
            <li>
                <span class="left"><b><?php echo lang($MODULE."_NAME_ALIAS");?></b></span>
                <span class="right"><input type="text" name="name_alias"  value="<?php echo $row->name_alias; ?>" style="width:100%;" />
                	
                </span>
            </li>
            <li>
                <span class="left"><b><?php echo lang($MODULE."_LINK");?></b></span>
                <span class="right"><input type="text" name="link"  value="<?php echo (isset($row->link) ? $row->link : site_url()); ?>" style="width:100%;" />
                	
                </span>
            </li>
            <li>
                <span class="left"><b><?php echo lang($MODULE."_TARGET");?></b></span>
                <span class="right">
                	<select name="link_target">
                		<?php if(isset($targets)):?>
                		<?php foreach($targets as $k => $v):?>
                		<option <?php echo (isset($row->target) && $row->target == $k ? 'selected="selected"' : '');?> value="<?php echo $k;?>"><?php echo $v;?></option>
                		<?php endforeach;?>
                		<?php endif;?>
                	</select>
                </span>
            </li>
            <li>
                <span class="left"><b><?php echo lang($MODULE."_ORDER");?></b></span>
                <span class="right"><input type="text" name="order"  value="<?php echo $row->order; ?>" style="width:100%;" />
                	
                </span>
            </li>
            <li>
                <span class="left"><b><?php echo lang("ACTIVE");?></b></span>
                <span class="right">
                	<input type="checkbox" name="active" value="1" <?php echo isset($row->active) && $row->active == 1 ? 'checked="checked"' : '';?>/>
                </span>
            </li>
        </ul>
    </div>
    <div class="btarticle">
    	<input type="button" value="<?php echo lang('CANCEL');?>" class="btn" onclick="$('#light_adct').hide();$('#fade_adct').hide();" />
        <input type="submit" value="<?php echo lang(($row ? 'EDIT' : 'ADD'));?>" class="btn" />

    </div>
</div>
</form>
<script>
$('#user_form').iframer({
    onComplete: function(msg){
    	if(msg == 'yes') {
    		$('#light_adct').hide();$('#fade_adct').hide();
            //load_content('row_<?php echo $user->user_id; ?>', admin_url+'user/load_row/<?php echo $user->user_id; ?>');
            //$('.linecate2').has('#row_<?php echo $user->user_id; ?>').css('background-color', '#FFFFE0');
            location.href = '<?php echo admin_url($module)?>';
    	}
    	else show_error('div_message', msg)
    }
});
</script>
