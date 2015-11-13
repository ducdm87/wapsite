<div class="editcate_top">
    <h2>Danh sách các số đã đặt của thành viên</h2>
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>

<div id="div_message">
<?php //echo $this->message->display('error');?>
</div>

<?php if($this->message->has('error')):?>
	<div><h2><?php echo $this->message->display();?></h2></div>
<?php endif;?>

<form enctype="multipart/form-data" method="post" action="<?php echo current_link();?>" id="user_form">
<div class="editcate_ct">
	<div class="boxadd">
    	<ul class="lineadd2">
            <li>
            	<span class="left"><b>Ngày mở thưởng:</b></span>
                <span class="right"><input name="date"  style="width: 60%;"  value="<?php echo(isset($submit['date']) ? $submit['date'] : '');?>"/></span>
                              
            </li>
            <li>
            	<span class="left"><b>Thời gian đánh:</b></span>
                <span class="right"><input name="bet_time"  style="width: 60%;"  value="<?php echo(isset($submit['bet_time']) ? $submit['bet_time'] : '');?>"/></span>
                              
            </li> 
            <li>
            	<span class="left">&nbsp;</span>
            	<span class="right">
            		<div class="bottom">
            			<input type="submit" value="<?php echo lang('UPDATE');?>" class="btn" onclick="" />
            		</div>
            	</span>
            </li>   
            <!-- 
            <li>
                <span class="left"><b>Nhóm: </b></span>
                <span class="right">
				    <select name="group_id" style="width: 200px; margin-left:5px;">
				        <?php foreach($group_list as $i => $g): ?>
				        <option <?php if($g['group_id'] == set_value('group_id')) echo 'selected'; ?> value="<?php echo $g['group_id']; ?>"><?php echo ucfirst($g['group_name']); ?></option>
				        <?php endforeach; ?>
				    </select>
                </span>
            </li>
        	-->
        </ul>
    </div>
    <div class="btarticle">

    </div>
</div>
</form>
<script>
$('#user_form').iframer({
    onComplete: function(msg){
        //alert(msg);
    	if(msg == 'yes') {
    		$('#light_adct').hide();$('#fade_adct').hide();
    		load_content('list_content', window.location.href, true);
    	}
    	else show_error('div_message', msg);
    }
});
</script>