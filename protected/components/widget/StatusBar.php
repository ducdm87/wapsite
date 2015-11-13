<?php
Yii::import('zii.widgets.CPortlet');

class StatusBar extends CPortlet {

    public $_title = 'Tags';

    protected function renderContent() {
        global $mainframe, $link_change_pass;
        
        $model = User::getInstance();
        $total_resume = "";
        $user = $mainframe->getUser();
        $user_name = "";
        $display_user = "block";
        $display_userloged = "none";    
    
        if ($mainframe->isLogin()){
            $user_name = (isset($user["first_name"]) and $user["first_name"] !=  "")?ucwords($user["first_name"]) . " " . ucwords($user['last_name']):$user["email"];
            $display_user = "none";
            $display_userloged = "block";
            $total_resume = $model->getAccountInfo();
        }
        $user_name = preg_replace('/\@.*?$/is', "", $user_name);
        
        ?>
        <!-- HEADER -->
        <div class="header">
            <div class="wrapper" >
                <div class="logo"><a href="/" title=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/logo.png" alt=""></a></div>

                <div class="nav_menu">
                    <ul class="menu-main" class="menu">
                        <li class="" class=""><a href="/" title="">home</a></li>
                        <li class="" class=""><a rel="nofollow" href="<?php echo Yii::app()->controller->createUrl("/resume/addnew"); ?>" title="">create new resume</a></li> 
                        <li>
                            <div class="user" style="display: <?php echo $display_user; ?>">
                                <p> <a rel="nofollow" href="" title="Login" id="user-login">Login</a> / 
                                    <a href="<?php echo MASTER_DOMAIN; ?>/account/register" title="Register" id="user-register1">Register</a></p>
                            </div>
                            <div class="user-loged" style="display: <?php echo $display_userloged; ?>">
                                <a href="#"><p> Hi,<span class="user-name" ><?php echo $user_name; ?></span> <img src="/templates/resume/css/img/dropdown-user.png"></p></a>
                                <div class="sub-bg">
                                    <span class="new_homedasdasd2" >

                                    </span>
                                    <ul class="sub-menu" style="display: block;">
                                        <li><a rel="nofollow" id="my-resume" href="<?php echo Yii::app()->controller->createUrl("/my-resumes/"); ?>">My Resume <span id="total-resume">(<?php echo $total_resume; ?>)</span></a></li>
                                        <li><a rel="nofollow" id="change-the-password" href="<?php echo $link_change_pass; ?>">Change Password</a></li>
    <!--                                    <li><a rel="nofollow" id="change-the-password" href="<?php echo Yii::app()->controller->createUrl("/user/changepass"); ?>">Change Password</a></li>-->
                                        <li><a rel="nofollow" id="btn-logout-page" href="<?php echo Yii::app()->controller->createUrl("/user/logout"); ?>">Logout</a></li>
                                    </ul>
                                </div>           
                            </div>
                        </li>
                     </ul>
                </div>
            </div>
        </div>            

        <!-- pop LOGIn --> 

        <div class="popup-login" id="popup-login">
            <div class="wrapper" >
                <div class="popUpDiv" style=" ">
                    <a href="" title="Close" class="btn-close-popup" relto="popup-login" rel="nofollow"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/popup-close.png" /></a><br /> 
                    <div class="popup-header" >
                        <h2>Log in</h2>
                    </div>
                    <div id="status-bar-login"><?php YiiMessage::showMessage(); ?></div>
                    <form name="login" action="" method="POST" id="form-login">
                        <div class="element">
                            <input id="LoginForm-username" name="LoginForm[username]" value="" placeholder="Email" class="el-form-login" />
                        </div>
                        <div class="element">
                            <input type="password" id="LoginForm-password" name="LoginForm[password]" value="" placeholder="Pasword" class="el-form-login" />
                        </div>
                        <div class="reg-forgot" >
                            <button type="button" name="login" id="btn-form-login">Login</button>
                            <p> 
                                <a class="btn-change-popup1" href="<?php echo MASTER_DOMAIN; ?>/account/register" rel="popup-login||popup-register||Register||/user/register">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Register </a>
                                &nbsp;| &nbsp;<a href="<?php echo (MASTER_DOMAIN."/account/forgot"); ?>"  class="btn-change-popup1" rel="popup-login||popup-forgot-password||Forgot Password||/user/forgot-password"> Forgot Password</a>
                            </p>
                        </div>
                        <div class="lg-social" >
                            <p>Or login with your social acount</p>
                            <ul>
                                <li><a rel="nofollow" href="<?php echo (MASTER_DOMAIN."/account/facebook"); ?>" title="" target="blank" class="openid"> <img src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/fb.png" alt="" /> </a></li>
                                <li><a rel="nofollow" href="<?php echo (MASTER_DOMAIN."/account/twitter"); ?>" title="" target="blank" class="openid"> <img src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/tw.png" alt=""/> </a></li>
                                <li><a rel="nofollow" href="<?php echo (MASTER_DOMAIN."/account/google"); ?>" title="" target="blank" class="openid"> <img src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/google.png" alt=""/> </a></li>
                                <li><a rel="nofollow" href="<?php echo (MASTER_DOMAIN."/account/yahoo"); ?>" title="" target="blank" class="openid"> <img src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/yh.png" alt=""/> </a></li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        
        <!-- pop forgot password --> 

        <div class="popup-forgot-password" id="popup-forgot-password">
            <div class="wrapper" >
                <div class="popUpDiv" style=" ">
                    <a href="" title="Close" class="btn-close-popup" relto="popup-forgot-password" rel="nofollow"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/popup-close.png" /></a><br /> 
                    <div class="popup-header" >
                        <h2>Forgot Password</h2>
                    </div>
                    <div id="status-bar-forgotpassword"><?php YiiMessage::showMessage(); ?></div>
                    <form name="login" action="" method="POST" id="form-forgot-password">
                        <div class="element">
                            <input id="forgotpassword-username" name="forgotpassword[username]" value="" placeholder="Email" />
                        </div>                         
                        <div class="reg-forgot" >
                            <button type="submit" name="login" id="btn-form-forgotpassword">Submit</button>                           
                            <p> Or <a href="" title="" class="btn-change-popup" rel="popup-forgot-password||popup-register||Register||/user/register"> &nbsp Register »</a> &nbsp;</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        

        <!-- REGISTER --> 

        <div class="popup-register" id="popup-register" >
            <div class="wrapper" >
                <div class="popUpDiv">
                    <a href="#" title="" class="btn-close-popup" relto="popup-register" rel="nofollow"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/popup-close.png" /></a><br /> 
                    <div class="popup-header" >
                        <h2>Register</h2>
                    </div>
                    <div id="status-bar-register"></div>
                    <form name="register" action="" method="POST" id="form-register" >
                        <div class="element">
                            <input id="registerForm-email" name="registerForm[email]" value="" placeholder="Email" />
                            <span class="red-error" >*</span>
                        </div>
                        <div class="element">
                            <input type="password" id="registerForm-password" name="registerForm[password]" value="" placeholder="Password" />
                            <span class="red-error" >*</span>
                        </div>
                        <div class="element">
                            <input type="password" id="registerForm-re-password" name="registerForm[re-password]" value="" placeholder="Re-Password" />
                            <span class="red-error" >*</span>
                        </div>

                        <div class="element">
                            <select id="registerForm-country"  name="category" class="err">
                                <option value="0">Select country</option>
                                <option value="us">United State</option>
                                <option value="uk">United Kingdom</option>
                                <option value="ca">Canada</option>
                                <option value="in">India</option>
                                <option value="au">Australia</option>
                                <option value="vi">Việt Nam</option>
                            </select>
                        </div>

                        <div class="reg-forgot" >
                            <button type="submit" name="login" id="btn-form-register">Register</button>
                            <p> Have an acount ? <a href="" title="" class="btn-change-popup" rel="popup-register||popup-login||Login||/user/login">Log in » </a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <?php global $mainframe; 
        $user = $mainframe->getUser();
        ?>
        
        <div class="popup-changepass" id="popup-changepass" >
            <div class="wrapper" >
                <div class="popUpDiv">
                    <a href="#" title="" id="close-popup-changepass" rel="nofollow"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/popup-close.png" /></a><br /> 
                    <div class="popup-header" >
                        <h2>Change password</h2>
                    </div>
                    <div id="status-bar-chagnepass"></div>
                    <form name="changepass" action="" method="POST" id="form-changepass" >
                        <div class="element">
                            <input type="password" id="ChangepassForm-password" name="ChangepassForm[password]" value="" placeholder="Old Password" />
                        </div>
                        <div class="element">
                            <input type="password" id="ChangepassForm-new-password" name="ChangepassForm[new-password]" value="" placeholder="New Password" />
                        </div>
                        <div class="element">
                            <input type="password" id="ChangepassForm-re-password" name="ChangepassForm[re-password]" value="" placeholder="Verifi Password" />
                        </div>
                        <div class="reg-forgot" >
                            <button type="submit" name="login" id="btn-form-chagnepass" suppliers="<?php echo isset($user['suppliers'])?$user['suppliers']:"" ?>" >Chagne</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reset pass --> 
        <div class="popup-resetpass" id="popup-resetpass" >
            <div class="wrapper" >
                <div class="popUpDiv">
                    <a href="#" title="" class="btn-close-popup" rel="popup-resetpass"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/popup-close.png" /></a><br /> 
                    <div class="popup-header" >
                        <h2>Reset password</h2>
                    </div>
                    <div id="status-bar-resetpass"></div>
                    <form name="changepass" action="" method="POST" id="form-resetpass" >                        
                        <div class="element">
                            <input type="password" id="resetpass-new-password" name="resetpass[new-password]" value="" placeholder="New Password" />
                        </div>
                        <div class="element">
                            <input type="password" id="resetpass-re-password" name="resetpass[re-password]" value="" placeholder="Verifi Password" />
                        </div>
                        <div class="reg-forgot" >
                            <button type="submit" name="login" id="btn-form-resetpass"  >Chagne</button>
                            <p> 
                                <a href="" title="" class="btn-change-popup" rel="popup-resetpass||popup-forgot-password||Forgot Password||user/forgot-password"> &nbsp;&nbsp;&nbsp; Forgot password</a>
                                &nbsp;|&nbsp; <a href="" class="btn-change-popup" rel="popup-resetpass||popup-login||Login||/user/login" title=""> Login</a> 
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        
        <?php
    }

}
