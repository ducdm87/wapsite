<h1>Danh sách vé số</h1>
<div class="toppage">
    <span class="left">
        <ul>
            <li class="left">                
                <form method="get" action="">
                    <select name="catid" style="width: 200px;">
                        <option value="">-- Chọn danh mục --</option>
                        <option <?php echo(isset($_GET['catid']) && $_GET['catid'] == 1 ? 'selected="selected"' : ''); ?> value="1">Vé số Miền Bắc</option>
                        <option <?php echo(isset($_GET['catid']) && $_GET['catid'] == 2 ? 'selected="selected"' : ''); ?> value="2">Vé số Miền Trung</option>
                        <option <?php echo(isset($_GET['catid']) && $_GET['catid'] == 3 ? 'selected="selected"' : ''); ?> value="3">Vé số Miền Nam</option>
                    </select>
                    <input type="submit" value="Apply" class="btn" />
                </form>
            </li>
        </ul>
    </span>
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
        <div class="column ta-center" style="width:40%;">Tiêu đề</div>
        <div class="column ta-center" style="width:21%;">Danh mục</div>
        <div class="column ta-center" style="width:10%;"><?php echo lang('CREATED_DATE'); ?></div>
        <div class="column ta-center" style="width:10%;"><?php echo lang('ACTIVE'); ?></div>
        <div class="column ta-center" style="width:10%;"><?php echo lang('ACTIONS'); ?></div>
    </div>
    <form action="" method="post">
        <?php
        foreach ($rows as $k => $row):
            if ($row->catid == 1) {
                $url = base_url() . 've-so-mien-bac.html';
                $catname = 'Vé số Miền Bắc';
            } elseif ($row->catid == 2) {
                $url = base_url() . 've-so-mien-trung.html';
                $catname = 'Vé số Miền Trung';
            } else {
                $url = base_url() . 've-so-mien-nam.html';
                $catname = 'Vé số Miền Nam';
            }
            ?>
            <div class="linecate">
                <div class="column ta-center" style="width:4%;"><?php echo ($offset + $k + 1); ?></div>
                <div class="column" style="width:40%;" onmouseover="Hovercat('<?php echo $row->id; ?>')" onmouseout="Outcat('<?php echo $row->id; ?>')">
                    <a class="menu3000" target="_blank" href="<?php echo $url ?>"><?php echo $row->title ?></a><br />
                    <div class="action" id="neocat-<?php echo $row->id; ?>">
                    </div>
                </div>

                <div class="column ta-left" style="width: 21%;"><?php echo $catname ?></div>
                <div class="column ta-center" style="width: 10%;">
                    <?php echo date('d/m/Y', strtotime($row->created_date)); ?>
                </div>
                <div class="column ta-center" style="width: 10%;">
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
        <div class="bottom1">
            <div class="pagination">
                <ul>
                    <?php echo (isset($pagnav) ? $pagnav : ''); ?>
                </ul>
            </div>
        </div>
    </form>  
</div>