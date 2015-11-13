
<form action="<?php echo $this->createUrl('users/save') ?>" method="post" name="adminForm" >               
    <div class="col-md-8">                    
        <div class="panel">
            <div class="panel-heading">
                <span><b>User Info</b></span>                            
            </div>
            <div class="panel-body">
                <?php echo buildHtml::renderField("text", "username", $item->username, "User Name", "form-control title-generate"); ?>
                <?php echo buildHtml::renderField("text", "changepassword", "", "Password"); ?>
                <?php echo buildHtml::renderField("text", "repassword", "", "Retype Password"); ?>
                
                <?php echo buildHtml::renderField("text", "first_name", $item->first_name, "First Name"); ?>
                <?php echo buildHtml::renderField("text", "last_name", $item->last_name, "Last Name"); ?>
                <?php echo buildHtml::renderField("text", "email", $item->email, "Email"); ?>                
                <?php echo buildHtml::renderField("text", "mobile", $item->mobile, "Mobile"); ?>
                <?php echo buildHtml::renderField("textarea", "address", $item->address, "Address"); ?>                
                <?php echo buildHtml::renderField("text", "city", $item->city, "City"); ?>
                 
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel">
            <div class="panel-heading">
                <span><b>More info</b></span>                            
            </div>
            <div class="panel-body">
                <?php echo buildHtml::renderField("label", "id", $item->id, "ID"); ?>                 
                 <?php echo buildHtml::renderField("label", "cdate", $item->cdate, "Created"); ?>
                 <?php echo buildHtml::renderField("label", "mdate", $item->mdate, "Modified"); ?>
                 <?php echo buildHtml::renderField("label", "lastvisit", $item->lastvisit, "Last visit"); ?>
                <div class="form-group row">
                    <label class="control-label left col-md-3">Status</label>
                    <div class="col-md-9"><?php echo buildHtml::choseStatus("status", $item->status); ?></div>
                </div>
            </div>
        </div>
        
        <div class="panel">
            <div class="panel-heading">
                <span><b>Group</b></span>                            
            </div>
            <div class="panel-body">
                <div class="form-group row">
                    <label class="control-label left col-md-3">Choose</label>
                    <div class="col-md-9"><?php echo $list['groupID']; ?></div>
                </div>
            </div>
        </div>
        
        
    </div>
    <input type="hidden" name="id" value="<?php echo $item->id; ?>">    
    <input type="hidden" name="cid[]" value="<?php echo $item->id; ?>">    
</form>