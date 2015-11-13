<script type="text/javascript" src="<?php echo base_url(); ?>public/ckeditor/ckeditor.js"></script>

<div class="tableout">
    <div class="title1">
        <div class="column" style="width:100%;"><?php echo lang(($submitted ? 'EDIT' : 'ADD')); ?></div>
    </div>
    <form enctype="multipart/form-data" method="post" action="" id="articles_form">
        <div class="editcate_ct">
            <div class="btarticle">
                <input type="button" value="<?php echo lang('BACK'); ?>" class="btn" onclick="history.back();" />
                <input type="submit" value="<?php echo lang(($submitted ? 'EDIT' : 'ADD')); ?>" class="btn" />        
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
                        <span class="right"><input type="text" name="name" value="<?php echo(isset($submitted['name']) ? $submitted['name'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b>SubDomain</b></span>
                        <span class="right"><input type="text" name="alias" value="<?php echo(isset($submitted['alias']) ? $submitted['alias'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>                    
                    <li>
                        <span class="left"><b>Mã giải<font color="red">(*)</font></b></span>
                        <span class="right"><input type="text" name="code" value="<?php echo(isset($submitted['code']) ? $submitted['code'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>                    
                    <li>
                        <span class="left"><b>Lịch mở thưởng</b></span>
                        <span class="right"><input type="text" name="lich" value="<?php echo(isset($submitted['lich']) ? $submitted['lich'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>                    
                    <li>
                        <span class="left"><b>Mô tả</b></span>
                        <span class="right">
                            <textarea name="description" id="description" style="width:80%; height:100px;"><?php echo(isset($submitted['description']) ? $submitted['description'] : ''); ?></textarea>
                        </span>
                        <script type="text/javascript">
                            $(function() {	
                                if(CKEDITOR.instances['contents']) {						
                                    CKEDITOR.remove(CKEDITOR.instances['description']);
                                }
                                CKEDITOR.config.width = "75%";
                                CKEDITOR.config.border = "none";
                                CKEDITOR.config.height = 200;
                                CKEDITOR.replace('description',{
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
                        <span class="left"><b><?php echo lang('ORDER'); ?></b></span>
                        <span class="right"><input type="text" name="ordering" value="<?php echo(isset($submitted['ordering']) ? $submitted['ordering'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>    
                    <li>
                        <span class="left"><b><?php echo lang('ACTIVE'); ?></b></span>
                        <span class="right">
                            <input name="status" <?php echo (isset($submitted['status']) && $submitted['status'] == 1 ? 'checked="checked"' : ''); ?> value="1" type="checkbox"/> 
                        </span>
                    </li>
                </ul>
            </div>
            <?php if ($EDIT_ACTION): ?>
                <div class="btarticle">
                    <input type="button" value="<?php echo lang('BACK'); ?>" class="btn" onclick="history.back();" />
                    <input type="submit" value="<?php echo lang(($submitted ? 'EDIT' : 'ADD')); ?>" class="btn" />
                </div>
            <?php endif; ?>
        </div>
    </form>
</div>