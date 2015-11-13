<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="description" content="<?php echo $this->metaDesc; ?>" />
        <meta name="keywords" content="<?php echo $this->metaKey; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/templates/giaxang/css/style.css" /> 
        
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/templates/giaxang/js/jscript.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/templates/giaxang/js/jscookies.js"></script>

    </head>
    <body>
        <div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=134419533373955";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
        <?php $pageClassSuffix = getSysConfig("page.classSuffix","");  ?>
        <div class="wrapper <?php echo $pageClassSuffix; ?>" >
            <!-- Begin header -->
            <div class="header">
                <div class="header-inner">
                    <div class="left" onclick="location.href = 'http://vietbao.vn/vn/ty-gia-ngoai-te/';" style="cursor: pointer;">
                        <a class="left logo"><img src="http://vietbao.vn/images/rate2013/logo.png" alt="" width="221" height="41"  border="0" /></a>
                    </div>
                    <div class="right"> 
                         <div class='ads ads1' style='margin: 0 auto; text-align: center; width: 728px;'> <div id='div-gpt-ad-1400670395635-0' style='width:728px; height:90px;'>
                            <script type='text/javascript'>
                                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1400670395635-0'); });
                            </script>
                        </div></div>                    </div>
                </div>
            </div>
            
            <div class="nav-container">
                
            </div>
            
            <div class="top-main">
                <div class="top-inner clearfix">
                    <ul class="topmenu left">
                        <li><a href='http://vietbao.vn/vn/dat-vietbao-lam-trang-chu/'>Đặt làm trang chủ</a></li>
                        <li><a href="http://vietbao.vn/vn/contact/" class="contact">Liên hệ</a></li>
                        <li><a href="http://vietbao.vn/vn/rss/" class="rss">Việt Báo RSS</a></li>
                    </ul>
                    <!-- share -->
                </div>
            </div>
            <!-- begin main page -->
            <div id="page-content">
                <div class="col-main">
                    <div class="main-inner">
                         <?php echo $content; ?>
                    </div>
                </div> 
            </div>
            <!-- end main page -->
           
        </div>
    </body>
    <div id="overview" style="display: none;">
        <div class="" style="z-index: 900; position: fixed; top: 0px; left: 0px; visibility: visible; opacity: 0.7; width: 100%; height: 100%;" id="sbox-overlay"></div>
    </div>
    <div id="master_popup_login" style="display:none"> </div>
</html>