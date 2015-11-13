
<div class="row">
    <div class="panel panel-primary">
        <div class="panel panel-heading">
            <span><i class="fa fa-bars"></i> Upload & Install Extension</span>
        </div>
        <div class="panel-body">
            <form action="<?php echo $this->createUrl('installer/uploadext') ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Extension package file</label>
                        <div class="col-md-9">
                            <input type="file" name="install_package" style="border: none;" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3"></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary" type="submit">Upload & install</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>