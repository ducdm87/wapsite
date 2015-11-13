
<div class="login-block" rel="<?php echo session_id(); ?>">
    <?php if ($suc): ?>
        <table>
            <tr>
                <td valign="top">
                    <div class="title-login"><h3>Đăng ký thành công!</h3></div>
                    <?php echo $msg; ?>
                </td>
            </tr>
        </table>        
    <?php else: ?>
        <table>
            <tr>
                <td width="50%" valign="top">
                    <div class="title-login"><h3>Đăng ký thành viên</h3></div>
                    <form name="registerForm" id="registerForm" method="post" action="">
                        <div class="mod-login-content">
                            <div class="rows clearfix">
                                <label class="left">Tên đăng nhập <span class="red">*</span></label>
                                <?php echo form_error('r_username', '<div class="error right">', '</div>') ?>
                                <div class="clearfix"></div>
                                <input value="<?php echo(isset($submit['r_username']) ? $submit['r_username'] : ''); ?>" autocomplete="off" name="r_username" type="text" class="txt-input" />
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
                                <div class="clearfix"></div>
                                <input value="<?php echo(isset($submit['mobile']) ? $submit['mobile'] : ''); ?>" name="mobile" type="text" class="txt-input" />
                            </div>
                            <div class="rows clearfix">
                                <label class="left">Mã bảo mật</label>
                                <img id="i_captcha" src="<?php echo site_url('captcha.jpg?'.time()); ?>" width="194" height="39" alt="" /><img onclick="$('#i_captcha').attr('src','<?php echo site_url('captcha.jpg'); ?>'+Math.random());" src="<?php echo img_link('run.gif'); ?>" width="20" height="20" alt="" style="cursor:pointer" />
                            </div>
                            <div class="rows clearfix">
                                <label class="left">Nhập mã bảo mật</label>
                                <?php echo form_error('captcha', '<div class="error right">', '</div>') ?>
                                <div class="clearfix"></div>
                                <input autocomplete="off" name="captcha" type="text" class="txt-input" />
                            </div>
                            <div class="rows button-set">
                                <input type="hidden" name="register" value="1" />
                                <button type="submit" id="re_submit" class="button"><span>Đăng ký</span></button>
                            </div>
                            <div class="clearfix">
                                <div><strong>Đăng ký nhanh!!!</strong></div>
                                <div>Soạn tin: <strong class="red">DV</strong> gửi <strong class="red">8017</strong> để nhận tài khoản và mật khẩu để đăng nhập.</div>
    <!--                                <div>Soạn tin: <strong class="red">DV</strong> gửi <strong class="red">8717</strong> để đăng ký tài khoản <strong class="red">VIP</strong></div>-->
                            </div>
                        </div>
                    </form>
                </td>
                <td valign="top">
                    <div class="title-login"><h3>Đăng nhập</h3></div>
                    <form name="loginForm" method="post" action="">
                        <div class="mod-login-content border-left">
                            <div class="rows clearfix">
                                <label class="left">Tên đăng nhập</label>
                                <?php echo form_error('username', '<div class="error right">', '</div>') ?>
                                <div class="clearfix"></div>
                                <input id="login_username" autocomplete="off" name="username" type="text" value="Nhập user hoặc email" class="txt-input" />
                            </div>
                            <div class="rows clearfix">
                                <label class="left">Mật khẩu</label>
                                <?php echo form_error('password', '<div class="error right">', '</div>') ?>
                                <div class="clearfix"></div>
                                <input id="login_password" name="password" autocomplete="off" type="password" value="" class="txt-input" />
                                <input id="login_plain_password" autocomplete="off" name="plain_password" type="text" value="Nhập mật khẩu" class="txt-input" />
                            </div>
                            <div class="rows clearfix">
                                <label><input name="re_pass" value="1" type="checkbox" /> Nhớ mật khẩu</label>
                            </div>
                            <div class="rows button-set">
                                <input type="hidden" name="register" value="0" />
                                <input name="url" type="hidden" value="http://www.xoso.com/chat-full-screen-app.html"/>
                                <button type="submit" class="button"><span>Đăng nhập</span></button>
                            </div>
                            <style type="text/css">
                                .btn-sharelike {
                                    margin: 0 auto;
                                    padding: 10px 0;
                                    width: 175px;
                                }
                                .btn-sharelike a {
                                    float: left;
                                    line-height: 25px;
                                    margin: 0 20px;
                                    padding: 0;
                                    text-align: center;
                                }
                                .btn-sharelike a.suport-yahoo {
                                    margin-right:0;
                                }
                            </style>
                            <div style="width:327px;text-align:center">
                                <div style="font-weight:bold;font-size:11px">Hoặc đăng nhập bằng tài khoản bên dưới</div>
                                <div class="btn-sharelike clearfix">
                                    <div class="sharein">
                                        <a dir="facebook" class="openid o-facebook" rel="nofollow" style="cursor: pointer">
                                            <img src="<?php echo img_link('facebook.gif'); ?>" alt="Đăng nhập với tài khoản facebook" title="Đăng nhập với tài khoản facebook" />
                                            <br />
                                            <span style="font-weight: bold;font-size: 11px;">Facebook</span>
                                        </a>
                                        <a dir="google" class="openid o-google" rel="nofollow" style="cursor: pointer">
                                            <img src="<?php echo img_link('google.gif'); ?>" alt="Đăng nhập với tài khoản Gmail" title="Đăng nhập với tài khoản Gmail" />
                                            <br />
                                            <span style="font-weight: bold;font-size: 11px;">Gmail</span>
                                        </a>
