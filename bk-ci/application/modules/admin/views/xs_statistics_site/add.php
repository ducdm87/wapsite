<script type="text/javascript" src="<?php echo base_url(); ?>public/ckeditor/ckeditor.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>public/jscal/src/css/jscal2.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>public/jscal/src/js/jscal2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/jscal/src/js/lang/en.js"></script>
<div class="tableout">
    <div class="title1">
        <div class="column" style="width:100%;"><?php echo lang('ADD'); ?></div>
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
                        <span class="left"><b>Tỉnh/TP<font color="red">(*)</font></b></span>
                        <span class="right">
                            <select name="lid" style="width: 200px;">
                                <?php foreach ($xs_location as $k => $v): ?>
                                    <option <?php echo(isset($submitted['lid']) && $submitted['lid'] == $v->id ? 'selected="selected"' : ''); ?> value="<?php echo $v->id; ?>"><?php echo $v->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </li> 
                    <li>
                        <span class="left"><b>Ngày<font color="red">(*)</font></b></span>
                        <span class="right">
                            <input type="text" id="f_rangeStart" name="date" value="<?php echo(isset($submitted['date']) ? date('d/m/Y', strtotime($submitted['date'])) : date("d/m/Y")); ?>" />
                            <input style="border: none;" type="image" id="f_rangeStart_trigger" onclick="return false;" src="<?php echo img_link('date.gif') ?>"/>
                        </span>
                        <script type="text/javascript">
                            new Calendar({
                                inputField: "f_rangeStart",
                                dateFormat: "%d/%m/%Y",
                                trigger: "f_rangeStart_trigger",
                                bottomBar: false,
                                onSelect: function() {
                                    var date = Calendar.intToDate(this.selection.get());
                                    this.hide();
                                }
                            });
                        </script>
                    </li>     	
                    <li>
                        <span class="left"><b>Nội dung</b><font color="red">(*)</font></span>
                        <span class="right"><textarea id="content" name="content"><?php echo(isset($submitted['content']) ? $submitted['content'] : ''); ?></textarea></span>
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
