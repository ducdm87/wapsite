<h1>Quản trị thống kê</h1>
<div class="toppage">
    <?php if ($ADD_ACTION == TRUE): ?>
        <span class="btnadd"><a href="<?php echo admin_url($module . '/add'); ?>">Thêm mới</a></span>
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
        <div class="column ta-center" style="width:4%;"><?php echo lang('STT') ?></div>
        <div class="column" style="width:32%;">Tiêu đề</div>
        <div class="column" style="width:30%;">Alias</div>
        <div class="column ta-center" style="width:7%;"><?php echo lang('ORDER'); ?></div>
        <div class="column ta-center" style="width:6%;"><?php echo lang('ACTIVE'); ?></div>
        <div class="column ta-center" style="width:10%;"><?php echo lang('ACTIONS'); ?></div>
    </div>
    <form action="" method="post">
        <?php foreach ($rows as $k => $row): ?>
            <div class="linecate">
                <div class="column ta-center" style="width:4%;"><?php echo ($offset + $k + 1); ?></div>
                <div class="column" style="width:32%;">
                    <a class="menu3000" href="javascript:;"><?php echo $row->title ?></a>
                </div>
                <div class="column" style="width:30%;"><?php echo $row->alias ?></div>
                <div class="column ta-center" style="width: 7%;">
                    <input name="ids[]" value="<?php echo $row->id; ?>" type="hidden"/>
                    <input style="width: 60px;" name="orders[]" value="<?php echo $row->order; ?>"/>
                </div>
                <div class="column ta-center" style="width: 6%;">
                    <?php if ($row->published == 0): ?>
                        <a href="<?php echo admin_url($module . '/edit/' . $row->id . '/1') ?>"><img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Kích hoạt" alt="Kích hoạt"></a>
                    <?php else: ?>
                        <a href="<?php echo admin_url($module . '/edit/' . $row->id . '/0') ?>"><img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Hủy kích hoạt" alt="Hủy kích hoạt"></a>
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

        <div class="bottom1">
            <div class="column" style="width: 2%;">&nbsp;</div>
            <div class="column" style="width: 50%;">
                <input class="btn" type="submit" value="Cập nhật"/>
            </div>
            <div class="pagination">
                <ul>
                    <?php echo (isset($pagnav) ? $pagnav : ''); ?>
                </ul>
            </div>
        </div>
    </form>  
</div>