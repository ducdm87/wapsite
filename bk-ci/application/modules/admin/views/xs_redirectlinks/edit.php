
<div class="editcate_top">
    <h2><?php echo lang(($submitted ? 'EDIT' : 'ADD')); ?></h2>
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>

<div id="div_message" style="width: 673px;"></div>

<form enctype="multipart/form-data" method="post" action="<?php echo current_url(); ?>" id="user_form">
    <div class="editcate_ct" style="width: 673px;">
        <div class="boxadd">
            <ul class="metatags"> 
                <li>
                    <span class="left"><b>Link<font color="red">(*)</font></b></span>
                    <span class="right"><input type="text" name="link" value="<?php echo(isset($submitted['link']) ? $submitted['link'] : ''); ?>" style="width:80%; margin:0;" /></span>
                </li>
                <li>
                    <span class="left"><b>Link Redirect<font color="red">(*)</font></b></span>
                    <span class="right"><input type="text" name="rlink" value="<?php echo(isset($submitted['rlink']) ? $submitted['rlink'] : ''); ?>" style="width:80%; margin:0;" /></span>
                </li>
                <li>
                    <span class="left"><b><?php echo lang('ACTIVE'); ?></b></span>
                    <span class="right">
                        <input name="published" <?php echo (isset($submitted['published']) && $submitted['published'] == 1 ? 'checked="checked"' : ''); ?> value="1" type="checkbox"/> 
                    </span>
                </li>
            </ul>
        </div>
        <?php if ($EDIT_ACTION): ?>
            <div class="btarticle">
                <input type="button" value="<?php echo lang('CANCEL'); ?>" class="btn" onclick="$('#light_adct').hide();$('#fade_adct').hide();" />
                <input type="submit" value="<?php echo lang(($submitted ? 'EDIT' : 'ADD')); ?>" class="btn" />
            </div>
        <?php endif; ?>
    </div>
</form>
<script type="text/javascript">
    $('#user_form').iframer({
        onComplete: function(msg){
            if(msg == 'yes') {
                $('#light_adct').hide();$('#fade_adct').hide();
                location.href = '<?php echo admin_url($module) ?>';
            }
            else show_error('div_message', msg)
        }
    });
</script>