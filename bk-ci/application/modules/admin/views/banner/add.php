<script type="text/javascript" src="<?php echo base_url(); ?>public/ckeditor/ckeditor.js"></script>
<div class="tableout">
    <div class="title1">
        <div class="column" style="width:100%;"><?php echo lang($MODULE . '_ADD_NEW'); ?></div>
    </div>
    <form enctype="multipart/form-data" method="post" action="<?php echo action_link('add'); ?>" id="articles_form">
        <div class="editcate_ct">
            <?php if ($ADD_ACTION): ?>
                <div class="btarticle">
                    <input type="submit" value="<?php echo lang('ADD'); ?>" class="btn" />
                </div>
            <?php endif; ?>
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
            <?php if ($ADD_ACTION): ?>
                <div class="btarticle">

                    <input type="submit" value="<?php echo lang('ADD'); ?>" class="btn" />

                </div>
            <?php endif; ?>
        </div>
    </form>
</div>
