<div class="editcate_top">
    <h2><?php echo lang("SLIDE_ADD");?></h2>
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>

<div id="div_message"></div>

<form enctype="multipart/form-data" method="post" action="<?php echo current_link(); ?>" id="articles_form">
<div class="editcate_ct">
	<div class="btarticle">
    	<input type="button" value="Cancel" class="btn" onclick="$('#light_adct').hide();$('#fade_adct').hide();" />
        <input type="submit" value="Save & Continute" class="btn" />
    </div>
	<div class="boxadd">
    	<ul class="metatags">     	   	
            <li>
                <span class="left"><b><?php echo lang('SLIDE_IMG_TITLE');?><font color="red">(*)</font> :</b></span>
                <span class="right"><input type="text" name="txt_title" value="<?php echo(isset($row->title) ? $row->title : '');?>" style="width:100%; margin:0;" /></span>
            </li>
            <li>
                <span class="left"><?php echo lang('IMAGE');?></span>
                <span class="right">                	                	
                	<input type="file" name="images" value="" /><br /><br />
                	<img width="240" src="<?php echo site_url(isset($row->img) ? $row->img : '')?>"/>             	
                </span>
            </li>
            <li>
                <span class="left"><b><?php echo lang('SLIDE_URL');?><font color="red"></font> :</b></span>
                <span class="right"><input type="text" name="txt_url" value="<?php echo(isset($row->url) ? $row->url : '');?>" style="width:100%; margin:0;" /></span>
            </li>
            <li>
            	<span class="left"><?php echo lang('SLIDE_IMG_DESC');?></span>
                <span class="right"><textarea id="desc" name="txt_description"  style="width:100%; height:200px;"><?php echo(isset($row->desc) ? $row->desc : '');?></textarea></span>
                            
            </li> 
            <li>
                <span class="left"><?php echo lang('ORDER');?></span>
                <span class="right"><input type="text" name="order" value="<?php echo(isset($row->order) ? $row->order : '');?>" style="width:20%; margin:0;" /></span>
            </li>          
               
       		<li>
       			<span class="left"><b><?php echo lang('ACTIVE');?></b></span>
       			<span class="right">
                	<input type="checkbox" name="active" value="1" <?php echo (isset($row->active) && $row->active == 1 ? 'checked="checked"' : '');?>/> 
                </span>
       		</li>
       		
        </ul>
    </div>
    <div class="btarticle">
    	<input type="button" value="Cancel" class="btn" onclick="$('#light_adct').hide();$('#fade_adct').hide();" />
        <input type="submit" value="Save & Continute" class="btn" />

    </div>
</div>
</form>
<script>
$('#articles_form').iframer({
    onComplete: function(msg){
    	if(msg == 'yes') {
    		$('#light_adct').hide();$('#fade_adct').hide();
            load_content('articles_list', window.location.href, true);
    	}
    	else show_error('div_message', msg)
    }
});
</script>