		<?php if(isset($slideshows)): ?>			
           <div class="column" style="width: 30%;" onmouseover="Hovercat('<?php echo $slideshows->id; ?>')" onmouseout="Outcat('<?php echo $slideshows->id; ?>')">
            	<a href="javascript:;" class="art"><?php echo character_limiter($slideshows->name,200); ?></a>
                <div class="action" id="neocat-<?php echo $slideshows->id; ?>">
                    <img src="<?php echo img_link('edit.gif', 'admin'); ?>"><a href="javascript:void(0)" onclick="open_form('<?php echo action_link('edit/'.$slideshows->id); ?>')">Sửa</a><img src="<?php echo img_link('delete.gif', 'admin'); ?>"><a href="javascript:void(0)" onclick="slideshows_delete('<?php echo $slideshows->id; ?>')"><font color="#be0000">Xóa</font></a>
                </div>
            </div>
                                    
            <div class="column" style="width: 30%;"><font class="date"><?php echo date('d-m-Y', strtotime($slideshows->date_create)); ?></font></div>
           
            <div class="column" style="width: 8%;">
	            <?php if($slideshows->status == 'no'): ?>
				<a href="javascript:void(0);" onclick="slideshows_status('<?php echo $slideshows->id;?>', 'yes')"><img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Kích hoạt" alt="Kích hoạt"></a>
	            <?php else: ?>
				<a href="javascript:void(0);" onclick="slideshows_status('<?php echo $slideshows->id;?>', 'no')"><img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Hủy kích hoạt" alt="Hủy kích hoạt"></a>
	            <?php endif; ?>
            </div>
		<?php endif; ?>