
<form action="<?php echo Router::buildLink("users", array("view"=>"group")) ?>" method="post" name="adminForm" >
    <div class="row">
        <div class="panel panel-primary">             
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Name</label>
                        <div class="col-md-9">
                            <input type="text" name="name" class="form-control title-generate" value="<?php echo $item->name; ?>">
                        </div>
                    </div> 
                       
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Status</label>
                        <div class="col-md-9"><?php echo buildHtml::choseStatus("status", $item->status); ?></div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Parent Item</label>
                        <div class="col-md-9"><?php echo $list['parentID']; ?></div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Ordering</label>
                        <div class="col-md-9"><?php echo $list['ordering']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <input type="hidden" name="id" value="<?php echo $item->id; ?>">    
    <input type="hidden" name="cid[]" value="<?php echo $item->id; ?>">    
</form>