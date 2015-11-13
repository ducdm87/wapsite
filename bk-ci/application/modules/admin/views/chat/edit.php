
<div class="editcate_top">
    <h2><?php echo lang(($submitted ? 'EDIT' : 'ADD')); ?></h2>
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();
            $('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>

<div id="div_message" style="width: 673px;"></div>

<form method="post" action="<?php echo current_url(); ?>" id="user_form">
    <div class="editcate_ct" style="width: 673px;">
        <div class="boxadd">
            <ul class="metatags"> 
                <li>
                    <span class="left"><b>Nội dung<font color="red">(*)</font></b></span>
                    <span class="right"><input type="text" name="sms" value="<?php echo(isset($submitted['sms']) ? $submitted['sms'] : ''); ?>" style="width:90%; margin:0;" /></span>
                </li>
            </ul>
        </div>
        <?php if ($EDIT_ACTION): ?>
            <div class="btarticle">
                <input type="button" value="<?php echo lang('CANCEL'); ?>" class="btn" onclick="$('#light_adct').hide();
                            $('#fade_adct').hide();" />
                <input type="submit" value="<?php echo lang(($submitted ? 'EDIT' : 'ADD')); ?>" class="btn" />
            </div>
        <?php endif; ?>
    </div>
</form>
<script type="text/javascript">
    $('#user_form').iframer({
        onComplete: function (msg) {
            if (msg == 'yes') {
                $('#light_adct').hide();
                $('#fade_adct').hide();
                location.href = '<?php echo admin_url($module) ?>';
            }
            else
                show_error('div_message', msg)
        }
    });
</script>