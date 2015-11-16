
<form action="<?php echo $this->createUrl('menus/menutypes') ?>" method="post" name="adminForm" >
    <div class="row">
        <div class="panel panel-primary">             
            <div class="panel-body">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <div>
                            <input type="text" name="title" class="form-control" value="<?php echo $obj_tblMenu->title; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Alias</label>
                        <div>
                            <input type="text" name="alias" class="form-control" value="<?php echo $obj_tblMenu->alias; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Description</label>
                        <div>
                            <textarea type="text" name="description" class="form-control"><?php echo $obj_tblMenu->description; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                </div>
            </div>
        </div>
    </div>
    
    <input type="hidden" name="id" value="<?php echo $obj_tblMenu->id; ?>">    
    <input type="hidden" name="cid[]" value="<?php echo $obj_tblMenu->id; ?>">    
</form>