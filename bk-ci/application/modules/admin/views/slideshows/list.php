    <div class="toppage">
    	<span class="left">
        	&nbsp;
        	
        </span>
        <span class="btnadd">
        	<a onclick="open_form('<?php echo action_link('update'); ?>')" href="javascript:void(0)"><?php echo lang('SLIDE_ADD');?></a>
        </span>
    </div>
    <div class="tableout">
    
    	<form method="post" action="<?php echo action_link('do_action'); ?>" id="action_form">

		<div class="title1">            
            <div class="column ta-center" style="width: 8%;">#</div>
            <div class="column ta-center" style="width: 30%;"><?php echo lang('SLIDE_IMG_TITLE');?></div>
            <div class="column ta-center" style="width: 30%;"><?php echo lang('DATE');?></div>
            <div class="column ta-center" style="width: 8%;"><?php echo lang('ACTIVE');?></div>
        </div>
        
        <?php if(count($slideshows) > 0): ?>
        <?php $limit = $this->config->item('articles', 'limit'); ?>
        <?php foreach($slideshows as $i => $pro): ?>
        <div class="linecate2" id="linecate2">
            <div class="column ta-center" style="width: 8%;">
            	<a href="javascript:;" class="art"><?php echo $i+1; ?></a><br>
            </div>
            
            <div id="row_<?php echo $pro->id;?>">
            
            <div class="column" style="width: 30%;" onmouseover="Hovercat('<?php echo $pro->id; ?>')" onmouseout="Outcat('<?php echo $pro->id; ?>')">
            	<a href="javascript:;" class="art"><?php echo character_limiter($pro->title,200); ?></a>
                <div class="action" id="neocat-<?php echo $pro->id; ?>">
                    <img src="<?php echo img_link('edit.gif', 'admin'); ?>"><a href="javascript:void(0)" onclick="open_form('<?php echo action_link('update/'.$pro->id); ?>')">Sửa</a><img src="<?php echo img_link('delete.gif', 'admin'); ?>"><a href="javascript:void(0)" onclick="slideshows_delete('<?php echo $pro->id; ?>')"><font color="#be0000">Xóa</font></a>
                </div>
            </div>
                                    
            <div class="column ta-center" style="width: 30%;"><font class="date"><?php echo date('d/m/Y', $pro->time); ?></font></div>
           
            <div class="column ta-center" style="width: 8%;">
	            <?php if($pro->active == 0): ?>
				<a href="<?php echo admin_url($module.'/active/'.$pro->id.'/1')?>" ><img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Kích hoạt" alt="Kích hoạt"></a>
	            <?php else: ?>
				<a href="<?php echo admin_url($module.'/active/'.$pro->id.'/0')?>"><img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Hủy kích hoạt" alt="Hủy kích hoạt"></a>
	            <?php endif; ?>
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
                    <?php echo $pagnav; ?>
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
    		load_content('articles_list', '<?php echo current_link(); ?>', true);
    	}
    	else show_error('div_message', msg)
    }
});
</script>