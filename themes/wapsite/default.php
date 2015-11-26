<?php global $mainframe, $user; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo getSysConfig("seopage.title"); ?></title>
        <?php  global $cur_temp; ?>
        <meta name="description" content="<?php echo getSysConfig("seopage.description"); ?>" />
        <meta name="keywords" content="<?php echo getSysConfig("seopage.keyword"); ?>" />
        
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/<?php echo $cur_temp; ?>/assets/css/bootstrap.min.css" /> 
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/<?php echo $cur_temp; ?>/assets/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/<?php echo $cur_temp; ?>/assets/css/color.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/<?php echo $cur_temp; ?>/assets/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/<?php echo $cur_temp; ?>/assets/css/mobile.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/<?php echo $cur_temp; ?>/assets/growl/jquery.growl.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/<?php echo $cur_temp; ?>/assets/gvalidator/css/bootstrapValidator.css" />

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/<?php echo $cur_temp; ?>/assets/js/jquery-1.11.1.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/<?php echo $cur_temp; ?>/assets/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/<?php echo $cur_temp; ?>/assets/js/jquery.growl.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/<?php echo $cur_temp; ?>/assets/js/local-script.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/<?php echo $cur_temp; ?>/assets/validator/js/bootstrapValidator.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/<?php echo $cur_temp; ?>/assets/js/form-validator.js"></script>
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          
        <![endif]-->
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    </head>
    <body>
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.4";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <header>
            <div class="header-top">
                <div class="container-fluid">
                    <ul class="pull-right list-inline">
                        <?php 
                        if ($mainframe->isLogin()): ?>
                            <li class="dropdown">
                                <a href="<?php echo $this->createUrl('/users/profile') ?>"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="span-header-top">Xin chào : <?php echo $user->username ?></span> </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo Router::buildLink('users', array('layout'=>'profile')); ?>">Tài khoản của tôi</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo Router::buildLink('users', array('layout'=>'logout')); ?>">Thoát</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li><a href="<?php echo Router::buildLink('users', array('layout'=>'register')); ?>">Đăng Kí</a> <span class="span-header-top"> | </span></li>
                            <li><a href="<?php echo Router::buildLink('users', array('layout'=>'login')); ?>">Đăng Nhập</a> <span class="span-header-top"> </span></li>                            
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="header">
                <div class="header-selction">
                    <div class="container-fluid mobile-container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-mobile" aria-expanded="false">
                                <span class="lg-social"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="/">
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/logo.png" class="hidden-xs hiden-sm"/>
                                <div class="text-center ">
                                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/app/mobile-logo.png" class="hidden-lg hiden-md"/>
                                </div>
                            </a>
                        </div>
                        <div class="search-container">
                            <form method="get" action="<?php echo Router::buildLink('users', array('view'=>'search','layout'=>'search')); ?>">
                                <div class="search">
                                    <input type="text" name="q" class="form-control input-sm" maxlength="64" value="<?php echo isset($_GET['q']) ? $_GET['q'] : '' ?>" placeholder="Tìm kiếm..." />
                                    <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
             <?php $controll = Yii::app()->controller->id; ?>
             <?php $action = Yii::app()->controller->action->id; ?>
             <?php $param_alias =  Request::getVar('alias',null); ?>
            
            <div class="hidden-lg hidden-md">
                 <div class="collapse navbar-collapse " id="navbar-collapse-mobile">
                    <div id="nav"><?php echo YiiModule::loadModules($position = "menu-nav", "benhvien"); ?></div>
                </div>
            </div>
            <div class="nav-main hidden-sm hidden-xs">
                <div class="container-nav">
                    <nav class="navbar navbar-static-top">
                        <div id="nav"><?php echo YiiModule::loadModules($position = "menu-nav", "benhvien"); ?></div>
                    </nav>
                </div>
            </div>  
            <div class="nav-main hidden-lg hidden-md">
                <div class="container-nav">
                    <nav class="navbar navbar-static-top show-mobile">
                        <ul class="show-nav-main-mobile">
                            <li><a href="/">TRANG CHỦ</a></li>
                        </ul>
                    </nav>
                </div>
            </div>  
            <!--</div>-->
        </header>
        <div id="wrapper">
            <div class="section">                 
                <?php
                global $mainframe; 
                $app = Request::getVar('app');
                if($app != "users"){
                ?>
                    <div class="banner hidden-xs hidden-sm"> 
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/app/banner.png" alt="Banner" class="img-responsive"/>
                    </div>
                <?php 
                }
                if(!$mainframe->isLogin()){?>
                    <div class="dialog-message">
                        <div class="alert alert-warning alert-dismissible text-center" role="alert">
                            <p>Qúy khách vui lòng đăng nhập <strong><a href="<?php echo Router::buildLink('users', array('view'=>'user','layout'=>'login')); ?>">Tại đây</a></strong> hoặc vui lòng chuyển sang truy cập GPRS/3G/DEGE
                            </p>
                        </div>
                    </div>
                <?php } ?>
                <?php YiiMessage::showMessage(); ?>
                <div class="page-content">
                    <?php echo $content; ?>                
                </div>
            </div>
        </div>
        <footer>
            <div class="container">
                <div class="footer-bellow text-center">
                    <span>Công ty cổ phần Bạch Minh (Vega Corporation)</span>
                    <br/>
                    <span>Phòng 804 tầng 8 Tòa nhà V.E.T số 98 Hoàng Quốc Việt, Nghĩa Đô, Cầu Giấy, Hà Nội</span>
                    <br/>
                    <span>DKKD số 0101380911 do SKHDT Hà Nội cấp 20/6/2003</span>
                    <br/>
                    <span>Email: info@vega.com.vn Tel: 04.37554190.</span>
                    <br/>
                    <span>Người chịu trách nhiệm nội dung: Bà Nguyễn Thu Dung</span>
                </div>
            </div>
        </footer>        
    </body>
</html>