<div class="module row">
    <form action="<?php echo $this->createUrl('articles/') ?>" method="post" name="adminForm">
        <input type="hidden" name="id" value="<?php echo $item->id ?>"/>        
        <div class="col-md-8">
            <div class="panel">
                <div class="panel-heading">
                    <span><b>Main content</b></span>                    
                </div>
                <div class="panel-body">
                    <?php echo buildHtml::renderField("label", "id", $item->id, "ID"); ?>
                    <?php echo buildHtml::renderField("text", "title", $item->title, "Title", "form-control title-generate"); ?>
                    <?php echo buildHtml::renderField("text", "alias", $item->alias, "Alias", "form-control alias-generate", "Auto-generate from title"); ?>
                    <?php echo buildHtml::renderField('textarea',"introtext", $item->introtext, "Description"); ?>
                    <?php echo buildHtml::renderField('editor',"fulltext", $item->fulltext, "Content"); ?>
                </div>
            </div>
             
        </div>
        <div class="col-md-4">
            <div class="panel">
                <div class="panel-heading">
                    <span><b>More info</b></span>
                </div>
                <div class="panel-body">                    
                    <?php echo buildHtml::renderField("calander", "cdate", $item->cdate, "Created",null, "",3,9); ?>
                    <?php echo buildHtml::renderField("label", "mdate", $item->mdate, "Modified",null, "",3,9); ?>
                    <?php echo buildHtml::renderField("label", "category", $list['category'], "Category",null, "",3,9); ?>
                    <?php echo buildHtml::renderField("label", "status", $list['status'], "Status",null, "",3,9); ?>
                    <?php echo buildHtml::renderField("label", "Feature", $list['feature'], "Feature",null, "",3,9); ?>                     
                </div>
            </div>
            
            <div class="panel">
                <div class="panel-heading">
                    <span><b>Image</b></span>
                    <div class="caption pull-right">
                        <a href="javascript:void(0)" class="label label-primary" role="button" onclick="BrowseServer();">Add Media</a>
                    </div>
                </div>
                <div class="panel-body"> 
                    <div class="form-group row">
                        <input type="text" name="thumbnail" id="image_hiden" class="form-control" value="<?php echo $item->thumbnail ?>"/>
                         
                    </div>
                    <div class="form-group row">
                        <div class="drapzon">
                            <div class="col-md-6 row container-thumbnail">
                                <div class="thumbnail" style="height: 200px;">
                                    <img src="<?php echo $item->thumbnail ?>" alt="" id="image_src" style="height:190px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel">
                <div class="panel-heading">
                    <span><b>Meta data</b></span>
                </div>
                <div class="panel-body">
                    <div class="panel-body">
                        <?php echo buildHtml::renderField("textarea", "metakey", $item->metakey, "Meta Key",null, "",3,9); ?>   
                        <?php echo buildHtml::renderField("textarea", "metadesc", $item->metadesc, "Meta Desc", null, "",3,9); ?>
                    </div> 
                </div> 
            </div>
            
        </div>
    </form>
</div>

  