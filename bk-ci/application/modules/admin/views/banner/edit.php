<script type="text/javascript" src="<?php echo base_url(); ?>public/ckeditor/ckeditor.js"></script>

<h1><?php //echo lang($MODULE.'_ADD_NEW');  ?></h1>

<div class="tableout">
    <div class="title1">
        <div class="column" style="width:100%;"><?php echo lang($MODULE . '_EDIT'); ?></div>
    </div>
    <form enctype="multipart/form-data" method="post" action="" id="articles_form">
        <div class="editcate_ct">
            <div class="btarticle">
            <!-- <input type="button" value="Cancel" class="btn" onclick="$('#light_adct').hide();$('#fade_adct').hide();" /> -->
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
                        <span class="left"><b><?php echo lang($MODULE . '_PAGE'); ?></b></span>
                        <span class="right">
                            <select name="page" style="width: 200px;">
                                <?php foreach ($pages as $k => $v): ?>
                                    <option <?php echo(isset($submitted['page']) && $submitted['page'] == $k ? 'selected="selected"' : ''); ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </li>  
                    <li>
                        <span class="left"><b><?php echo lang($MODULE . '_POSITION'); ?></b></span>
                        <span class="right">
                            <select name="position" style="width: 200px;">
                                <?php foreach ($positions as $k => $v): ?>
                                    <option <?php echo(isset($submitted['position']) && $submitted['position'] == $k ? 'selected="selected"' : ''); ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </li>    	
                    <li>
                        <span class="left"><b><?php echo lang($MODULE . '_NAME'); ?><font color="red">(*)</font> :</b></span>
                        <span class="right"><input type="text" name="name" value="<?php echo(isset($submitted['name']) ? $submitted['name'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b><?php echo lang($MODULE . '_URL'); ?></b></span>
                        <span class="right"><input type="text" name="url" value="<?php echo(isset($submitted['url']) ? $submitted['url'] : ''); ?>" style="width:60%; margin:0;" /></span>
                    </li>
                    <li>
                        <span class="left"><b><?php echo lang('IMAGE'); ?></b></span>
                        <span class="right">                	                	
                            <input type="file" name="image" value="" />
                            <?php if (isset($submitted['image'])): ?>
                                <br /><br />
                                <img src="<?php echo base_url() . '' . $submitted['image']; ?>"/>
                            <?php endif; ?>              	
                        </span>
                    </li> 
                    <li>
                        <span class="left"><b><?php echo lang('ORDER'); ?></b></span>
                        <span class="right"><input type="text" name="order" value="<?php echo(isset($submitted['order']) ? $submitted['order'] : ''); ?>" style="width:60%; margin:0;" /></span>
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

                <input type="submit" value="<?php echo lang('EDIT'); ?>" class="btn" />

            </div>
        </div>
    </form>
</div>
