<div class="login-block">
    <?php if ($suc): ?>
        <table>
            <tr>
                <td valign="top">
                    <div class="title-login"><h3>Cập nhật thông tin thành công!</h3></div>
                    <?php echo $msg; ?>
                </td>
            </tr>
        </table>        
    <?php else: ?>
        <table>
            <tr>
                <td width="100%" valign="top">
                    <div class="title-login"><h3>Cập nhật thông tin</h3></div>
                    <form name="registerForm" id="registerForm" method="post" action="">
                        <div class="mod-login-content">
                            <div class="rows clearfix">
                                <label class="left">Tên đăng nhập: <strong><?php echo(isset($submit['username']) ? $submit['username'] : ''); ?></strong></label>                                
                            </div>
                            <div class="rows clearfix">
                                <label class="left">Mật khẩu <span class="red">*</span></label>
                                <?php echo form_error('r_password', '<div class="error right">', '</div>') ?>
                                <div class="clearfix"></div>
                                <input autocomplete="off" name="r_password" type="password" class="txt-input" />
                            </div>
                            <div class="rows clearfix">
                                <label class="left">Xác nhận mật khẩu <span class="red">*</span></label>
                                <?php echo form_error('re_password', '<div class="error right">', '</div>') ?>
                                <div class="clearfix"></div>
                                <input autocomplete="off" name="re_password"  type="password" class="txt-input" /> 
                            </div>
                            <div class="rows clearfix">
                                <label class="left">Tên đầy đủ</label>
                                <div class="clearfix"></div>
                                <input value="<?php echo(isset($submit['fullname']) ? $submit['fullname'] : ''); ?>" name="fullname" type="text" class="txt-input" />
                            </div>
                            <div class="rows clearfix">
                                <label class="left">Email <span class="red">*</span></label>
                                <?php echo form_error('email', '<div class="error right">', '</div>') ?>
                                <div class="clearfix"></div>
                                <input value="<?php echo(isset($submit['email']) ? $submit['email'] : ''); ?>" name="email" type="text" class="txt-input" />
                            </div>
                            <div class="rows clearfix">
                                <label class="left">Số điện thoại</label>
                                <?php echo form_error('mobile', '<div class="error right">', '</div>') ?>
                                <div class="clearfix"></div>
                                <input value="<?php echo(isset($submit['mobile']) ? $submit['mobile'] : ''); ?>" name="mobile" type="text" class="txt-input" />
                            </div>
<!--                            <div class="rows clearfix">
                                <label class="left">Mã bảo mật</label>
                                <img id="i_captcha" src="<?php echo site_url('captcha.jpg'); ?>" width="194" height="39" alt="" /><img onclick="$('#i_captcha').attr('src','<?php echo site_url('captcha.jpg'); ?>'+Math.random());" src="<?php echo img_link('run.gif'); ?>" width="20" height="20" alt="" style="cursor:pointer" />
                            </div>
                            <div class="rows clearfix">
                                <label class="left">Nhập mã bảo mật</label>
                                <?php echo form_error('captcha', '<div class="error right">', '</div>') ?>
                                <div class="clearfix"></div>
                                <input autocomplete="off" name="captcha" type="text" class="txt-input" />
                            </div>-->
                            <div class="rows button-set">
                                <input type="hidden" name="register" value="1" />
                                <button type="submit" id="re_submit" class="button"><span>Cập nhật</span></button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
    <?php endif; ?>
</div>