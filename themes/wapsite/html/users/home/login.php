<div class="page-users-form">
    <div class="container">
        <div class="form-entry row">
            <legend class="entry-title">
                <h4><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/app/key-user.png"/> Đăng Nhập</h4>
            </legend> 
            <div class="form-entry-body">
                <form class="" method="post" action="" id="formLogin">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Tên</label>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mật Khẩu</label>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label class="strong">
                                    <input type="checkbox"  name="remembre"> Lưu mật khẩu
                                </label>
                                <span class="btn-forget">

                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="btn-user">
                            <button class="btn btn-block" type="submit">Đăng Nhập</button>
                        </div>
                    </div>
                    <input type="hidden" name="submitform" value="regies account" />
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 input-control">
        <a href="<?php echo Router::buildLink('users', array('layout' => 'register')); ?>" class="btn btn-info">Đăng ký tài khoản mới</a>
        <a href="<?php echo Router::buildLink('users', array('layout' => 'forgotpass')); ?>" class="btn btn-success">Quên mật khẩu</a>
    </div>

</div>
