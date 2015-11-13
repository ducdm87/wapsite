<style>
<!--

-->
table.detail tr th{text-align: right;}
table.detail tr th, table.detail tr td{padding: 5px;}
</style>
<div class="editcate_top">
	<div class="title1">
            <div class="column" style="width:100%;"><a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a></div>
        </div>
    <h2><?php //echo lang($MODULE.'_EDIT');?></h2>
    
</div>
<table class="detail">
	<tr>
		<td>
			<p><b><?php echo $row->data?></b></p>
			<span><?php echo $row->sql;?></span>
		</td>
	</tr>
</table>