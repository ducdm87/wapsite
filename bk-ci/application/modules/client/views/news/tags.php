<h1 style="position: absolute; text-indent: -99999px"><?php echo $tags ?></h1>
<div class="title-red title">
    <div class="title-right">Tags: <?php echo $tags ?></div>
</div>
<div class="box-result">
    <div class="box-news">
        <?php if ($news) { ?>
            <ul class="ulnews">
                <?php
                foreach ($news as $k => $v) {
                    $url = news_link($v->title_link);

                    if ($v->image != '')
                        $img = base_url() . $v->image;
                    else
                        $img = img_link('tin-xo-so.jpg');
                    ?>
                    <li class="clearfix">
                        <div class="imgs">
                            <a href="<?php echo $url ?>"><img src="<?php echo $img ?>" alt="<?php echo view_title($v->title); ?>" width="124" height="82" /></a>
                        </div>
                        <div class="news-infor">
                            <a href="<?php echo $url ?>" class="title-news"><?php echo $v->title; ?></a>
                            <div class="date"><?php echo date('d/m/Y', strtotime($v->created_date)); ?></div>
                            <?php echo $v->short_desc ?>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php }else { ?>
            <div style="text-align:center;padding:10px;font-size:15px">Rất tiếc, Thông tin mà bạn yêu cầu không tồn tại.</div>
        <?php } ?>
        <div class="toolbar"><div class="pages"><?php echo $pagnav; ?></div></div>
    </div>
    <div class="line-red">&nbsp;</div>
</div>