<!--                                        <a dir="twitter" class="openid o-twitter" rel="nofollow" style="cursor: pointer">
                                            <img src="<?php //echo img_link('twitter.gif'); ?>" alt="Đăng nhập với tài khoản Twitter" title="Đăng nhập với tài khoản Twitter" />
                                            <br />
                                            <span style="font-weight: bold;font-size: 11px;">Twitter</span>
                                        </a>
                                        <a dir="yahoo" class="suport-yahoo openid" rel="nofollow" style="cursor: pointer">
                                            <img src="<?php //echo img_link('yahoo.gif'); ?>" alt="Đăng nhập với tài khoản Yahoo" title="Đăng nhập với tài khoản Yahoo" />
                                            <br />
                                            <span style="font-weight: bold;font-size: 11px;">Yahoo</span>
                                        </a>-->
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    jQuery('a.openid').click(function(){
                                        var _width = 700;
                                        var Xpos = ((screen.availWidth - _width)/2);
                                        var _height = 500;
                                        var Ypos =((screen.availHeight - _height)/2);                
                                        vWin = window.open('<?php echo $uri_root ?>openid/' + jQuery(this).attr('dir'),"CM_OpenID","width=" + _width + ",height=" + _height + ",resizable,scrollbars=yes,status=1");        
                                        tWin();
                                    });                   
                                </script>
                            </div>
                            <div class="clearfix">
                                <div><strong>Quên mật khẩu?</strong></div>
                                <div>Soạn tin: <strong class="red">DV &lt;User&gt;</strong> gửi <strong class="red">8017</strong> để nhận ngay mật khẩu mới.</div>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#login_plain_password").show();
                $("#login_password").hide();
                $("#login_username").blur(function(){
                    if(this.value=='' || this.value==' '){this.value='Nhập user hoặc email';}
                });
                $("#login_username").click(function(){
                    if(this.value=='Nhập user hoặc email'){
                        this.value='';
                    }
                    $("#login_password").val('');
                    $("#login_password").hide();
                    $("#login_plain_password").show();
                });
                $("#login_plain_password").focus(function() {
                    $(this).hide();  
                    $("#login_password").show();
                    $("#login_password").focus();  
                });
                $("#login_password").blur(function(){
                    if(this.value=='' || this.value==' '){this.value='Nhập mật khẩu';}
                    if($(this).val().length == 0){
                        $(this).hide();  
                        $("#login_plain_password").show();
                    }   
                });
            });
        </script>
    <?php endif; ?>
</div>