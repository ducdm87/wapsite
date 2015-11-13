
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
                <a href="" title="Close" id="close-popup-active"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/templates/resume/css/img/popup-close.png" /></a><br /> 
                <div class="popup-header" >
                    <h2>Active account successfully</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
die;
