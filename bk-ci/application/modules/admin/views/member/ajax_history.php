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