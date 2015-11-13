<div class="editcate_top">
    <h2>Sửa slideshows</h2>
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>

<div id="div_message"></div>

<form enctype="multipart/form-data" method="post" action="<?php echo action_link('edit/'.$articles->id); ?>" id="articles_form">
<div class="editcate_ct">
	<div class="btarticle">
    	<input type="button" value="Cancel" class="btn" onclick="$('#light_adct').hide();$('#fade_adct').hide();" />
        <input type="submit" value="Save & Continute" class="btn" />
    </div>
	<div class="boxadd">
    	<ul class="linect">
    		<li>
                <span class="left"><b>Tên slideshows<font color="red">(*)</font> :</b></span>
                <span class="right"><input type="text" name="txt_title" value="<?php echo $articles->name;?>" style="width:100%; margin:0;" /></span>
            </li>
            <li>
                <span class="left">Ảnh slideshows</span>
                <span class="right">                	
                	<input type="file" name="images" value="" /><br />       	
                	<input type="hidden" name="images_old" value="<?php echo $articles->img_path; ?>" />
                	<p><img src="<?php echo site_url($articles->img_path); ?>" style="width:220px;height:100px;margin-top:10px;"/></p>
                </span>
            </li>  
			<li>
                <b>Mô tả:<font color="red">(*)</font></b>
            </li>
            <li>
                <span class="right"><textarea id="txt_description" name="txt_description"  style="width:100%; height:200px;"><?php echo $articles->description;?></textarea></span>
                           
            </li> 
            <li>
       			<span class="left"><b>Trạng thái:</b></span>
       			 <span class="right">
                    <select style="width:130px;" name="status" id="status">
                      <option <?php echo ($articles->status == 'yes') ? 'selected="selected"' : '';?> value="yes" style="color: blue;">Kích hoạt</option>
                      <option <?php echo ($articles->status == 'no') ? 'selected="selected"' : '';?> value="no" style="color: red;">Chưa kích hoạt</option>
                    </select>
                </span>
       		</li>
       		
        </ul>
    </div>
    <div class="btarticle">
    	<input type="hidden" value="<?php echo $articles->id;?>" name="id_partner"/>
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
            load_content('row_<?php echo $articles->id; ?>', admin_url+'slideshows/load_row/<?php echo $articles->id; ?>');
            $('.linecate2').has('#row_<?php echo $articles->id; ?>').css('background-color', '#FFFFE0');
    	}
    	else show_error('div_message', msg)
    }
});
</script>