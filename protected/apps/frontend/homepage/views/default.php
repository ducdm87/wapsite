<?php $user_session = Yii::app()->session->get('user_data'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo getSysConfig("seopage.title"); ?></title>
        <meta name="description" content="<?php echo getSysConfig("seopage.description"); ?>" />
        <meta name="keywords" content="<?php echo getSysConfig("seopage.keyword"); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/templates/dist/css/bootstrap.min.css" /> 
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/templates/dist/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/templates/dist/css/color.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/templates/dist/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/templates/dist/css/mobile.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/templates/dist/growl/jquery.growl.css" />

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
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
                        <?php if (isset($user_session) && $user_session): ?>
                            <li class="dropdown">
                                <a href="<?php echo $this->createUrl('/user/profile') ?>"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="span-header-top">Xin chào : <?php echo $user_session['username'] ?></span> </a>
                                <ul class="dropdown-menu">
                                    <li><a href="/users/profile">Tài khoản của tôi</a></li>
                                    <li class="divider"></li>
                                    <li><a href="/users/logout">Thoát</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li><a href="<?php echo $this->createUrl('/user') ?>">Đăng Kí</a> <span class="span-header-top"> | </span></li>
                            <li><a href="<?php echo $this->createUrl('/user/login') ?>">Đăng Nhập</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="header">
                <div class="header-selction">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-mobile" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="<?php echo $this->createUrl('/app') ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/logo.png" class="hidden-xs hiden-sm"/>
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/app/mobile-logo.png" class="hidden-lg hiden-md"/>
                            </a>
                        </div>
                        <div class="search-container">
                            <form method="get" action="/search">
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
                    <ul class="nav navbar-nav">
                            <li><a href="<?php echo $this->createUrl('article/') ?>" class="<?php if($controll == "articles") echo 'active'; ?>">Tin Tức</a></li>
                            <li><a href="<?php echo $this->createUrl('video/category',array('alias'=> "the-thao") ); ?>" class="<?php if($controll == "videos" AND $param_alias == "the-thao") echo 'active'; ?>">Thể Thao</a></li>
                            <li><a href="<?php echo $this->createUrl('video/category',array('alias'=> "hai-huoc") ); ?>" class="<?php if($controll == "videos" AND $param_alias == "hai-huoc") echo 'active'; ?>">Hài hước</a></li>
                            <li><a href="<?php echo $this->createUrl('video/category',array('alias'=> "vui-nhon") ); ?>"  class="<?php if($controll == "videos" AND $param_alias == "vui-nhon") echo 'active'; ?>">Vui nhộn</a></li>
                    </ul>
                </div>
            </div>
            <!--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1s">-->
            <div class="nav-main">
                <div class="container-nav">
                    <nav class="navbar navbar-static-top">
                        <div id="nav"><?php echo YiiModule::loadModules($position = "menu-nav", "benhvien"); ?></div>
                        <ul class="nav navbar-nav hide">
                            <li><a href="<?php echo $this->createUrl('app/') ?>" class="<?php if($controll == "app") echo 'active'; ?>">Home</a></li>
                            <li><a href="<?php echo $this->createUrl('article/') ?>" class="<?php if($controll == "articles") echo 'active'; ?>">Tin Tức</a></li>
                            <li><a href="<?php echo $this->createUrl('video/category',array('alias'=> "the-thao") ); ?>" class="<?php if($controll == "videos" AND $param_alias == "the-thao") echo 'active'; ?>">Thể Thao</a></li>
                            <li><a href="<?php echo $this->createUrl('video/category',array('alias'=> "hai-huoc") ); ?>" class="<?php if($controll == "videos" AND $param_alias == "hai-huoc") echo 'active'; ?>">Hài hước</a></li>
                            <li><a href="<?php echo $this->createUrl('video/category',array('alias'=> "vui-nhon") ); ?>"  class="<?php if($controll == "videos" AND $param_alias == "vui-nhon") echo 'active'; ?>">Vui nhộn</a></li>
                        </ul>
                    </nav>
                </div>
            </div>  
            <!--</div>-->
        </header>
        <div id="wrapper">
            <div class="section">                 
                <div class="container-fluid" style="padding: 0px;">
                    <div class="banner">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/app/banner.png" alt="Banner" class="img-responsive"/>
                    </div>
                    <div class="dialog-message">
                        <div class="alert alert-warning alert-dismissible text-center" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <p>Qúy khách vui lòng đăng nhập <strong>Tại đây</strong> hoặc vui lòng chuyển sang truy cập GPRS/3G/DEGE</p>
                        </div>
                    </div>
                </div>
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
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/templates/dist/js/jquery-1.11.1.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/templates/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/templates/dist/js/jquery.growl.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/templates/dist/js/local-script.js"></script>
    </body>
</html>