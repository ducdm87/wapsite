<script type="text/javascript" src="<?php echo base_url(); ?>public/ckeditor/ckeditor.js"></script>

<div class="tableout">
    <div class="title1">
        <div class="column" style="width:100%;">Thêm mới</div>
    </div>
    <form enctype="multipart/form-data" method="post" action="<?php echo action_link('add'); ?>" id="articles_form">
        <div class="editcate_ct">
            <div class="btarticle">
                <input type="button" value="<?php echo lang('BACK'); ?>" class="btn" onclick="history.back();" />
                <input type="submit" value="<?php echo lang('ADD'); ?>" class="btn" />
            </div>
            <div class="boxadd">
                <ul class="lineadd2"> 
                    <?php if ($this->message->has('error')): ?>
                        <li>
                            <span class="left">&nbsp;</span>
                            <span class="right">
                                <?php echo $this->message->display(); ?>
                            </span>
                        </li>
                    <?php endif; ?>
                    <li>
                        <span class="left"><b>Danh mục<font color="red">(*)</font> :</b></span>
                        <span class="right">
                            <select name="catid" style="width: 200px;">
                                <?php foreach ($cats_tree as $k => $v): ?>
                                    <option <?php echo(isset($submitted['catid']) && $submitted['catid'] == $v->id ? 'selected="selected"' : ''); ?> value="<?php echo $v->id; ?>"><?php echo $v->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </li>    	   	
                    <li>
                        <span class="left"><b>Tiêu đề<font color="red">(*)</font> :</b></span>
                        <span class="right"><input type="text" name="title" value="<?php echo(isset($submitted['title']) ? $submitted['title'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Ảnh</b></span>
                        <span class="right">   

                            <input type="file" name="image" value="" />
                            <input type="hidden" name="is_resize" value="1" />

                            <?php if (isset($submitted['image'])): ?>
                                <br /><br />
                                <img src="<?php echo base_url() . '' . $submitted['image']; ?>"/>
                            <?php endif; ?>              	
                        </span>
                    </li>
                    <li>
                        <span class="left"><b>Mô tả ngắn</b></span>
                        <span class="right">
                            <textarea id="txt_desc" name="short_desc" style="width:60%; height:150px;"><?php echo(isset($submitted['short_desc']) ? $submitted['short_desc'] : ''); ?></textarea>
                        </span>            	
                    </li> 

                    <li>
                        <span class="left"><b>Nội dung</b><font color="red">(*)</font></span>
                        <span class="right"><textarea id="content" name="content"  style="width:60%; height:200px; border: none;"><?php echo(isset($submitted['content']) ? $submitted['content'] : ''); ?></textarea></span>
                        <script type="text/javascript">
                            $(function() {	
                                if(CKEDITOR.instances['contents']) {						
                                    CKEDITOR.remove(CKEDITOR.instances['content']);
                                }
                                CKEDITOR.config.width = "75%";
                                CKEDITOR.config.border = "none";
                                CKEDITOR.config.height = 400;
                                CKEDITOR.replace('content',{
                                    toolbar :
                                        [['Source','Maximize','-','Format','Font','FontSize'],"/",
                                        ['PasteText','PasteFromWord'],
                                        ['TextColor','BGColor','-','Bold','Italic','Underline'],
                                        ['NumberedList','BulletedList'],'/',
                                        ['Outdent','Indent','Blockquote'],
                                        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                                        ['Image','Table','-', 'Link', 'Unlink' ]]
                                });
                            })
                        </script>                
                    </li>   
                    <li>
                        <span class="left"><b>Nguồn</b></span>
                        <span class="right"><input type="text" name="source" value="<?php echo(isset($submitted['source']) ? $submitted['source'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>  
                    <li>
                        <span class="left"><b> Tác giả</b></span>
                        <span class="right"><input type="text" name="source" value="<?php echo(isset($submitted['author']) ? $submitted['author'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>  
                    <li>
                        <span class="left"><b>Tags</b></span>
                        <span class="right"><input type="text" name="tags" value="<?php echo(isset($submitted['tags']) ? $submitted['tags'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Meta Keywords</b></span>
                        <span class="right"><input type="text" name="meta_keywords" value="<?php echo(isset($submitted['meta_keywords']) ? $submitted['meta_keywords'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Meta Description</b></span>
                        <span class="right"><input type="text" name="meta_description" value="<?php echo(isset($submitted['meta_description']) ? $submitted['meta_description'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
<!--                    <li>
                        <span class="left"><b>Kiểu</b></span>
                        <span class="right">
                            <input name="title_link_old1" <?php echo (isset($submitted['title_link_old1']) && $submitted['title_link_old1'] == 1 ? 'checked="checked"' : ''); ?> value="1" type="checkbox"/> Slide<br/>
                            <input name="title_link_old2" <?php echo (isset($submitted['title_link_old2']) && $submitted['title_link_old2'] == 2 ? 'checked="checked"' : ''); ?> value="2" type="checkbox"/> Nổi bật<br/>
                            <input name="title_link_old3" <?php echo (isset($submitted['title_link_old3']) && $submitted['title_link_old3'] == 3 ? 'checked="checked"' : ''); ?> value="3" type="checkbox"/> Đọc nhiều nhất<br/>
                            <input name="title_link_old4" <?php echo (isset($submitted['title_link_old4']) && $submitted['title_link_old4'] == 4 ? 'checked="checked"' : ''); ?> value="4" type="checkbox"/> Hoạt động nổi bật
                        </span>
                    </li>-->
                    <li>
                        <span class="left"><b><?php echo lang('ACTIVE'); ?>:</b></span>
                        <span class="right">
                            <input name="active" <?php echo (isset($submitted['active']) && $submitted['active'] == 'yes' ? 'checked="checked"' : ''); ?> value="yes" type="checkbox"/> 
                        </span>
                    </li>

                </ul>
            </div>
            <div class="btarticle">
                <input type="button" value="<?php echo lang('BACK'); ?>" class="btn" onclick="history.back();" />
                <input type="submit" value="<?php echo lang('ADD'); ?>" class="btn" />
            </div>
        </div>
    </form>
</div>
