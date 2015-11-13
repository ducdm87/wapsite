<div class="editcate_top">
    <h2>Lịch sử chơi</h2>
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>

    <div class="toppage">
    	<span class="left">
        	
        </span>
    </div>
    <div class="tableout">
    
    	<?php echo $this->message->display(); ?>
    	
    	<form method="post" action="<?php echo action_link('do_action'); ?>" id="action_form">

		<div class="title1 border">
        	<div class="column" style="width: 2%;">#</div>
            <div class="column" style="width: 4%;">STT</div>
            <div class="column" style="width: 10%;">Số đánh</div>
            <div class="column" style="width: 12%;">Số tiền cược</div>
            <div class="column" style="width: 15%;">Kết quả</div>
            <div class="column" style="width: 12%;">Số tiền thắng</div>
            <div class="column" style="width: 10%;">Thời gian đánh</div>
            <div class="column" style="width: 12%;">Ngày </div>
        </div>
        
        <div id="ajax_pagnav">
        <?php if(count($rows) > 0): ?>
        <?php 
			$pages	=	get_pages();
        ?>
        <?php foreach($rows as $i => $row): ?>
        <div class="linecate2">
        	<div class="column" style="width: 2%;">&nbsp;</div>
            <div class="column" style="width: 4%;"><?php echo($i+1);?></div>
            
            <div id="row_<?php echo $row->id; ?>">
            
            <div class="column" style="width: 10%;" onmouseover="Hovercat('<?php echo $row->id; ?>')" onmouseout="Outcat('<?php echo $row->id; ?>')">
            	<a href="javascript:;" class="art"><?php echo $row->numbers; ?></a>
                <div class="action" id="neocat-<?php echo $row->id; ?>">
                    
                </div>
            </div>
            <div class="column" style="width: 12%; text-align: right;">
            	<?php echo number_format($row->bet_values,0); ?>
            </div>
            <div class="column ta-center" style="width: 15%;">
            	<?php echo $row->result_status;?>
            </div>
            <div class="column" style="width: 12%;">
            	<?php echo $row->username; ?>
            </div>
            <div class="column" style="width: 10%;">
            	<?php echo (date('H:i d/m/Y',strtotime($row->bet_time))); ?>
            </div>
            <div class="column" style="width: 12%;">
             	<?php echo date('d/m/Y',strtotime($row->date_on_prize)); ?>
            </div>
            
            </div>
        </div>
		<?php endforeach; ?>
		<?php endif; ?>
		
        <div class="bottom1">
        	<div class="column" style="width: 2%;">&nbsp;</div>
            <div class="column" style="width: 50%;">
            	&nbsp;
            </div>
            <span class="right1">
            	
                <div class="pagination">
                	
                    <ul>
                    <?php echo (isset($pagnav) ? $pagnav : ''); ?>
                    </ul>
                </div>
            </span>
        </div>
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

function ajax_pagnav(url)
{
	//alert(url);
	$("#ajax_pagnav").load(url, function(msg){
		//alert(url);
	});
}
</script>