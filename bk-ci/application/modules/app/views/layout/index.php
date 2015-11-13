<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Xoso.com</title>
        <link type="text/css" rel="stylesheet" href="<?php echo css_link('app/style.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo css_link('app/stylesbh.css') ?>" />
        <meta name="apple-touch-fullscreen" content="YES" />
    </head>
    <body>
        <div id="wrapper">
            <div class="content">
                <?php
                $this->load->view($tmpl);
                ?>
            </div>
            <div class="mb10 clearfix"></div>
        </div>
    </body>
</html>