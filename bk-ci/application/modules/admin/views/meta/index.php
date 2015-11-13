<h1><?php echo lang($MODULE . '_LIST'); ?></h1>

<div class="toppage">
    <span class="left">

    </span>
    <?php if ($ADD_ACTION): ?>
        <span class="btnadd">
            <a href="<?php echo admin_url($module . '/update'); ?>"><?php echo lang($MODULE . '_ADD_NEW'); ?></a>
        </span>
    <?php endif; ?>
</div>
<div class="tableout">

    <?php echo $this->message->display(); ?>

    <form method="post" action="<?php echo action_link('do_action'); ?>" id="action_form">
        <div class="title1">
            <div class="column ta-center" style="width: 4%;"><?php echo lang('STT'); ?></div>
            <div class="column ta-center" style="width: 15%;"><?php echo lang($MODULE . '_NAME'); ?></div>
            <div class="column ta-center" style="width: 26%;"><?php echo lang($MODULE . '_TITLE'); ?></div>
            <div class="column ta-center" style="width: 40%;"><?php echo lang($MODULE . '_KEYWORDS'); ?></div>
            <div class="column ta-center" style="width: 10%;">Thao tác</div>
        </div>

        <?php if (count($rows) > 0): ?>
            <?php
            $pages = get_pages();
            ?>
            <?php foreach ($rows as $i => $user): ?>
                <div class="linecate2">
                    <div class="column ta-center" style="width: 4%;"><?php echo $user->id; ?></div>

                    <div id="row_<?php echo $user->id; ?>">

                        <?php
                        //$page	=	$this->page_model->get_by(array('id' => $user->name_ascii));
                        ?>
                        <div class="column" style="width: 15%;" onmouseover="Hovercat('<?php echo $user->id; ?>')" onmouseout="Outcat('<?php echo $user->id; ?>')">
                            <a href="<?php echo admin_url($module . '/update/' . $user->id); ?>"><?php echo ($user->name ? $user->name : $user->name_ascii); ?></a>
                            <div class="action" id="neocat-<?php echo $user->id; ?>">
                                <img src="<?php echo img_link('edit.gif', 'admin'); ?>"><a href="<?php echo admin_url($module . '/update/' . $user->id); ?>">Sửa</a><img src="<?php echo img_link('delete.gif', 'admin'); ?>"><a onclick="return confirm('Bạn chắc chắn muốn xóa?');" href="<?php echo admin_url($module . '/delete/' . $user->id); ?>"><font color="#be0000">Xóa</font></a>
                            </div>
                        </div>
                        <div class="column" style="width: 26%;">
                            <?php echo $user->title ?>
                        </div>
                        <div class="column" style="width: 40%;">
                            <?php echo $user->keywords ?>
                        </div>
                        <div class="column ta-center" style="width: 10%;">
                            <?php if ($EDIT_ACTION): ?>
                                <img src="<?php echo img_link('edit.gif', 'admin'); ?>"><a href="<?php echo admin_url($module . '/update/' . $user->id); ?>"><?php echo lang('EDIT'); ?></a>
                            <?php endif; ?>
                            <?php if ($DELETE_ACTION): ?>
                                &nbsp;|&nbsp;<img src="<?php echo img_link('delete.gif', 'admin'); ?>"><a onclick="return confirm('Bạn chắc chắn muốn xóa?');" href="<?php echo admin_url($module . '/delete/' . $user->id); ?>"><font color="#be0000"><?php echo lang('DELETE'); ?></font></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="bottom1">
            <div class="pagination">
                <ul>
                    <?php echo (isset($pagnav) ? $pagnav : ''); ?>
                </ul>
            </div>
        </div>

    </form>

</div>