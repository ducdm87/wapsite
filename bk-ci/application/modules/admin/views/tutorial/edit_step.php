
<div class="editcate_top">
    <h2><?php echo lang($MODULE.'_EDIT');?></h2>
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>

<div id="div_message"></div>

<form enctype="multipart/form-data" method="post" action="<?php echo current_url();?>" id="user_form">
<div class="editcate_ct">
	<div class="boxadd">
    	<ul class="metatags">
            <li>
                <span class="left"><b>Tiêu đề:</b></span>
                <span class="right"><input type="text" name="title"  value="<?php echo $row->title; ?>" style="width:100%;" /></span>
            </li>
            <li>
            	<span class="left"><b>Nội dung:</b></span>
	            <span class="right">
	            	<textarea id="contents" name="contents" rows="10" cols="30"><?php echo $row->content;?></textarea>
	            	 <script type="text/javascript">
						$(function() {	
							if(CKEDITOR.instances['contents']) {						
								CKEDITOR.remove(CKEDITOR.instances['contents']);
							}
							CKEDITOR.config.width = "100%";
							CKEDITOR.config.border = "none";
						    CKEDITOR.config.height = 400;
							CKEDITOR.replace('contents',{
						    	toolbar :
						    		[['Source','Maximize','-','Format','Font','FontSize'],"/",
						    		 ['PasteText','PasteFromWord'],
							         ['TextColor','BGColor','-','Bold','Italic','Underline'],
							         ['NumberedList','BulletedList'],'/',
							         ['Outdent','Indent','Blockquote'],
							         ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
							         ['Image','Table','-', 'Link', 'Unlink' ]]
							});
						})
						</script>    
	            </span>
            </li>
        </ul>
    </div>
    <div class="btarticle">
    	<input type="button" value="<?php echo lang('CANCEL');?>" class="btn" onclick="$('#light_adct').hide();$('#fade_adct').hide();" />
        <input type="submit" value="<?php echo lang('EDIT');?>" class="btn" />

    </div>
</div>
</form>
<script>
$('#user_form').iframer({
    onComplete: function(msg){
    	if(msg == 'yes') {
    		$('#light_adct').hide();$('#fade_adct').hide();
            //load_content('row_<?php echo $user->user_id; ?>', admin_url+'user/load_row/<?php echo $user->user_id; ?>');
            //$('.linecate2').has('#row_<?php echo $user->user_id; ?>').css('background-color', '#FFFFE0');
            location.href = '<?php echo admin_url('tutorial/index')?>';
    	}
    	else show_error('div_message', msg)
    }
});
</script>
