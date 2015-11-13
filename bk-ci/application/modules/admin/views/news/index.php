<h1><?php echo lang($MODULE . '_LIST'); ?></h1>
<div class="toppage">
    <span class="left">
        <ul>
            <li class="left">                
                <form method="get" action="">
                    <input placeholder="Nhập tiêu đề..." name="title" value="<?php echo (isset($_GET['title']) ? $_GET['title'] : '');?>"/>
                    <select name="catid" style="width: 200px;">
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach ($cats_tree as $k => $v): ?>                            
                            <option <?php echo(isset($_GET['catid']) && $_GET['catid'] == $v->id ? 'selected="selected"' : ''); ?> value="<?php echo $v->id; ?>"><?php echo $v->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" value="Apply" class="btn" />
                </form>
            </li>
        </ul>
    </span>
    <?php if ($ADD_ACTION == TRUE): ?>
        <span class="btnadd"><a href="<?php echo admin_url($module . '/add'); ?>"><?php echo lang($MODULE . '_ADD_NEW'); ?></a></span>
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
        <div class="column ta-center" style="width:34%;"><?php echo lang($MODULE . '_TITLE'); ?></div>
        <div class="column ta-center" style="width:21%;"><?php echo lang($MODULE . '_CATEGORY_NAME'); ?></div>
        <div class="column ta-center" style="width:7%;"><?php echo lang('ORDER'); ?></div>
        <div class="column ta-center" style="width:7%;"><?php echo lang('CREATED_DATE'); ?></div>
        <div class="column ta-center" style="width:6%;"><?php echo lang('ACTIVE'); ?></div>
        <div class="column ta-center" style="width:6%;">Ảnh thumb</div>
        <div class="column ta-center" style="width:10%;"><?php echo lang('ACTIONS'); ?></div>
    </div>
    <form action="" method="post">
        <?php foreach ($rows as $k => $row): ?>
            <div class="linecate">
                <div class="column ta-center" style="width:4%;"><?php echo ($offset + $k + 1); ?></div>
                <div class="column" style="width:34%;" onmouseover="Hovercat('<?php echo $row->id; ?>')" onmouseout="Outcat('<?php echo $row->id; ?>')">
                    <a class="menu3000" target="_blank" href="<?php echo news_link($row->title_link); ?>"><?php echo $row->title ?></a><br />
                    <div class="action" id="neocat-<?php echo $row->id; ?>">
                    </div>
                </div>

                <div class="column ta-left" style="width: 21%;">
                    <?php
                    echo $row->cat_name;
//                    $tmp = $this->news_category_model->show_level_cat($row->catid);
//                    foreach ($tmp as $k => $v) {
//                        echo ($k != 0 ? "&raquo;&nbsp;" : "") . $v->name;
//                    }
                    ?>
                </div>
                <div class="column ta-center" style="width: 7%;">
                    <input name="ids[]" value="<?php echo $row->id; ?>" type="hidden"/>
                    <input style="width: 60px;" name="orders[]" value="<?php echo $row->order; ?>"/>
                </div>
                <div class="column ta-center" style="width: 7%;">
                    <?php echo date('d/m/Y', strtotime($row->created_date)); ?>
                </div>

                <div class="column ta-center" style="width: 6%;">
                    <?php if ($row->active == 'no'): ?>
                        <a href="<?php echo admin_url($module . '/edit/' . $row->id . '/yes') ?>"><img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Kích hoạt" alt="Kích hoạt"></a>
                    <?php else: ?>
                        <a href="<?php echo admin_url($module . '/edit/' . $row->id . '/no') ?>"><img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Hủy kích hoạt" alt="Hủy kích hoạt"></a>
                    <?php endif; ?>
                </div>
                <div class="column ta-center" style="width: 6%;">
                    <?php if ($row->is_resize == 0): ?>
                        <a href="<?php echo admin_url($module . '/resize/' . $row->id . '/1') ?>"><img src="<?php echo img_link('pending.png', 'admin'); ?>" class="icon png" title="Sử dụng ảnh thumb" alt="Sử dụng ảnh thumb"></a>
                    <?php else: ?>
                        <a href="<?php echo admin_url($module . '/resize/' . $row->id . '/0') ?>"><img src="<?php echo img_link('active.png', 'admin'); ?>" class="icon png" title="Không sử dụng ảnh thumb" alt="Không sử dụng ảnh thumb"></a>
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