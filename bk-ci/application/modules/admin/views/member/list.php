    
    <div class="toppage">
    	<span class="left">
        	<select style="width: 130px;" id="action">
            	<option value="1">Chọn hành động</option>                               
                <option value="yes">Kích hoạt</option>
                <option value="no">Hủy kích hoạt</option>
                <option value="delete">Xóa</option>
            </select>
            <input onclick="$('[name=action]').val($('#action').val()); $('#action_form').submit()" value="Apply" class="btn" type="button">
        	
        </span>
        <?php if($ADD_ACTION == TRUE):?>
        <span class="btnadd">
        <a onclick="open_form('<?php echo action_link('add'); ?>')" href="javascript:void(0)"><?php echo lang($MODULE.'_ADD_NEW');?></a>
        </span>
        <?php endif;?>
    </div>
    <div class="tableout">
    
    	<?php echo $this->message->display(); ?>
    	
    	<form method="post" action="<?php echo action_link('do_action'); ?>" id="action_form">

		<div class="title1">
        	<div class="column" style="width: 2%;"><input class="check_all" onclick="check_all(this)" type="checkbox"></div>
            <div class="column" style="width: 4%;">STT</div>
            <div class="column" style="width: 26%;">Tên đăng nhập</div>
            <div class="column" style="width: 30%;">Email</div>
            <div class="column ta-center" style="width: 12%;">TK đặt vé&nbsp;|&nbsp;TK chính</div>
            <div class="column" style="width: 16%;">Ngày tạo</div>
            <div class="column ta-center" style="width: 8%;">Kích hoạt</div>
        </div>
        
        <?php if(count($user_list) > 0): ?>
        <?php $limit = $this->config->item('user', 'limit'); ?>
        <?php foreach($user_list as $i => $user): ?>
        <div class="linecate2">
        	<div class="column" style="width: 2%;"><input name="id[]" value="<?php echo $user->user_id; ?>" type="checkbox" /></div>
            <div class="column" style="width: 4%;"><?php echo ($page - 1)*$limit + $i + 1; ?></div>
            
            <div id="row_<?php echo $user->user_id; ?>">
            
            <div class="column" style="width: 26%;" onmouseover="Hovercat('<?php echo $user->user_id; ?>')" onmouseout="Outcat('<?php echo $user->user_id; ?>')">
            	<a href="<?php echo action_link('list_loto/'.$user->user_id); ?>" class="art"><?php echo $user->username; ?></a>
                <div class="action" id="neocat-<?php echo $user->user_id; ?>">
                    <img src="<?php echo img_link('edit.gif', 'admin'); ?>"><a href="javascript:void(0)" onclick="open_form('<?php echo action_link('edit/'.$user->user_id); ?>')">Sửa</a><img src="<?php echo img_link('delete.gif', 'admin'); ?>"><a href="javascript:void(0)" onclick="user_delete('<?php echo $user->user_id; ?>')"><font color="#be0000">Xóa</font></a>
                </div>
            </div>
            <div class="column" style="width: 30%;">
            	<?php echo $user->email; ?>
            </div>
            
            <div class="column ta-center" style="width: 12%;"><font class="date"><?php echo number_format($user->balances,0); ?>&nbsp;|&nbsp;<?php echo number_format($user->balances_main_account,0);?></font><br /><a onclick="open_form('<?php echo action_link('recharge/'.$user->user_id); ?>')">Nạp tiền</a></div>
            
            <div class="column" style="width: 16%;"><font class="date"><?php echo date('d-m-Y', strtotime($user->created_date)); ?></font></div>
            
            <div class="column ta-center" style="width: 6%;">
            <?php if($user->active != 'yes'): ?>
			<a href="javascript:void(0);" onclick="member_status('<?php echo $user->user_id; ?>', 'yes')"><img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Kích hoạt" alt="Kích hoạt"></a>
            <?php else: ?>
			<a href="javascript:void(0);" onclick="member_status('<?php echo $user->user_id; ?>', 'no')"><img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Hủy kích hoạt" alt="Hủy kích hoạt"></a>
            <?php endif; ?>
            </div>
            
            </div>
        </div>
		<?php endforeach; ?>
		<?php endif; ?>

        <div class="bottom1">
        	<div class="column" style="width: 2%;"><input class="check_all" onclick="check_all(this)" value="" type="checkbox"></div>
            <div class="column" style="width: 50%;">
            	<select style="width: 130px;" id="action_name" name="action">
                    <option value="1">Chọn hành động</option>	                
	                <option value="yes">Kích hoạt</option>
	                <option value="no">Hủy kích hoạt</option>
	                <option value="delete">Xóa</option>	                
                </select>
                <input value="Apply" class="btn" type="submit">
            </div>
            <span class="right1">
            	
                <div class="pagination">
                	
                    <ul>
                    <?php echo (isset($pagnav) ? $pagnav : ''); ?>
                    </ul>
                </div>
            </span>
        </div>
        
        </form>
        
    </div>

<script>
$('#action_form').iframer({
    onComplete: function(msg){
    	if(msg == 'yes') {
    		load_content('user_list', '<?php echo current_link(); ?>', true);
    	}
    	else show_error('div_message', msg)
    }
});
</script>