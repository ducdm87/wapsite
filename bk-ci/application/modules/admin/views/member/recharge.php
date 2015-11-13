<div class="editcate_top">
    <h2>Nạp tiền</h2>
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>

<div id="div_message">
<?php //echo $this->message->display('error');?>
</div>

<form enctype="multipart/form-data" method="post" action="<?php echo current_url();?>" id="user_form">
<div class="editcate_ct">
	<div class="boxadd">
    	<ul class="metatags">
    		<li>
                <span class="left"><b>Chuyển vào tài khoản</b></span>
                <span class="right">
                	<select name="account_type">
                		<option value="main">Tài khoản chính</option>
                		<option value="loto">Tài khoản đặt vé</option>
                	</select>
                </span>
            </li>
            <li>
                <span class="left"><b>Số tài khoản chuyển</b></span>
                <span class="right"><input type="text" name="account_from"  value="<?php echo $user->username; ?>" style="width:100%;" /></span>
            </li>
            <li>
                <span class="left"><b>Số tài khoản nhận</b></span>
                <span class="right"><input type="text" name="account_to"  value="<?php echo $user->fullname; ?>" style="width:100%;" /></span>
            </li>
            <li>
                <span class="left"><b>Số tiền chuyển</b></span>
                <span class="right"><input type="text" name="values"  value="<?php echo $user->date_of_birth; ?>" style="width:100%;" /></span>
            </li>
            <li>
                <span class="left"><b>Nội dung tin nhắn</b></span>
                <span class="right">
                	<textarea style="width: 100%;" rows="6" name="message" cols=""></textarea>
                </span>
            </li>
        </ul>
    </div>
    <div class="btarticle">
    	<input type="button" value="<?php echo lang('CANCEL');?>" class="btn" onclick="$('#light_adct').hide();$('#fade_adct').hide();" />
        <input type="submit" value="<?php echo lang('ADD');?>" class="btn" />

    </div>
</div>
</form>
<script>
$('#user_form').iframer({
    onComplete: function(msg){
        //alert(msg);
    	if(msg == 'yes') {
    		$('#light_adct').hide();$('#fade_adct').hide();
    		load_content('user_list', window.location.href, true);
    	}
    	else show_error('div_message', msg)
    }
});
</script>
