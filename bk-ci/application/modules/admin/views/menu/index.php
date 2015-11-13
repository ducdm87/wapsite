<script src="<?php echo js_link('jquery.iframer.js', 'admin'); ?>"></script>
<h1><?php echo lang($MODULE . '_LIST'); ?></h1>
<div class="toppage">
    <?php if ($ADD_ACTION == TRUE): ?>
        <span class="btnadd"><a onclick="open_form('<?php echo admin_url($module . '/update'); ?>');"><?php echo lang('ADD'); ?></a></span>
    <?php endif; ?>
</div>

<div class="tableout">
    <div class="title1">
        <div class="column" style="width:4%;">ID</div>
        <div class="column" style="width:50%;"><?php echo lang($MODULE . '_NAME'); ?></div>
        <div class="column ta-center" style="width:8%;"><?php echo lang('ACTIVE'); ?></div>
        <div class="column ta-center" style="width:10%;"><?php echo lang('ACTIONS'); ?></div>
    </div>
    <?php foreach ($rows as $k => $row): ?>
        <div class="linecate">
            <div class="column" style="width:4%;"><?php echo $row->id; ?></div>
            <div class="column" style="width:50%;" onmouseover="Hovercat('<?php echo $row->id; ?>')" onmouseout="Outcat('<?php echo $row->id; ?>')">
                <?php echo $row->stt; ?><a href="javascript:void()" class="menu3000"><?php echo $row->name; ?></a><br />
                <div class="action" id="neocat-<?php echo $row->id; ?>">
                    <a target="<?php echo $row->target; ?>" href="<?php echo $row->link; ?>"><?php echo $row->link; ?></a>
                </div>
            </div>
            <div class="column ta-center" style="width: 8%;">
                <?php if ($row->active == 0): ?>
                    <a href="<?php echo admin_url($module . '/active/' . $row->id . '/1') ?>"><img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Kích hoạt" alt="Kích hoạt"></a>
                <?php else: ?>
                    <a href="<?php echo admin_url($module . '/active/' . $row->id . '/0') ?>"><img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Hủy kích hoạt" alt="Hủy kích hoạt"></a>
                <?php endif; ?>
            </div>

            <div class="column ta-center" style="width:10%;">
                <?php if ($EDIT_ACTION == TRUE): ?>
                    <img src="<?php echo img_link('edit.gif', 'admin'); ?>" /><a onclick="open_form('<?php echo admin_url($module . '/update/' . $row->id); ?>');" onclick =""><?php echo lang('EDIT'); ?></a>
                <?php endif; ?>
                <?php if ($EDIT_ACTION == TRUE): ?>
                    |&nbsp;<img src="<?php echo img_link('delete.gif', 'admin'); ?>" /><a onclick="return confirm('Bạn chắc chắn muốn xóa?');" href="<?php echo admin_url($module . '/delete/' . $row->id) ?>"><font color="#be0000"><?php echo lang('DELETE'); ?></font></a>
                <?php endif; ?>
            </div>

        </div>



    <?php endforeach; ?>

</div>

</div>