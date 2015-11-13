<?php
$MODULE = "USER";
?>
<div class="editcate_top">
    <h2><?php echo lang($MODULE . '_ADD_NEW'); ?></h2>
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>

<div id="div_message"></div>

<form enctype="multipart/form-data" method="post" action="<?php echo action_link('add/'); ?>" id="user_form">
    <div class="editcate_ct">
        <div class="boxadd">
            <ul class="metatags">
                <li>
                    <span class="left"><b><?php echo lang($MODULE . '_USERNAME'); ?></b></span>
                    <span class="right"><input type="text" name="username"  value="<?php echo $user->username; ?>" style="width:40%;" /></span>
                </li>
                <li>
                    <span class="left"><b><?php echo lang($MODULE . '_PASSWORD'); ?></b></span>
                    <span class="right"><input name="password" type="password" style="width:40%;"></span>
                </li>
                <li>
                    <span class="left"><b><?php echo lang($MODULE . '_PASSWORD_RE'); ?></b></span>
                    <span class="right"><input name="re_password" type="password" style="width:40%;"></span>
                </li>
                <li>
                    <span class="left"><b><?php echo lang($MODULE . '_FULLNAME'); ?></b></span>
                    <span class="right"><input type="text" name="fullname"  value="<?php echo $user->fullname; ?>" style="width:60%;" /></span>
                </li>
                <li>
                    <span class="left"><b><?php echo lang($MODULE . '_ADDRESS'); ?></b></span>
                    <span class="right"><input type="text" name="address"  value="<?php echo $user->address; ?>" style="width:90%;" /></span>
                </li> <li>
                    <span class="left"><b><?php echo lang($MODULE . '_MOBILE'); ?></b></span>
                    <span class="right"><input type="text" name="mobile"  value="<?php echo $user->mobile; ?>" style="width:40%;" /></span>
                </li>

                <li>
                    <span class="left"><b>Email</b></span>
                    <span class="right"><input name="email" value="<?php echo set_value('email', $user->email); ?>" type="text" style="width:40%;"></span>
                </li>
                <li>
                    <span class="left"><b>&nbsp;</b></span>
                    <span class="right">
                        <select name="gender" style="width: 200px;">
                            <option <?php echo($user->gender == 0 ? 'selected="selected"' : ''); ?> value="0">Thành viên thường</option>
                            <option <?php echo($user->gender == 1 ? 'selected="selected"' : ''); ?> value="1">Thành viên VIP</option>
                        </select>
                    </span>
                </li>
                <li>
                    <span class="left"><b><?php echo lang($MODULE . '_GROUP'); ?> </b></span>
                    <span class="right">
                        <select name="permission" style="width: 200px;">
                            <?php foreach ($group_rows as $k => $v): ?>
                                <option <?php echo($user->group_id == $v->id ? 'selected="selected"' : ''); ?> value="<?php echo $v->id; ?>"><?php echo $v->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </span>
                </li>
                <li>
                    <span class="left"><b><?php echo lang($MODULE . '_ACTIVE'); ?></b></span>
                    <span class="right">
                        <select name="active" style="width: 200px;">
                            <option <?php echo($user->active == 'yes' ? 'selected="selected"' : ''); ?> value="yes">Hoạt động</option>
                            <option <?php echo($user->active == 'no' ? 'selected="selected"' : ''); ?>value="no">Không hoạt động</option>
                        </select>
                    </span>
                </li>
            </ul>
        </div>
        <div class="btarticle">
            <input type="button" value="<?php echo lang('CANCEL'); ?>" class="btn" onclick="$('#light_adct').hide();$('#fade_adct').hide();" />
            <input type="submit" value="<?php echo lang('ADD'); ?>" class="btn" />

        </div>
    </div>
</form>
<script>
    $('#user_form').iframer({
        onComplete: function(msg){
            if(msg == 'yes') {
                $('#light_adct').hide();$('#fade_adct').hide();
                load_content('user_list', window.location.href, true);
            }
            else show_error('div_message', msg)
        }
    });
</script>
