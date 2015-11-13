<?php require_once 'include/header.php'; ?>
<div id="wrapper">
    <div class="section">
        <div class="container">
            <div class="form-entry row">
                <legend class="entry-title">
                    <h4><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/app/key-user.png"/> Đăng Ký Tài khoản <strong>DG MEDIA</strong></h4>
                </legend> 
                <div class="form-entry-body">
                    <form action="/users/create" class="" method="post" id="formRegister">
                        <div class="col-md-12">
                            <div class="row-fuld form-group">
                                <label class="control-label" style="color: #fff !important;">Tên</label>
                                <div class="clearfix"></div>
                                <div class="col-md-6 no-pading-left mb-no-pading">
                                    <div class="form-group">
                                        <input type="text" name="firstname" class="form-control">
                                    </div> 
                                </div>
                                <div class="col-md-6 no-pading-right mb-no-pading">
                                    <div class="form-group ">
                                        <input type="text" name="lastname" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row-fuld form-group">
                                <label class="">Chọn tên người dùng của bạn</label>
                                <div class="form-group ">
                                    <input type="text" name="username" class="form-control">
                                </div>

                            </div>

                            <div class="row-fuld form-group">
                                <label class="">Tạo mật khẩu</label>
                                <div class="form-group ">
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="row-fuld form-group">
                                <label class="">Re Mật khẩu</label>
                                <div class="form-group ">
                                    <input type="password" name="re_password" class="form-control">
                                </div>
                            </div>

                            <div class="row-fuld form-group">
                                <label class="">Sinh Nhật</label>
                                <div class="clearfix"></div>
                                <div class="col-md-4 no-pading-left mb-no-pading">
                                    <div class="form-group">
                                        <select name="meta[day]" class="form-control">
                                            <?php for ($i = 1; $i <= 31; $i++): ?>
                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-no-pading">
                                    <div class="form-group">
                                        <select name="meta[month]" class="form-control">
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 no-pading-right mb-no-pading">
                                    <div class="form-group">
                                        <select name="meta[year]" class="form-control">
                                            <?php for ($i = 1963; $i <= date("Y"); $i++): ?>
                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row-fuld form-group">
                                <label class="">Giới Tính</label>
                                <div>
                                    <select name="meta[gander]" class="form-control">
                                        <option value="1">Nam</option>
                                        <option value="0">Nữ</option>
                                        <option value="2">Khác</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row-fuld form-group">
                                <label class="">Điện thoại di động</label>
                                <div class="" style="position: relative">
                                    <div class="form-group">
                                        <div class="icon-addon addon-md">
                                            <input type="text" placeholder="84 +" class="form-control" id="phone" name="phone">
                                            <label for="email" class="flag" rel="tooltip" title="email"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row-fuild form-group">
                                <label class="control-lable">Mã bảo mật</label>
                                <div class="clearfix"></div>
                                <div class="col-md-6 no-pading-left mb-no-pading">
                                    <div class="form-group">
                                        <input type="text" name="captcha" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-md-6 no-pading-right mb-no-pading">
                                    <div class="form-group captcha">
                                        <?php
                                        $this->widget('CCaptcha');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" > Tôi đồng ý với dịch vụ và chính sách của <strong>DG MEDIA</strong>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <div class="btn-user">
                                <button class="btn btn-block" type="submit">Xác Nhận</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .captcha img{
        height: 34px;
        width: 120px;
        padding-right: 20px;
    }
</style>
<?php require_once 'include/footer.php'; ?>