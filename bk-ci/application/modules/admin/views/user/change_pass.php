<h1>Thay đổi mật khẩu</h1>

<div id="user_list">
    <?php if ($this->message->error): ?>
        <div id="div_message" class="error"><?php echo $this->message->display_blank(); ?></div>
    <?php endif; ?>
    <form enctype="multipart/form-data" method="post" action="" id="user_form">
        <div class="editcate_ct">
            <div class="boxadd">
                <ul class="linect">
                    <li>
                        <span class="left"><b>Tên đăng nhập :</b></span>
                        <span class="right"><?php echo $_SESSION['_admin']['username']; ?></span>
                    </li>
                    <li>
                        <span class="left"><b>Mật khẩu cũ: </b></span>
                        <span class="right"><input name="old_password" type="password" style="width:100%;"></span>
                    </li>
                    <li>
                        <span class="left"><b>Mật khẩu mới: </b></span>
                        <span class="right"><input name="new_password" type="password" style="width:100%;"></span>
                    </li>
                    <li>
                        <span class="left"><b>Mật khẩu xác nhận: </b></span>
                        <span class="right"><input name="c_password" type="password" style="width:100%;"></span>
                    </li>

                </ul>
            </div>
            <div class="btarticle">
                <input type="button" value="Cancel" class="btn" onclick="history.back();" />
                <input type="submit" value="Save & Continute" class="btn" />

            </div>
        </div>
    </form>
</div>