<div class="">
    <form action="<?php echo $this->createUrl('categories/save') ?>" method="post" name="adminForm">
        <input type="hidden" name="id"  value="<?php echo $item->id; ?>"/>
        <div class="col-md-8">
            <div class="panel">
                <div class="panel-heading">
                    <span>Detail</span>
                </div>
                <div class="panel-body">
                    <div class="form-group row">
                        <div class="col-md-3">Tên</div>
                        <div class="col-md-9">
                            <input type="text" name="title" class="form-control title-generate" value="<?php echo $item->title; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">Alias</div>
                        <div class="col-md-9">
                            <input type="text" name="alias" class="form-control alias-generate" placeholder="Auto-generate from title" value="<?php echo $item->alias; ?>">
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-3">Trạng thái</div>
                        <div class="col-md-9">
                            <select name="status" class="">
                                <option value="1" <?php if ($item->status == 1) echo 'selected=""'; ?> >Enable</option>
                                <option value="0" <?php if ($item->status == 0) echo 'selected=""'; ?> >Disable</option>                            
                            </select>
                        </div>
                    </div>      
                    <div class="form-group row">
                        <div class="col-md-3">Nổi bật</div>
                        <div class="col-md-9">
                            <select name="feature" class="">
                                <option value="1" <?php if ($item->feature == 1) echo 'selected=""'; ?> > On</option>
                                <option value="0" <?php if ($item->feature == 0) echo 'selected=""'; ?>> Off</option>                            
                            </select>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <div class="col-md-3">Mô tả</div>
                        <div class="col-md-9">
                            <textarea name="description" rows="3" cols="50"><?php echo $item->description; ?></textarea>
                        </div>
                    </div>   
                </div>
            </div>

        </div> 

        <div class="col-md-4">
            <div class="panel">
                <div class="panel-heading">
                    <span>Meta data</span>
                </div>
                <div class="panel-body">
                    <div class="form-group row">
                        <div class="col-md-3">Meta Key</div>
                        <div class="col-md-9">
                            <textarea name="metakey" rows="4" cols="30"><?php echo $item->metakey; ?></textarea>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-3">Meta Desc</div>
                        <div class="col-md-9">
                            <textarea name="metadesc" rows="4" cols="30"><?php echo $item->metadesc; ?></textarea>
                        </div>
                    </div> 
                </div> 
            </div> 
        </div> 
    </form>
</div>

<script>
    $(".selection-menu-select").change(function() {
        changeSelectMenu();
    });

    function changeSelectMenu() {
        var val = $(".selection-menu-select").val();
        var opts = $("#selection-menu").find("option");
        if (val == "all") {
//            $("#selection-menu").attr("disabled", true);
            $(".row-menu-select").hide();
        } else if (val == "none") {
//            $("#selection-menu").attr("disabled", true);            
            $(".row-menu-select").hide();
        } else {
//            $("#selection-menu").attr("disabled", false);
            $(".row-menu-select").show();
            $(".row-menu-select").removeClass("hide");
        }
    }
    changeSelectMenu();
</script>