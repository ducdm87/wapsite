<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/backend/"><?php echo CHtml::encode(Yii::app()->name); ?></a>
    </div>
    <?php
        global $user;
        $app = Request::getVar('app',"cpanel");
        $view = Request::getVar('view',null);
    ?>
    <?php $controll = Yii::app()->controller->id; ?>
    <?php $action = Yii::app()->controller->action->id; ?>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <?php
        if (getSysConfig("sidebar.display", 1) == 1) {
            ?>
            <ul class="nav navbar-nav side-nav">
                <li class="dropdown <?php if ($app == "" OR $app == "cpanel") echo "active"; ?>">
                    <a href="/backend/" class="dropdown-toggle parent" data-toggle="dropdown">
                        <i class="fa fa-dashboard"></i> System<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <?php echo showSideBarMenu("cpanel","", "Dashboard"); ?>
                        <?php echo showSideBarMenu("cpanel","sysconfig", "Config"); ?>
                    </ul>
                </li> 

                <?php echo showSideBarMenu("user","", "User", "fa-folder"); ?>

                <?php echo showSideBarMenu("menu","menutype", "Menu", "fa-file"); ?>
                 

                <li class="dropdown <?php if ($app == "category" OR $app == "article"  OR $app == "video") echo "active current"; ?>">
                    <a href="#" class="dropdown-toggle parent" data-toggle="dropdown">
                        <i class="fa fa-caret-square-o-down"></i> Applications 
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php echo showSideBarMenu("category","", "Category"); ?>
                        <?php echo showSideBarMenu("article","", "Article", "fa-file"); ?>
                        <?php echo showSideBarMenu("video","", "Video", "fa-film"); ?>
                    </ul>
                </li> 

                <?php echo showSideBarMenu("module","", "Module"); ?>
                <?php
                if ($user->isSuperAdmin()) {
                ?>
                    <li class="dropdown <?php if($app == "installer") echo "active"; ?>">            
                        <a href="#" class="dropdown-toggle parent" data-toggle="dropdown">
                            <i class="fa fa-caret-square-o-down"></i> Installer 
                            <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <?php echo showSideBarMenu("installer","-manager", "Install"); ?>
                                <?php echo showSideBarMenu("installer","manager", "Manager"); ?>
                            </ul> 
                    </li> 
                <?php 
                
                } ?>

            </ul>
        <?php } ?>

        <ul class="nav navbar-nav navbar-right navbar-user">
            <li>
                <a href="/" class="dropdown-toggle" target="_blank"> Time server: <?php echo date("H:i:s d/m/Y"); ?> </a>
            </li>
            <li>
                <a href="/" class="dropdown-toggle" target="_blank"> Visit site</a>
            </li>
            <li class="dropdown messages-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> Messages <span class="badge">7</span> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li class="dropdown-header">7 New Messages</li>
                    <li class="message-preview">
                        <a href="#">
                            <span class="avatar"><img src="/images/avatar/50x50"></span>
                            <span class="name">John Smith:</span>
                            <span class="message">Hey there, I wanted to ask you something...</span>
                            <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                        </a>
                    </li>                               
                    <li class="divider"></li>
                    <li><a href="#">View Inbox <span class="badge">7</span></a></li>
                </ul>                
            </li>
            <?php global $mainframe; ?>
            <li class="dropdown user-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $mainframe->getUserUsername(); ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo Router::buildLink("user", array("view"=>'user','layout'=>'progile')); ?>"><i class="fa fa-user"></i> Profile</a></li>                
                    <li class="divider"></li>                    
                    <li><a href="<?php echo Router::buildLink("user", array("view"=>'user','layout'=>'logout')); ?>"> <i class="fa fa-power-off"></i> Logout</a></li>                
                </ul>
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>

<?php 
function showSideBarMenu($_app, $_view, $title, $_class="fa-folder")
{
    global $user;
    $arr_ignore = array("menu", 'module','installer');
    if(!$user->isSuperAdmin() AND in_array($_app, $arr_ignore)){
        return false;
    }
    if(!$user->isSuperAdmin() AND $_app == 'cpanel' AND $_view == "sysconfig"){
        return false;
    }
    
    $app = Request::getVar('app',"cpanel");
    $view = Request::getVar('view',"");
    
    $class = "";
    $_class = "fa " . $_class;    
    $link = Router::buildLink($_app, array("view"=>$_view));
     
//    if($_view == "") $_view = "display";
    
    if(strpos($_view, "-") === 0){
        $_view = trim($_view,"-");
        if($app == $_app AND $view != $_view){
            $class = "active current";
            $_class .= " fa-spin";
        }        
    }else{
        if($app == $_app AND ($view == $_view OR ($view == "" AND $_view == 'display')) ){
            $class = "active current";
            $_class .= " fa-spin";
        }        
    }
    
    $html = '<li class="'.$class.'">
                <a href="'.$link.'"> <i class="'.$_class.'"></i> '.$title.'</a>
            </li> ';
    return $html;
}
?>