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