

<div class="panel">
    <div class="panel-heading">
       
    </div>
    <div class="panel-body"> 
        <div class=" ">
            <div class="icon">
                <a href="<?php echo Router::buildLink("user", array("view"=>'group')) ?>">
                    <img alt="Role" src="/images/icons/groups.png">
                    <span>Groups</span>
                </a>
            </div>
            
            <div class="icon">
                <a href="<?php echo Router::buildLink("user", array("view"=>'user')) ?>">
                    <img alt="Role" src="/images/icons/users.png">
                    <span>Users</span>
                </a>
            </div>
            
            <div class="icon">
                <a href="<?php echo Router::buildLink("user", array("view"=>'resource')) ?>">
                    <img alt="Resource" src="/images/icons/database.png">					
                    <span>Resource Manager</span>
                </a>
            </div>
            
            <div class="icon">
                <a href="<?php echo Router::buildLink("user", array("view"=>'settings')) ?>">
                    <img alt="Resource" src="/images/icons/setting.png">					
                    <span>Settings</span>
                </a>
            </div> 
            
            <div class="icon">
                <a href="<?php echo Router::buildLink("user", array("view"=>'about')) ?>">
                    <img alt="Role" src="/images/icons/about.png">					
                    <span>About</span>
                </a>
            </div>
        </div>
    </div>
    <div class="panel-footer">
         <pre style="font-size: 16px;">
            <b>Resource:</b> Defined all resource need manage and grant permission for account
            <b>Grant Users:</b> Grant permission for user
            <b>Grant Groups:</b> Grant permission for group            
        </pre>
    </div>
</div> 

<style>
    .panel div.icon {
        float: left;
        margin-bottom: 5px;
        margin-right: 5px;
        text-align: center;
    }
    .panel div.icon a {
        border: 1px solid #f0f0f0;
        color: #666;
        display: block;
        float: left;
        height: 200px;
        text-decoration: none;
        vertical-align: middle;
        width: 200px;
    }
    .panel div.icon a:hover {
        background: #f9f9f9 none repeat scroll 0 0;
        border-color: #eee #ccc #ccc #eee;
        border-style: solid;
        border-width: 1px;
        color: #0b55c4;
    }
    .panel img {
        margin: 0 auto;
        padding: 10px 0;
        width: 160px;
        height: 160px;
    }
    .panel span {
        display: block;
        text-align: center;
    }
</style>