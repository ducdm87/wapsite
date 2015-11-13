<script src="<?php echo js_link('jquery.iframer.js', 'admin'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/ckeditor/ckeditor.js"></script>
<h1><?php echo lang($MODULE . '_LIST'); ?></h1>
<div class="toppage">
    <span class="left">
        <!-- 
        <select style="width:130px;">
        <option value="1">Action</option>
        <option value="2">Edit</option>
        <option value="3">Delete</option>
    </select>
    <input type="submit" name="" value="Apply" class="btn" />
        <font class="number">(9)</font> <a href="javascript:;">Tour Style</a><font class="line">|</font><font class="number">(1120)</font> <a href="javascript:;"><font color="#0b9901">Active</font></a><font class="line">|</font><font class="number">(5)</font> <a href="javascript:;"><font color="#c60001">Pending</font></a> -->
    </span>
    <?php if ($ADD_ACTION == TRUE): ?>
        <span class="btnadd"><a href="<?php echo admin_url($module . '/update'); ?>"><?php echo lang('ADD'); ?></a></span>
    <?php endif; ?>
</div>


<div class="tableout">
    <div class="title1">
        <div class="column" style="width:4%;">#</div>
        <div class="column" style="width:15%;"><?php echo lang($MODULE . '_NAME'); ?></div>
        <div class="column" style="width:30%;"><?php echo lang($MODULE . '_TITLE'); ?></div>
        <div class="column ta-center" style="width:8%;"><?php echo lang('CREATED_DATE'); ?></div>
        <div class="column ta-center" style="width:10%;"><?php echo lang('ACTIONS'); ?></div>
    </div>
    <?php foreach ($rows as $k => $row): ?>
        <div class="linecate">
            <div class="column" style="width:4%;"><?php echo ($k + 1); ?></div>
            <div class="column" style="width:15%;" onmouseover="Hovercat('<?php echo $row->id; ?>')" onmouseout="Outcat('<?php echo $row->id; ?>')">
                <a><?php echo $row->stt; ?></a><a href="javascript:;" class="menu3000"><?php echo $row->name; ?></a><br />
                <div class="action" id="neocat-<?php echo $row->id; ?>">

                </div>
            </div>

            <div class="column ta-left" style="width: 30%;">
                <?php echo $row->title; ?>
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