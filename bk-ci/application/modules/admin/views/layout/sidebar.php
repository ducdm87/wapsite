<div class="sidebar">
    <?php
    $CI = & get_instance();
    $CI->load->model('module_model');
    $modules = $CI->module_model->get_module_by_user();
    ?>
    <ul class="menuleft">
        <?php if ($_admin == 1): ?>
            <li class="title"><a class="title" href="<?php echo admin_url('home') ?>">Trang chủ</a></li>
            <li class="title"><a class="title">Hệ thống</a></li>
            <li<?php echo ($act == 'module') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('module') ?>">Module</a></li>
            <li<?php echo ($act == 'meta') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('meta') ?>">Meta</a></li>
            <li<?php echo ($act == 'banner') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('banner') ?>">Quản lý banner</a></li>
            <li><a class="png cate" href="<?php echo admin_url('gioithieu') ?>/edit/1">Giới thiệu</a></li>
            <li><a class="png cate" href="<?php echo admin_url('gioithieu') ?>/edit/2">Nội dung SMS</a></li>
            <li<?php echo ($act == 'xs_redirectlinks') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_redirectlinks') ?>">Link Redirect</a></li>
            <li class="title"><a class="title">Thành viên</a></li>
            <li<?php echo ($act == 'user') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('user') ?>">Thành viên quản trị</a></li>
            <li<?php echo ($act == 'user_member') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('user_member') ?>">Quản lý thành viên</a></li>
            <li<?php echo ($act == 'chat') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('chat') ?>">Quản lý Chat</a></li>
            <li<?php echo ($act == 'datso') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('datso') ?>">Đặt số</a></li>
			<li<?php echo ($act == 'toploto') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('toploto') ?>">Top Loto</a></li>
            <li<?php echo ($act == 'group') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('group') ?>">Nhóm</a></li>
            <li class="title"><a class="title">TTTT Xổ Số</a></li>
            <li<?php echo ($act == 'xs_tttt' && $func == 'mn') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_tttt/mn') ?>">TTTT Miền Nam</a></li>
            <li<?php echo ($act == 'xs_tttt' && $func == 'mt') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_tttt/mt') ?>">TTTT Miền Trung</a></li>
            <li<?php echo ($act == 'xs_tttt' && $func == 'mb') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_tttt/mb') ?>">TTTT Miền Bắc</a></li>
            <li class="title"><a class="title">Xổ Số</a></li>
            <li<?php echo ($act == 'xs_dreams_categories') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_dreams_categories') ?>">Danh mục giấc mơ</a></li>
            <li<?php echo ($act == 'xs_dreams') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_dreams') ?>">Giải đáp giấc mơ</a></li>
            <li<?php echo ($act == 'xs_location') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_location') ?>">Lịch mở thưởng</a></li>
            <li<?php echo ($act == 'xs_location_mb') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_location_mb') ?>">Danh sách tỉnh Miền Bắc</a></li>
            <li<?php echo ($act == 'xs_truyenthong') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_truyenthong') ?>">Xổ số truyền thống</a></li>
            <li<?php echo ($act == 'xs_northern') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_northern') ?>">Xổ số điện toán</a></li>
            <li<?php echo ($act == 'xs_veso') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_veso') ?>">Vé số</a></li>
            <li<?php echo ($act == 'xs_statistics_links') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_statistics_links') ?>">Thống kê</a></li>
            <li<?php echo ($act == 'xs_keyword') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_keyword') ?>">Từ khoá phổ biến</a></li>
            <li<?php echo ($act == 'xs_mo_receiver') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_mo_receiver') ?>">Quản lý SMS</a></li>
            <li<?php echo ($act == 'demo') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('demo') ?>">Demo tạo mã nhúng</a></li>
            <li<?php echo ($act == 'doitac') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('doitac') ?>">Đối tác</a></li>
            <li class="title"><a class="title">Tin tức - sự kiện</a></li>
            <li<?php echo ($act == 'news' && $func == 'category_index') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('news/category_index') ?>">Danh mục</a></li>
            <li<?php echo ($func == 'news') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('news/news') ?>">Tin tức - sự kiện</a></li>
            <li<?php echo ($act == 'xs_dudoan') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_dudoan') ?>">Dự đoán Xổ Số</a></li>
            <li<?php echo ($act == 'xs_lotonuoi') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_lotonuoi') ?>">Các dự đoán hiệu quả</a></li>
            <li<?php echo ($act == 'xs_kinhnghiem') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_kinhnghiem') ?>">Kinh nghiệm bắt số nuôi</a></li>
            <li<?php echo ($act == 'xs_statistics_vip') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_statistics_vip') ?>">Thống kê VIP Xổ Số</a></li>
            <li<?php echo ($act == 'xs_statistics_site') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('xs_statistics_site') ?>">Thống kê từ diễn đàn khác</a></li>
            <li class="title"><a class="title">Trợ giúp</a></li>
            <li<?php echo ($act == 'help' && $func == 'category_index') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('help/category_index') ?>">Danh mục</a></li>
            <li<?php echo ($func == 'help') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('help/help') ?>">Trợ giúp</a></li>
        	<li class="title"><a class="title">Black Keyword</a></li> 
            <li<?php echo ($act == 'blackkey' && $func == 'key_index') ? ' class="current" ' : ''; ?>><a class="png cate" href="<?php echo admin_url('blackkey/key_index') ?>">Quản lý Key</a></li>
        <?php else: ?>
            <li class="<?php echo ($act == 'home') ? 'current' : ''; ?>"><a href="<?php echo admin_url('home'); ?>" class="home png">Home</a></li>
            <?php foreach ($modules as $k => $v): ?>
                <li class="<?php echo ($act == $v->name_alias) ? 'current' : ''; ?>"><a href="<?php echo admin_url($v->name_alias); ?>" class="cate png"><?php echo $v->name; ?></a></li>
                <?php
                $subs = $CI->module_model->get_many_by(array('pid' => $v->id, 'name <>' => ''));
                ?>
                <?php foreach ($subs as $v_sub): ?>
                    <?php if ($CI->module_model->check_per_func($v->name_alias, $v_sub->name_alias)): ?>
                        <li class="sub">&raquo;&nbsp;&nbsp;<a href="<?php echo admin_url($v->name_alias . '/' . $v_sub->name_alias); ?>" <?php echo ($act == $v->name_alias && ($func == $v_sub->name_alias)) ? 'class="current"' : ''; ?>><?php echo $v_sub->name; ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>