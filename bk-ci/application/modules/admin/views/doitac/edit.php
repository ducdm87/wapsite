<div class="tableout">
    <div class="title1">
        <div class="column" style="width:100%;">Sửa</div>
    </div>
    <form enctype="multipart/form-data" method="post" action="" id="articles_form">
        <div class="editcate_ct">
            <div class="btarticle">
                <input type="button" value="<?php echo lang('BACK'); ?>" class="btn" onclick="history.back();" />
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
                        <span class="left"><b>Tên đối tác<font color="red">(*)</font></b></span>
                        <span class="right"><input type="text" name="title" value="<?php echo(isset($submitted['title']) ? $submitted['title'] : ''); ?>" style="width:40%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Link</b></span>
                        <span class="right"><input type="text" name="link" value="<?php echo(isset($submitted['link']) ? $submitted['link'] : ''); ?>" style="width:40%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b>Logo</b></span>
                        <span class="right">                	                	
                            <input type="file" name="image" value="" />
                            <?php if (isset($submitted['image'])): ?>
                                <br /><br />
                                <img style="max-height:100px;max-width:100px" src="<?php echo base_url() . '' . $submitted['image']; ?>"/>
                            <?php endif; ?>              	
                        </span>
                    </li> 
                    <li>
                        <span class="left"><b><?php echo lang('ACTIVE'); ?></b></span>
                        <span class="right">
                            <input name="published" <?php echo (isset($submitted['published']) && $submitted['published'] == 1 ? 'checked="checked"' : ''); ?> value="1" type="checkbox"/> 
                        </span>
                    </li>

                </ul>
            </div>
            <div class="btarticle">
                <input type="button" value="<?php echo lang('BACK'); ?>" class="btn" onclick="history.back();" />
                <input type="submit" value="<?php echo lang('EDIT'); ?>" class="btn" />

            </div>
        </div>
    </form>
</div>
