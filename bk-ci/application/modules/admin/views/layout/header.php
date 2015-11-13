<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>admin-home</title>
        <link type="text/css" rel="stylesheet" href="<?php echo css_link('admin.css', 'admin'); ?>" />
        <script type="text/javascript" src="<?php echo js_link('jquery-1.5.1.min.js', 'admin'); ?>"></script>
        <script type="text/javascript" src="<?php echo js_link('admin.js', 'admin'); ?>"></script>
        <script type="text/javascript" src="<?php echo js_link("hoverdiv.js", "admin"); ?>"></script>
        <script type="text/javascript" src="<?php echo js_link("common.js", "admin"); ?>"></script>
        <script type="text/javascript">
            var base_url = '<?php echo html_url(); ?>';
            var admin_url = '<?php echo admin_url(); ?>/';
        </script>
    </head>
    <body>
        <div class="header">
            <div id="header_r">
                <em>Welcome</em> <b><?php echo $_SESSION['user']['username']; ?></b>
                <br />
                <a href="<?php echo admin_url('logout'); ?>">Logout</a>|<a href="<?php echo admin_url('user/change_pass/'); ?>">Change Password</a>
            </div>
        </div>