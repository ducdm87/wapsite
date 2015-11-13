<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="<?php echo $_meta['description'] ?>" />
        <meta name="keywords" content="<?php echo $_meta['keywords'] ?>" />
        <title><?php echo $_meta['title'] ?></title>
        <meta property="og:image" content="<?php echo img_link('logo.png') ?>" />
        <?php if ($meta_refresh_mb == true && $meta_refresh_mt == true && $meta_refresh_mn == true) { ?>
            <meta http-equiv="refresh" content="900" />
        <?php } ?>
        <link type="image/x-icon" href="<?php echo img_link('favicon.ico') ?>" rel="shortcut icon" />
        <link type="text/css" rel="stylesheet" href="<?php echo $uri_root ?>min/g=css1411" />
        <script type="text/javascript" src="<?php echo $uri_root ?>min/g=js1411"></script>
         
    </head>
    <body>
        <div id="wrapper">
            <?php $this->load->view($layout_header) ?>
            <div class="content-wrap">
                <div class="content">
                    <div class="main clearfix">
                                <?php $this->load->view($layout_col_left) ?>
                        <div class="col-main">
                            <div class="col-content">
                                <?php
                                $this->load->view($tmpl);
                                ?>
                                <br/>
                            </div>
                            <div class="col-right">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php $this->load->view($layout_footer) ?>
        </div>
    </body>
</html>