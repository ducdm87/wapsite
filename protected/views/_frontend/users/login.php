<?php require_once 'include/header.php'; ?>
<div id="wrapper">
    <div class="section">
        <div class="container">
            <div class="form-entry row">
                <legend class="entry-title">
                    <h4><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/app/key-user.png"/> Đăng Nhập</h4>
                </legend> 
                <div class="form-entry-body">
                    <form class="" method="post" action="<?php echo $this->createUrl('/users/checklogin'); ?>" id="formLogin">
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
                                        <a href="" > Đổi mật khẩu</a>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12 input-control">
            <a href="<?php echo $this->createUrl('/users') ?>" class="btn btn-warning btn-register">Đăng ký tài khoản mới</a>
        </div>
    </div>
</div>
<?php require_once 'include/footer.php'; ?>