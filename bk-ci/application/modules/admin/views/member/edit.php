<div class="editcate_top">
    <h2><?php echo lang($MODULE.'_EDIT');?></h2>
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>

<div id="div_message"></div>

<form enctype="multipart/form-data" method="post" action="<?php echo action_link('edit/'.$user->user_id); ?>" id="user_form">
<div class="editcate_ct">
	<div class="boxadd">
    	<ul class="metatags">
            <li>
                <span class="left"><b>Tên đăng nhập:</b></span>
                <span class="right"><input type="text" name="username"  value="<?php echo $user->username; ?>" readonly="true" style="width:100%;" /></span>
            </li>
            <li>
                <span class="left"><b>Mật khẩu mới: </b></span>
                <span class="right"><input name="password" type="password" style="width:100%;"></span>
            </li>
            <li>
                <span class="left"><b>Nhập lại mật khẩu: </b></span>
                <span class="right"><input name="re_password" type="password" style="width:100%;"></span>
            </li>
            <li>
                <span class="left"><b><?php echo lang($MODULE.'_FULLNAME');?></b></span>
                <span class="right"><input type="text" name="fullname"  value="<?php echo $user->fullname; ?>" style="width:100%;" /></span>
            </li>
             <li>
                <span class="left"><b><?php echo lang($MODULE.'_GENDER');?></b></span>
                <span class="right">
                	<select name="gender">
                		<option <?php echo ($user->gender == 'nam' ? 'selected="selected"' : '');?> value="nam">Nam</option>
                		<option <?php echo ($user->gender == 'nữ' ? 'selected="selected"' : '');?> value="nu">Nữ</option>
                	</select>
                </span>
            </li>
            <li>
                <span class="left"><b><?php echo lang($MODULE.'_DATE_OF_BIRTH');?></b></span>
                <span class="right"><input type="text" name="date_of_birth"  value="<?php echo $user->date_of_birth; ?>" style="width:100%;" /></span>
            </li>
            <li>
                <span class="left"><b><?php echo lang($MODULE.'_IDENTITY_CARD');?></b></span>
                <span class="right"><input type="text" name="identity_card"  value="<?php echo $user->identity_card; ?>" style="width:100%;" /></span>
            </li>
             <li>
                <span class="left"><b><?php echo lang($MODULE.'_ADDRESS');?></b></span>
                <span class="right"><input type="text" name="address"  value="<?php echo $user->address; ?>" style="width:100%;" /></span>
            </li> <li>
                <span class="left"><b><?php echo lang($MODULE.'_MOBILE');?></b></span>
                <span class="right"><input type="text" name="mobile"  value="<?php echo $user->mobile; ?>" style="width:100%;" /></span>
            </li>
            
            <li>
                <span class="left"><b>Email: </b></span>
                <span class="right"><input name="email" value="<?php echo set_value('email', $user->email); ?>" type="text" style="width:100%;"></span>
            </li>
            <li>
                <span class="left"><b>Hoạt động: </b></span>
                <span class="right">
				    <select name="active" style="width: 200px;">
				       <option <?php echo($user->active == 'yes' ? 'selected="selected"' : '');?> value="yes">Hoạt động</option>
				       <option <?php echo($user->active == 'no' ? 'selected="selected"' : '');?>value="no">Không hoạt động</option>
				    </select>
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
            load_content('row_<?php echo $user->user_id; ?>', admin_url+'member/load_row/<?php echo $user->user_id; ?>');
            $('.linecate2').has('#row_<?php echo $user->user_id; ?>').css('background-color', '#FFFFE0');
    	}
    	else show_error('div_message', msg)
    }
});
</script>
