<div class="page-users-form"> 
        <div class="container">
            <div class="form-entry row">
                <legend class="entry-title">
                    <h4><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/app/key-user.png"/> Đổi mật khẩu</h4>
                </legend> 
                <div class="form-entry-body">
                    <form class="" method="post" action="" id="formLogin">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Mật khẩu cũ</label>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Mật khẩu mới</label>
                                <div class="form-group">
                                    <input type="password" name="new-password" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nhập lại mật khẩu mới</label>
                                <div class="form-group">
                                    <input type="password" name="renew-password" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <div class="btn-user">
                                <button class="btn btn-block" type="submit">Thay đổi</button>
                            </div>
                        </div>
                        <input type="hidden" name="submitform" value="change pass" />
                    </form>
                </div>
            </div>
        </div>
    </div>
     
        <div class="col-md-12 input-control">
            <a href="<?php echo Router::buildLink('users', array('layout'=>'register')); ?>" class="btn btn-warning btn-register">Đăng ký tài khoản mới</a>
        </div>
     
</div>