<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<?php $this->createUrl('user/login'); ?>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/admin/templates/standard/assets/css/bootstrap.css" rel="stylesheet">
<div class="container">
    <div class="row">
        <?php YiiMessage::showMessage(); ?>
        <div class="col-sm-6 col-md-6 col-md-offset-3">
            <form method="post" action="" class="form-signin">
                <input type="hidden" value="/" name="page" class="ui_hidden">
                <h1 class="text-center login-title">Sign in to continue to admin</h1>
                <div class="account-wall">
                    <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120" alt="">
                    <div class="form-group">
                        <input size="20" value="" name="LoginForm[username]" class="form-control ui_textbox" placeholder="Tên đăng nhập">
                    </div>
                    <div class="form-group">
                        <input type="password" size="20" value="" name="LoginForm[password]" class="form-control ui_password" placeholder="Mật khẩu">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">
                            Sign in</button>
                        <label class="checkbox pull-left">
                            <input type="checkbox" value="1" name="LoginForm[rememberMe]">
                            Remember me
                        </label>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>          
<style>
    .form-signin
    {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .form-signin-heading, .form-signin .checkbox
    {
        margin-bottom: 10px;
    }
    .form-signin .checkbox
    {
        font-weight: normal;
    }
    .form-signin .form-control
    {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .form-signin .form-control:focus
    {
        z-index: 2;
    }
    .form-signin input[type="text"]
    {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .form-signin input[type="password"]
    {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .account-wall
    {
        margin-top: 20px;
        padding: 15px;
        background-color: #f7f7f7;
        -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    }
    .login-title
    {
        color: #555;
        font-size: 18px;
        font-weight: 400;
        display: block;
    }
    .profile-img
    {
        width: 96px;
        height: 96px;
        margin: 0 auto 10px;
        display: block;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
    }
    .need-help
    {
        margin-top: 10px;
    }
    .new-account
    {
        display: block;
        margin-top: 10px;
    } 
</style>
<?php
die;
