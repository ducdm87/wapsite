<div class="register-wapp">
	<div class="pathway clearfix">
		<strong class="left">Thay đổi mật khẩu</strong>
		<ul class="right">
			<li><a href="<?php echo base_url();?>">Trang chủ</a></li>
			<li><span></span></li>
			<li><strong>Thay đổi mật khẩu</strong></li>
		</ul>
	</div>
	<div class="register">
    	<form method="post" action="">
		<div class="page-title"><strong>Thay đổi mật khẩu</strong></div>
		<?php if($suc):?>
        <?php echo $msg;?>
        <?php else:?>
		<div class="frm-register">
			<div class="rows clearfix">
				<label>Mật khẩu hiện tại</label>
				<div class="input-box">
					<input type="password" name="old_pass" class="txt-input space" />
                    <?php if(form_error('old_pass')):?>
					<?php echo form_error('old_pass','<p class="error">','</p>');?>
					<?php endif;?>
				</div>
			</div>
            <div class="rows clearfix">
				<label>Mật khẩu mới</label>
				<div class="input-box">
					<input type="password" name="new_pass" class="txt-input space" />
                    <?php if(form_error('new_pass')):?>
					<?php echo form_error('new_pass','<p class="error">','</p>');?>
					<?php endif;?>
				</div>
			</div>
            <div class="rows clearfix">
				<label>Xác nhận mật khẩu</label>
				<div class="input-box">
					<input type="password" name="re_pass" class="txt-input space" />
                    <?php if(form_error('re_pass')):?>
					<?php echo form_error('re_pass','<p class="error">','</p>');?>
					<?php endif;?>
				</div>
			</div>
			<div class="rows clearfix">
				<label>Mã Kiểm tra </label>
				<div class="input-box">
					<div class="code"><img src="<?php echo site_url('captcha.jpg');?>" width="194" height="39" alt="" /></div><img src="<?php echo img_link('run.gif');?>" width="20" height="20" alt="" /></div>
			</div>
			<div class="rows clearfix">
				<label>Nhập Mã Kiểm tra </label>
				<div class="input-box">
					<input type="text" name="captcha" class="txt-input" />
                    <?php if(form_error('captcha')):?>
					<?php echo form_error('captcha','<p class="error">','</p>');?>
					<?php endif;?>
				</div>
			</div>
		</div>
		<div class="button-set">
			<button type="submit" class="button"><span>Thay đổi mật khẩu</span></button>
			<button type="button" class="button"><span>Hủy bỏ</span></button>
		</div>
		<?php endif;?>
        </form>
	</div>
</div>