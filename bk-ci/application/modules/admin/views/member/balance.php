<h1>Thống kê số dư</h1>

    <div class="toppage">
    	<span class="left">
        	
        </span>
    </div>
    <div class="tableout">
    
    	<?php echo $this->message->display(); ?>
    	
    	<form method="post" action="<?php echo action_link('do_action'); ?>" id="action_form">

		<div class="title1 border">
        	<div class="column" style="width: 2%;"><input class="check_all" onclick="check_all(this)" type="checkbox"></div>
            <div class="column" style="width: 4%;">STT</div>
            <div class="column" style="width: 10%;">Tên tài khoản</div>
            <div class="column" style="width: 10%;">Số dư(XU)</div>
            <div class="column" style="width: 15%;">Thống kê</div>
            <div class="column" style="width: 10%;">Người chơi</div>
            <div class="column" style="width: 10%;">Thời gian</div>
            <div class="column" style="width: 10%;">Trạng thái</div>
        </div>
        
        <?php if(count($rows) > 0): ?>
        <?php 
			$pages	=	get_pages();
        ?>
        <?php foreach($rows as $i => $row): ?>
        <div class="linecate2">
        	<div class="column" style="width: 2%;"><input name="id[]" value="<?php echo $row->id; ?>" type="checkbox" /></div>
            <div class="column" style="width: 4%;"><?php echo($i+1);?></div>
            
            <div id="row_<?php echo $row->id; ?>">
            
            <div class="column" style="width: 10%;" onmouseover="Hovercat('<?php echo $row->id; ?>')" onmouseout="Outcat('<?php echo $row->id; ?>')">
            	<a href="javascript:;" onclick="open_form('<?php echo action_link('history/'.$row->user_id); ?>')" class="art"><?php echo $row->username; ?></a>
                <div class="action" id="neocat-<?php echo $row->id; ?>">
                    <img src="<?php echo img_link('edit.gif', 'admin'); ?>"><a href="#">Sửa</a><img src="<?php echo img_link('delete.gif', 'admin'); ?>">
                </div>
            </div>
            <div class="column" style="width: 10%; text-align: right;">
            	<?php echo number_format($row->balances,0); ?>
            </div>
            <div class="column" style="width: 15%;">
            	<a href="javascript:;" class="art" style="width: 100%;">Số lần chơi:&nbsp;<?php echo $row->statistic['total']; ?></a>
            	<div style="display: block; width: 100%;" class="action">Thắng:<?php echo $row->statistic['wins']; ?>&nbsp;|&nbsp;Thua:<?php echo $row->statistic['lost']; ?>&nbsp;|&nbsp;Đang chơi:<?php echo $row->statistic['playing']; ?></div>
            </div>
            <div class="column" style="width: 10%;">
            	<?php echo $row->username; ?>
            </div>
            <div class="column" style="width: 10%;">
            	<?php echo (date('H:i d/m/Y',strtotime($row->bet_time))); ?>
            </div>
            <div class="column" style="width: 10%;">
             	<?php echo $row->result_status; ?>
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
	                <option value="active">Kích hoạt</option>
	                <option value="suspend">Hủy kích hoạt</option>
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