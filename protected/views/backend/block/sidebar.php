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
    <?php $controll = Yii::app()->controller->id; ?>
    <?php $action = Yii::app()->controller->action->id; ?>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <?php
        if (getSysConfig("sidebar.display", 1) == 1) {
            ?>
            <ul class="nav navbar-nav side-nav">
                <li class="<?php if ($controll == "" OR $controll == "cpanel") echo "active"; ?>">
                    <a href="/backend/"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>

                <li class="dropdown <?php if ($controll == "system") echo "active"; ?>"">
                    <a href="#" class="dropdown-toggle parent" data-toggle="dropdown">
                        <i class="fa fa-caret-square-o-down"></i> System <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <?php echo showSideBarMenu("system","config", "Config"); ?>
                        <li><a href="#">Info</a></li>                
                    </ul>
                </li>

                <li class="dropdown <?php if ($controll == "users" OR $controll == "usergroups") echo "active"; ?>">
                    <a href="#" class="dropdown-toggle parent" data-toggle="dropdown">
                        <i class="fa fa-caret-square-o-down"></i> Users <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu"> 
                        <?php echo showSideBarMenu("usergroups","", "Groups", "fa-folder"); ?>
                        <?php echo showSideBarMenu("users","", "Users", "fa-file"); ?>
                    </ul>
                </li>

                <?php echo showSideBarMenu("menus","menutypes", "Menus", "fa-file"); ?>
                 

                <li class="dropdown <?php if ($controll == "categories" OR $controll == "articles"  OR $controll == "videos") echo "active current"; ?>">
                    <a href="#" class="dropdown-toggle parent" data-toggle="dropdown">
                        <i class="fa fa-caret-square-o-down"></i> Applications 
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php echo showSideBarMenu("categories","", "Categories"); ?>
                        <?php echo showSideBarMenu("articles","", "Articles", "fa-file"); ?>
                        <?php echo showSideBarMenu("videos","", "Videos", "fa-film"); ?>
                    </ul>
                </li> 

                <?php echo showSideBarMenu("modules","", "Modules"); ?>
                <li class="dropdown <?php if($controll == "installer") echo "active"; ?>">            
                    <a href="#" class="dropdown-toggle parent" data-toggle="dropdown">
                        <i class="fa fa-caret-square-o-down"></i> Installer 
                        <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php echo showSideBarMenu("installer","-manager", "Install"); ?>
                            <?php echo showSideBarMenu("installer","manager", "Manager"); ?>
                        </ul> 
                </li>
                

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
                    <li><a href="<?php echo Yii::app()->createUrl("users/profile"); ?>"><i class="fa fa-user"></i> Profile</a></li>                
                    <li class="divider"></li>
                    <li><a href="<?php echo Yii::app()->createUrl("users/logout"); ?>"> <i class="fa fa-power-off"></i> Logout</a></li>                
                </ul>
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>

<?php 
function showSideBarMenu($_controller, $_action, $title, $_class="fa-folder")
{
    $controll = Yii::app()->controller->id;
    $action = Yii::app()->controller->action->id;    
    $class = "";
    $_class = "fa " . $_class;
    $link = Yii::app()->createUrl("$_controller/$_action");
    if($_action == "") $_action = "display";
    
    if(strpos($_action, "-") === 0){
        $_action = trim($_action,"-");
        if($controll == $_controller AND $action != $_action){
            $class = "active current";
            $_class .= " fa-spin";
        }
        $link = Yii::app()->createUrl("$_controller/");  
    }else{
        if($controll == $_controller AND $action == $_action){
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