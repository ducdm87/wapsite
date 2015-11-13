<div class="clearfix"></div>
<div class="module row">
    <form action="<?php echo $this->createUrl('articles/add') ?>" method="post">
        <div class="col-md-8 row">
            <div class="panel">
                <div class="panel-body">
                    <input type="hidden" name="id" value="<?php echo isset($item['id']) ? $item['id'] : '' ?>"/>
                           <div class="form-group">
                        <label class="control-label">Title</label>
                        <div>
                            <input type="text" class="input-sm form-control title-generate" name="title" value="<?php echo isset($item['title']) ? $item['title'] : '' ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Alias</label>
                        <div>
                            <input type="text" class="input-sm form-control alias-generate" name="alias" value="<?php echo isset($item['alias']) ? $item['alias'] : '' ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Intro Text</label>
                        <div>
                            <textarea name="introtext" class="form-control" rows="5"><?php echo isset($item['introtext']) ? $item['introtext'] : '' ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Content</label>
                        <div>
                            <textarea name="content" class="form-control ckeditor" rows="7"><?php echo isset($item['fulltext']) ? $item['fulltext'] : '' ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Link Original</label>
                        <div>
                            <input type="text" class="input-sm form-control" name="link_original" value="<?php echo isset($item['link_original']) ? $item['link_original'] : '' ?>"/>
                        </div>
                    </div>
                </div>

            </div>

            <div class="panel">
                <div class="panel-heading">
                    <span>Set Meta</span>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">Meta key</label>
                        <div>
                            <input type="text" class="input-sm form-control" name="metakey" value="<?php echo isset($item['metakey']) ? $item['metakey'] : '' ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Meta Description</label>
                        <div>
                            <textarea class="form-control" name="metadesc" rows="3"><?php echo isset($item['metadesc']) ? $item['metadesc'] : '' ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="padding-right: 0px;">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group catalog">
                        <label class="control-label">Category</label>
                        <div>
                            <select class="form-control" name="category">
                                <?php if (isset($categories) && $categories): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['id'] ?>" <?php echo isset($item['catid']) && ($item['catid']==$category['id'])? 'selected':''; ?>><?php echo $category['title'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group status">
                        <label class="control-label">Status</label>
                        <div>
                            <select class="form-control" name="status">
                                <option value="1" <?php echo isset($item['status']) && ($item['status']==1)? 'selected':''; ?>>Enable</option>
                                <option value="0" <?php echo isset($item['status']) && ($item['status']==0)? 'selected':''; ?>>Disable</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel panel-heading">
                    <span>Thumbnail</span>
                    <div class="panel-heading-controls">
                        <a href="javascript:void(0)" onclick="BrowseServer();" class="label label-primary add-input"><i class="fa fa-plus"></i> add</a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <input type="hidden" name="image" id="image_hiden" value="<?php echo isset($item['thumbnail']) ? $item['thumbnail'] : '' ?>"/>
                        <div class="drapzon">
                            <div class="col-md-12 row">
                                <div class="thumbnail" style="height: 200px;">
                                    <img src="<?php echo isset($item['thumbnail']) ? Yii::app()->getBaseUrl(true).'/'. $item['thumbnail'] : '' ?>" alt="" id="image_src" style="height:190px;">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group action">
                        <button type="submit" class="btn btn-primary">Publish</button>
                        <button type="submit" class="btn btn-info">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>