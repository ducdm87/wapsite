<div class="module row">
    <form action="<?php echo $this->createUrl('videos/') ?>" method="post" name="adminForm">
        <input type="hidden" name="id" value="<?php echo $item->id ?>"/>
        <input type="hidden" name="linkyoutube" class="form-control" value="<?php echo $item->linkyoutube; ?>">
        <div class="col-md-8">
            <div class="panel">
                <div class="panel-heading">
                    <span><b>Info media</b></span>
                    <div class="caption pull-right">
                        <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal-fetchyoutube">Fetch Youtube</button>
                    </div>
                </div>
                <div class="panel-body">
                    <?php echo buildHtml::renderField("label", "id", $item->id, "ID"); ?>
                    <?php echo buildHtml::renderField("text", "title", $item->title, "Title", "form-control title-generate"); ?>
                    <?php echo buildHtml::renderField("text", "alias", $item->alias, "Alias", "form-control alias-generate", "Auto-generate from title"); ?>
                    <?php echo buildHtml::renderField("text", "duration", $item->duration, "Duration"); ?>
                    <?php echo buildHtml::renderField('textarea',"info", $item->info, "Description"); ?> 
                    
                </div>
            </div>
            
            <div class="panel panel-video video-control">
                <div class="panel-heading">
                    <span><b>Video</b></span>
                    <div class="caption pull-right">Thứ tự hiển thị <b>Video code > Video url</b></div>
                </div>
                <div class="panel-body">
                    <div class="form-group row">
                        <div class="col-md-3">Video code</div>
                        <div class="col-md-9">
                            <textarea name="videocode" rows="3" class="form-control"><?php echo $item->videocode; ?></textarea>
                            Mã nhúng video &lt;object>, &lt;embed> hoặc &lt;iframe>.
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-3">Video url</div>
                        <div class="col-md-9">
                            <input name="videourl" id="videourl" type="text" value="<?php echo $item->videourl; ?>" class="form-control" placeholder="Link to file video" />
                            Link trực tiếp đến video
                             <a href="javascript:void(0)" class="label label-primary" role="button" onclick="BrowseServerVideo();">Add video</a>
                        </div>
                    </div>
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
                    <span><b>Meta data</b></span>
                </div>
                <div class="panel-body">
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
            
            
            <div class="panel">
                <div class="panel-heading">
                    <span><b>Image</b></span>
                    <div class="caption pull-right">
                        <a href="javascript:void(0)" class="label label-primary" role="button" onclick="BrowseServer();">Add Media</a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group row">
                        <input type="text" name="image" id="image_hiden" class="form-control" value="<?php echo $item->image ?>"/>
                         
                    </div>
                    <div class="form-group row">
                        <div class="drapzon">
                            <div class="col-md-6 row container-thumbnail">
                                <div class="thumbnail" style="height: 200px;">
                                    <img src="" alt="" id="image_src" style="height:190px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="myModal-fetchyoutube" class="modal fade" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Youtube</h4>
      </div>
      <div class="modal-body">
            <div class="form-group row">
                <div class="col-md-2">Link</div>
                <div class="col-md-10">
                    <input type="text" id="linkyoutube" class="form-control title-generate" value="<?php echo $item->linkyoutube; ?>">
                </div>
            </div>
           <div class="form-group row">
                <div class="col-md-2"></div>
                <div class="col-md-10">
                    <button type="button" class="btn btn-info btn-sm">Get info</button>
                </div>
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>      
</div>      