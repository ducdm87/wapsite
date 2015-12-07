 

 
    
<ul class="line">
    <?php 
    if(count($list_user)){
        $i = 0;
        global $user;
        foreach($list_user as $_user){
            $link_edit = Router::buildLink("user", array('view'=>'user','layout'=>'edit','cid'=>$_user['id']));
            $class = ($i==0)?"first":($i==count($list_user) - 1?"last":"");
            ?>
                <li class="file">
                    <i class='icon'></i>
                    <a href="<?php echo $link_edit; ?>" class="<?php if($_user['leader'] == 1) echo 'leader'; ?> <?php if($user->id==$_user['id']) echo 'active'; ?>">
                        <?php echo $_user['username']; ?><?php if($user->id==$_user['id']) echo ' (*)'; ?>
                    </a>
                </li>
            <?php
            $i ++;
        }
    }
    ?>
    <?php 
    if(count($arr_group)){
        $j = 0;
        foreach($arr_group as $_group){
            $link_more_group = Router::buildLink("user", array('view'=>'user', 'layout'=>'tree','groupID'=>$_group['id']));
            $link_edit_group = Router::buildLink("user", array('view'=>'group','layout'=>'edit','cid'=>$_group['id']));
            $class = ($j==0)?"first":($j==count($arr_group) - 1?"last":"");
            ?>
                <li class="folder parent <?php echo $class; ?>">
                    <i class="folder-btn btn-close" rel="<?php echo $link_more_group; ?>"></i>
                    <i class='icon'></i><a href="<?php echo $link_edit_group; ?>"><?php echo $_group['name']; ?></a>
                </li>
            <?php
            $j++;
        }
    }
    ?>
</ul>
        
<?php
die;
?>