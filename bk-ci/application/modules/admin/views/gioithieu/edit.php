<script type="text/javascript" src="<?php echo base_url(); ?>public/ckeditor/ckeditor.js"></script>
<div class="tableout">
    <div class="title1">
        <div class="column" style="width:100%;"></div>
    </div>
    <form enctype="multipart/form-data" method="post" action="" id="articles_form">
        <div class="editcate_ct">
            <div class="btarticle">
                <input type="submit" value="<?php echo lang('EDIT'); ?>" class="btn" />        
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
                        <span class="left"><b>Tiêu đề<font color="red">(*)</font> :</b></span>
                        <span class="right"><input type="text" name="title" value="<?php echo(isset($submitted['title']) ? htmlspecialchars($submitted['title'], ENT_QUOTES, 'UTF-8') : ''); ?>" style="width:60%; margin:0;" /></span>
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
                </ul>
            </div>
            <div class="btarticle">
                <input type="submit" value="<?php echo lang('EDIT'); ?>" class="btn" />
            </div>
        </div>
    </form>
</div>