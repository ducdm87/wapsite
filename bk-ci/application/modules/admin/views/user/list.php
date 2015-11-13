<div class="toppage">
    <span class="left">
        <form method="get" action="">
            <input placeholder="Nhập user hoặc email..." name="name" value="<?php echo (isset($_GET['name']) ? $_GET['name'] : ''); ?>"/>

            <select name="group">
                <option value="0">---Nhóm---</option>
                <?php foreach ($group_rows as $k => $v): ?>
                    <option value="<?php echo $v->id; ?>" <?php echo (isset($_GET["group"]) && $_GET["group"] == $v->id ? 'selected="selected"' : ''); ?>><?php echo $v->name; ?></option>
                <?php endforeach; ?>
            </select>
            <select name="status">
                <option value="">---Trạng thái---</option>
                <option <?php echo (isset($_GET["status"]) && $_GET["status"] == "yes" ? 'selected="selected"' : ''); ?> value="yes">Kích hoạt</option>
                <option <?php echo (isset($_GET["status"]) && $_GET["status"] == "no" ? 'selected="selected"' : ''); ?> value="no">Chưa kích hoạt</option>
            </select>
            <input value="Apply" class="btn" type="submit">
            <a href="javascript:;">Tổng số: </a><font class="number">&nbsp;(<?php echo $total; ?>)</font>
        </form>
    </span>
    <?php if ($ADD_ACTION == TRUE): ?>
        <span class="btnadd">
            <a onclick="open_form('<?php echo action_link('add'); ?>')" href="javascript:void(0)"><?php echo lang($MODULE . '_ADD_NEW'); ?></a>
        </span>
    <?php endif; ?>
</div>
<div class="tableout">

    <?php echo $this->message->display(); ?>

    <form method="post" action="<?php echo action_link('do_action'); ?>" id="action_form">

        <div class="title1">
            <div class="column ta-center" style="width: 4%;"><?php echo lang('STT'); ?></div>
            <div class="column ta-center" style="width: 26%;">Tên đăng nhập</div>
            <div class="column ta-center" style="width: 30%;">Email</div>
            <div class="column ta-center" style="width: 13%;">Nhóm</div>
            <div class="column ta-center" style="width: 16%;">Ngày tạo</div>
            <div class="column ta-center" style="width: 8%;">Kích hoạt</div>
        </div>

        <?php if (count($user_list) > 0): ?>
            <?php //$limit = $; ?>
            <?php foreach ($user_list as $i => $user): ?>
                <div class="linecate2">
                    <div class="column ta-center" style="width: 4%;"><?php echo ($page - 1) * $limit + $i + 1; ?></div>

                    <div id="row_<?php echo $user->id; ?>">

                        <div class="column" style="width: 26%;" onmouseover="Hovercat('<?php echo $user->id; ?>')" onmouseout="Outcat('<?php echo $user->id; ?>')">
                            <a href="javascript:;" class="art"><?php echo $user->username; ?></a>
                            <div class="action" id="neocat-<?php echo $user->id; ?>">
                                <img src="<?php echo img_link('edit.gif', 'admin'); ?>"><a href="javascript:void(0)" onclick="open_form('<?php echo action_link('edit/' . $user->id); ?>')">Sửa</a><img src="<?php echo img_link('delete.gif', 'admin'); ?>"><a href="javascript:void(0)" onclick="user_delete('<?php echo $user->id; ?>')"><font color="#be0000">Xóa</font></a>
                            </div>
                        </div>
                        <div class="column" style="width: 30%;">
                            <?php echo $user->email; ?>
                        </div>
                        <div class="column ta-center" style="width: 13%;">
                            <?php
                            $group = $this->group_model->get_by(array('id' => $user->group_id));
                            if ($group) {
                                echo $group->name;
                            }
                            ?>
                        </div>
                        <div class="column ta-center" style="width: 16%;"><font class="date"><?php echo date('d-m-Y', strtotime($user->created_date)); ?></font></div>

                        <div class="column ta-center" style="width: 8%;">
                            <?php if ($user->active != 'yes'): ?>
                                <a href="javascript:void(0);" onclick="user_status('<?php echo $user->id; ?>', 'yes')"><img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Kích hoạt" alt="Kích hoạt"></a>
                            <?php else: ?>
                                <a href="javascript:void(0);" onclick="user_status('<?php echo $user->id; ?>', 'no')"><img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Hủy kích hoạt" alt="Hủy kích hoạt"></a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="bottom1">
            <div class="column" style="width: 2%;">&nbsp;</div>
            <div class="column" style="width: 50%;">
                &nbsp;
            </div>
            <span class="right1">

                <div class="pagination">

                    <ul>
                        <?php echo (isset($pagnav) ? $pagnav : ''); ?>
                    </ul>
                </div>
            </span>
        </div>

    </form>

</div>

<script>
    $('#action_form').iframer({
        onComplete: function(msg){
            if(msg == 'yes') {
                load_content('user_list', '<?php echo current_link(); ?>', true);
            }
            else show_error('div_message', msg)
        }
    });
</script>