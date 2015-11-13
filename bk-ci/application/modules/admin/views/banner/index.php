<h1>Quản lý banner</h1>
<div class="toppage">
    <span class="left">
    </span>
    <?php if ($ADD_ACTION == TRUE): ?>
        <span class="btnadd"><a href="<?php echo admin_url($module . '/add'); ?>"><?php echo lang($MODULE . '_ADD_NEW'); ?></a></span>
    <?php endif; ?>
</div>


<div class="tableout">
    <div class="title1">
        <div class="column ta-center" style="width:4%;"><?php echo lang('STT'); ?></div>
        <div class="column ta-center" style="width:44%;"><?php echo lang($MODULE . '_NAME'); ?></div>
        <div class="column ta-center" style="width:10%;">Tên trang</div>
        <div class="column ta-center" style="width:10%;">Vị trí</div>
        <div class="column ta-center" style="width:8%;">Số thứ tự</div>
        <div class="column ta-center" style="width:8%;"><?php echo lang('ACTIVE'); ?></div>
        <div class="column ta-center" style="width:10%;"><?php echo lang('ACTIONS'); ?></div>
    </div>
    <?php foreach ($rows as $k => $row): ?>
        <div class="linecate">
            <div class="column ta-center" style="width:4%;"><?php echo ($k + 1); ?></div>
            <div class="column" style="width:44%;" onmouseover="Hovercat('<?php echo $row->id; ?>')" onmouseout="Outcat('<?php echo $row->id; ?>')">
                <a target="_blank" href="<?php echo $row->url; ?>" class="menu3000"><?php echo $row->name; ?></a><br />
                <div class="action" id="neocat-<?php echo $row->id; ?>">

                </div>
            </div>
            <div class="column ta-center" style="width:10%">
                <?php echo $pages[$row->page] ?>
            </div>
            <div class="column ta-center" style="width:10%">
                <?php echo $positions[$row->position] ?>
            </div>
            <div class="column ta-center" style="width: 8%;">
                <?php echo $row->order ?>
            </div>
            <div class="column ta-center" style="width: 8%;">
                <?php if ($row->active == 'no'): ?>
                    <a href="<?php echo admin_url($module . '/edit/' . $row->id . '/yes') ?>"><img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Kích hoạt" alt="Kích hoạt"></a>
                <?php else: ?>
                    <a href="<?php echo admin_url($module . '/edit/' . $row->id . '/no') ?>"><img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Hủy kích hoạt" alt="Hủy kích hoạt"></a>
                <?php endif; ?>
            </div>

            <div class="column ta-center" style="width:10%;">
                <?php if ($EDIT_ACTION == TRUE): ?>
                    <img src="<?php echo img_link('edit.gif', 'admin'); ?>" /><a href="<?php echo admin_url($module . '/edit/' . $row->id); ?>" onclick =""><?php echo lang('EDIT'); ?></a>
                <?php endif; ?>
                <?php if ($EDIT_ACTION == TRUE): ?>
                    |&nbsp;<img src="<?php echo img_link('delete.gif', 'admin'); ?>" /><a onclick="return confirm('Bạn chắc chắn muốn xóa?');" href="<?php echo admin_url($module . '/delete/' . $row->id) ?>"><font color="#be0000"><?php echo lang('DELETE'); ?></font></a>
                <?php endif; ?>
            </div>

        </div>



    <?php endforeach; ?>

</div>

</div>