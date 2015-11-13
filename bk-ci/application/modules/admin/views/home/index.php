<?php echo $this->message->display(); ?>
<font style="color:#037C01;font-size: 16px;text-align: center; font-family: cursive;">
Trang quản trị nội dung website: <a target="_blank" href="<?php echo base_url();?>"><?php echo base_url();?></a><br>
Bạn đang đăng nhập với tài khoản: <font style="color:red;"><?php echo $_SESSION['user']['username'];?></font>
</font>