<script type="text/javascript" src="<?php echo base_url(); ?>public/ckeditor/ckeditor.js"></script>
<div class="editcate_top">
    <a href="javascript:void(0)" onclick="history.back();"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>
<div id="div_message"></div>

<form enctype="multipart/form-data" method="post" action="<?php echo current_url(); ?>" id="user_form">
    <div class="editcate_ct">
        <div class="boxadd">
            <ul class="metatags">
                <li>
                <style type="text/css">
					.editcate_ct span {
						float: none;
					}

				</style>
                        <span class="left" style="width: 5%;"><b><?php echo lang($MODULE . "_CONTENT"); ?></b><font color="red">(*)</font></span>
                        <span class="right" style="width: 95%;"><textarea id="key_vn" name="key_vn"  style="width:95%; height:200px; border: none;"><?php echo $row->key_vn; ?></textarea></span>
                        <script type="text/javascript">
                            $(function() {	
                                if(CKEDITOR.instances['key_vn']) {						
                                    CKEDITOR.remove(CKEDITOR.instances['key_vn']);
                                }
                                CKEDITOR.config.float = 'none';
                                CKEDITOR.config.width = '88%';
                                
                                CKEDITOR.config.border = "none";
                                CKEDITOR.config.height = 400;
                                CKEDITOR.replace('key_vn',{
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
            <input type="button" value="<?php echo lang('BACK'); ?>" class="btn" onclick="history.back();" />
            <input type="submit" value="<?php echo lang(($row ? 'EDIT' : 'ADD')); ?>" class="btn" />

        </div>
    </div>
</form>

