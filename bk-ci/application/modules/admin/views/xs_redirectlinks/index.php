<script src="<?php echo js_link('jquery.iframer.js', 'admin'); ?>"></script>
<h1>Quản lý Link Redirect</h1>
<div class="toppage">
    <?php if ($ADD_ACTION == TRUE): ?>
        <span class="btnadd"><a href="javascript:;" onclick ="open_form('<?php echo admin_url($module . '/edit'); ?>');">Thêm mới</a></span>
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
        <div class="column ta-center" style="width:4%;"><?php echo lang('STT'); ?></div>
        <div class="column ta-center" style="width:36%;">Link</div>
        <div class="column ta-center" style="width:36%;">Link Redirect</div>
        <div class="column ta-center" style="width:8%;"><?php echo lang('ACTIVE'); ?></div>
        <div class="column ta-center" style="width:10%;"><?php echo lang('ACTIONS'); ?></div>
    </div>
    <?php foreach ($rows as $k => $row): ?>
        <div class="linecate">
            <div class="column ta-center" style="width:4%;"><?php echo ($offset + $k + 1); ?></div>
            <div class="column" style="width:36%;">
                <a target="_blank" href="<?php echo base_url().'tin-xo-so/'.$row->link; ?>" class="menu3000"><?php echo $row->link; ?></a>
            </div>
            <div class="column" style="width:36%;">
                <?php echo $row->rlink; ?>
            </div>
            <div class="column ta-center" style="width: 8%;">
                <?php if ($row->published == 0): ?>
                    <a href="<?php echo admin_url($module . '/active/' . $row->id . '/1') ?>"><img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Kích hoạt" alt="Kích hoạt" /></a>
                <?php else: ?>
                    <a href="<?php echo admin_url($module . '/active/' . $row->id . '/0') ?>"><img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Hủy kích hoạt" alt="Hủy kích hoạt" /></a>
                <?php endif; ?>
            </div>
            <div class="column ta-center" style="width:10%;">
                <?php if ($EDIT_ACTION == TRUE): ?>
                    <img src="<?php echo img_link('edit.gif', 'admin'); ?>" /><a href="javascript:;" onclick ="open_form('<?php echo admin_url($module . '/edit/' . $row->id); ?>');"><?php echo lang('EDIT'); ?></a>
                <?php endif; ?>
                <?php if ($EDIT_ACTION == TRUE): ?>
                    |&nbsp;<img src="<?php echo img_link('delete.gif', 'admin'); ?>" /><a onclick="return confirm('Bạn chắc chắn muốn xóa?');" href="<?php echo admin_url($module . '/delete/' . $row->id) ?>"><font color="#be0000"><?php echo lang('DELETE'); ?></font></a>
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