<div class="page-users-form">
<div id="wrapper">
    <div class="section">
        <div class="container">
            <div class="form-entry-body">
                <div class="row profile">
                    <div class="">
                        <div class="profile-sidebar">
                            <!-- SIDEBAR USERPIC -->
                            <div class="profile-userpic">
                                <img src="/images/app/avatar.png" class="img-responsive" alt="">
                            </div>
                            <!-- END SIDEBAR USERPIC -->
                            <!-- SIDEBAR USER TITLE -->
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name">
                                    <?php echo isset($user['first_name']) ? $user['first_name'] : ''; ?><?php echo isset($user['last_name']) ? $user['last_name'] : '' ?>
                                </div> 
                            </div>
                            <!-- SIDEBAR MENU -->
                            <div class="profile-usermenu">
                                <ul class="nav">
                                    <li class="active">
                                        <a href="#">
                                            <i class="glyphicon glyphicon-home"></i>
                                            Thông tin </a>
                                    </li>

                                    <li>
                                        <a href="<?php echo Router::buildLink('user', array('layout'=>'changepass')); ?>">
                                            <i class="glyphicon glyphicon-ok"></i>
                                            Đổi mật khẩu  </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Router::buildLink('user', array('layout'=>'logout')); ?>">
                                            <i class="glyphicon glyphicon-off"></i>
                                            Đăng xuất </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- END MENU -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
