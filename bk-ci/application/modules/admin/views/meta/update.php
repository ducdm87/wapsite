<script type="text/javascript" src="<?php echo html_url();?>public/ckeditor/ckeditor.js"></script>
<div class="editcate_top">
    <h2><?php echo lang($MODULE.'_UPDATE');?></h2>
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>

<?php if($this->message->has('error')):?>
	<div><h2><?php echo $this->message->display();?></h2></div>
<?php endif;?>

<form enctype="multipart/form-data" method="post" action="" id="user_form">
<div class="editcate_ct">
	<div class="boxadd">
    	<ul class="lineadd2">
    		<!-- 
    		<li>
                <span class="left"><b>Page: </b></span>
                <span class="right">
                	<?php 
                	//$CI	=& get_instance();
                	//$CI->config->load('common_conf');
                	//$pages	=	$CI->config->item('pages');
                	?>
				    <select name="page" style="width: 200px; margin-left:5px;"><?php //echo $input['page']?>
				       <?php foreach($pages as $k => $v):?>
				       <option <?php echo(isset($input['page']) && $input['page'] == $v->id ? 'selected="selected"' : '');?> value="<?php echo $v->id;?>"><?php echo $v->title;?></option>
				       <?php endforeach;?>
				    </select>
                </span>
            </li> -->
            <li>
            	<span class="left"><b><?php echo lang($MODULE.'_NAME_ALIAS');?></b></span>
                <span class="right"><input name="name_alias"  style="width: 60%;"  value="<?php echo(isset($input['name_alias']) ? $input['name_alias'] : '');?>"/></span>
                              
            </li>
            <li>
            	<span class="left"><b><?php echo lang($MODULE.'_NAME');?></b></span>
                <span class="right"><input name="name"  style="width: 60%;"  value="<?php echo(isset($input['name']) ? $input['name'] : '');?>"/></span>
                              
            </li>
            <li>
            	<span class="left"><b><?php echo lang($MODULE.'_TITLE_CONTENT');?></b></span>
                <span class="right"><input name="title_content"  style="width: 60%;"  value="<?php echo(isset($input['title_content']) ? $input['title_content'] : '');?>"/></span>
                              
            </li>
    		<li>
            	<span class="left"><b><?php echo lang($MODULE.'_TITLE');?></b></span>
                <span class="right"><input name="title"  style="width: 60%;"  value="<?php echo(isset($input['title']) ? $input['title'] : '');?>"/></span>
                              
            </li>
            <li>
            	<span class="left"><b>Mô tả</b></span>
                <span class="right"><textarea id="desc" name="desc"  style="width:60%; height:100px;"><?php echo(isset($input['description']) ? $input['description'] : '');?></textarea></span>
                              
            </li> 
            <li>
            	<span class="left"><b>Từ khóa</b></span>
                <span class="right"><textarea id="keyword" name="keyword"  style="width:60%; height:100px;"><?php echo(isset($input['keywords']) ? $input['keywords'] : '');?></textarea></span>
                              
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
<script type="text/javascript" src="<?php echo base_url();?>public/ckeditor/ckeditor.js"></script>