<script src="<?php echo js_link('jquery.iframer.js', 'admin'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/ckeditor/ckeditor.js"></script>
<h1>Giới thiệu về Bộ Công An</h1>
<div class="toppage">
    <span class="left">
    </span>
    <?php if ($ADD_ACTION == TRUE): ?>
        <span class="btnadd"><a href="<?php echo admin_url($module . '/update'); ?>"><?php echo lang('ADD'); ?></a></span>
    <?php endif; ?>
</div>


<div class="tableout">
    <div class="title1">
        <div class="column" style="width:4%;">#</div>
        <div class="column" style="width:30%;">Tiêu đề</div>
        <div class="column ta-center" style="width:8%;"><?php echo lang('CREATED_DATE'); ?></div>
        <div class="column ta-center" style="width:10%;"><?php echo lang('ACTIONS'); ?></div>
    </div>
    <?php foreach ($rows as $k => $row): ?>
        <div class="linecate">
            <div class="column" style="width:4%;"><?php echo ($k + 1); ?></div>
            <div class="column" style="width:30%;">
                <a href="javascript:;" class="menu3000"><?php echo $row->title; ?></a>
            </div>

            <div class="column ta-center" style="width: 8%;">
                <?php echo date('d/m/Y', $row->time); ?>
            </div>
            <div class="column ta-center" style="width:10%;">
                <?php if ($EDIT_ACTION == TRUE): ?>
                    <img src="<?php echo img_link('edit.gif', 'admin'); ?>" /><a href="<?php echo admin_url($module . '/update/' . $row->id); ?>" onclick =""><?php echo lang('EDIT'); ?></a>
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