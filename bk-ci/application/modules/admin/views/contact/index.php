<script src="<?php echo js_link('jquery.iframer.js', 'admin'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/ckeditor/ckeditor.js"></script>
<h1>Danh sách liên hệ</h1>

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
        <div class="column" style="width:40%;">Họ và tên</div>
        <div class="column" style="width:20%;">Email</div>
        <div class="column" style="width:10%;">Điện thoại</div>
        <div class="column ta-center" style="width:8%;">Ngày gửi</div>
        <div class="column ta-center" style="width:10%;"><?php echo lang('ACTIONS'); ?></div>
    </div>
    <?php foreach ($rows as $k => $row): ?>
        <div class="linecate">
            <div class="column" style="width:4%;"><?php echo ($offset + $k + 1); ?></div>
            <div class="column" style="width:40%;">
                <a href="javascript:;" class="menu3000"><?php echo $row->fullname; ?></a>
            </div>
            <div class="column ta" style="width: 20%;"><?php echo $row->email; ?></div>
            <div class="column ta" style="width: 10%;"><?php echo $row->mobile; ?></div>
            <div class="column ta-center" style="width: 8%;">
                <?php echo date('d/m/Y', strtotime($row->time)); ?>
            </div>
            <div class="column ta-center" style="width:10%;">
                <a href="javascript:;" onclick ="open_form('<?php echo admin_url($module . '/view/' . $row->id); ?>');">Xem</a>
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