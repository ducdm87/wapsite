<h1>Danh sách tỉnh Miền Bắc</h1>
<div class="toppage">
    <?php if ($ADD_ACTION == TRUE): ?>
        <span class="btnadd"><a href="<?php echo admin_url($module . '/edit'); ?>">Thêm mới</a></span>
    <?php endif; ?>
</div>
<div class="toppage">
    <div style="float:left;font-size:13px"><a href="javascript:;" style="color:#2195C8;text-decoration:none"><strong>Tổng số:</strong> </a><font class="number"><?php echo $count; ?></font></div>
    <div class="pagination">
        <ul>
            <?php echo (isset($pagnav) ? $pagnav : ''); ?>
        </ul>
    </div>
</div>

<div class="tableout">
    <div class="title1">
        <div class="column" style="width:4%;">#</div>
        <div class="column" style="width:28%;">Tỉnh/TP</div>
        <div class="column" style="width:18%;">SubDomain</div>
        <div class="column" style="width:8%;">Mã giải</div>
        <div class="column" style="width:10%;">Lịch mở thưởng</div>
        <div class="column ta-center" style="width:6%;">Order</div>
        <div class="column ta-center" style="width:8%;"><?php echo lang('ACTIVE'); ?></div>
        <div class="column ta-center" style="width:10%;"><?php echo lang('ACTIONS'); ?></div>
    </div>
    <?php foreach ($rows as $k => $row): ?>
        <div class="linecate">
            <div class="column" style="width:4%;"><?php echo ($offset + $k + 1); ?></div>
            <div class="column" style="width:28%;">
                <a href="javascript:;" class="menu3000"><?php echo $row->name; ?></a>
            </div>
            <div class="column ta" style="width: 18%;"><?php echo $row->alias; ?></div>
            <div class="column ta" style="width: 8%;"><?php echo $row->code; ?></div>
            <div class="column ta" style="width: 10%;"><?php echo $row->lich; ?></div>
            <div class="column ta-center" style="width: 6%;"><?php echo $row->ordering; ?></div>
            <div class="column ta-center" style="width: 8%;">
                <?php if ($row->status == 0): ?>
                    <a href="<?php echo admin_url($module . '/status/' . $row->id . '/1') ?>"><img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Kích hoạt" alt="Kích hoạt"></a>
                <?php else: ?>
                    <a href="<?php echo admin_url($module . '/status/' . $row->id . '/0') ?>"><img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Hủy kích hoạt" alt="Hủy kích hoạt"></a>
                <?php endif; ?>
            </div>
            <div class="column ta-center" style="width:10%;">
                <?php if ($EDIT_ACTION == TRUE): ?>
                    <img src="<?php echo img_link('edit.gif', 'admin'); ?>" /><a href="<?php echo admin_url($module . '/edit/' . $row->id); ?>"><?php echo lang('EDIT'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="bottom1">
        <div class="pagination">
            <ul>
                <?php echo (isset($pagnav) ? $pagnav : ''); ?>
            </ul>
        </div>
    </div>
</div>