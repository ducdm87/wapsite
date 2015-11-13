
<script type="text/javascript">
    $(window).ready(function($) {
        link_homepage = window.location.protocol + "//" + window.location.host;
        title_homepage = "<?php echo "Home page Display"; ?>";
        $("#sbox-overlay").show();
        $("#sbox-window").show();
        $("#overview").show();
        $("#yip-out").show();
    });
</script>

<div id="yip-out">
    <div class="popup-yip-out" id="popup-yip-out">
        <div class="wrapper" >
            <div class="popUpDiv" style=" ">
                <a href="" title="Close" id="close-popup-reactive"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/popup-close.png" /></a><br /> 
                <div class="popup-header" >
                    <h2>Active account</h2>
                </div>
                <div id="status-bar-reactive">
                    <div id="system-message"><div class="notice"><?php echo $str_error; ?></div></div>
                </div>
                <form name="reactive" action="<?php echo $this->createUrl("/user/reactive"); ?>" method="POST" id="form-reactive">
                    <div class="element">
                        <input id="reactive-email" name="email" value="" placeholder="Email" />
                    </div>                    
                    <div class="reg-forgot" >
                        <button type="submit" name="login" id="btn-form-reactive">Actice</button>
                        <p><a href="#"> Forgot Password</a></p>
                    </div>
                    <div class="lg-social" >
                        <p>Or logn with your social acount</p>
                        <ul>
                            <li><a href="" title=""> <img src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/fb.png" alt="" /> </a></li>
                            <li><a href="" title=""> <img src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/tw.png" alt=""/> </a></li>
                            <li><a href="" title=""> <img src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/google.png" alt=""/> </a></li>
                            <li><a href="" title=""> <img src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/yh.png" alt=""/> </a></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
die;
