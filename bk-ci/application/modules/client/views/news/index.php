<h1 style="position: absolute; text-indent: -99999px">Tin tức thông tin xổ số</h1>
<div class="title-red title">
    <div class="title-right">
        <div class="pathway">
            <ul>
                <li><a href="<?php echo $uri_root ?>tin-xo-so.html">TIN TỨC</a></li>
                <?php echo isset($category_alias) ? '<li><span>&nbsp;</span></li><li><strong>' . $news[0]->cname . '</strong></li>' : '' ?>
            </ul>
        </div>
    </div>
</div>
<div class="box-result">
    <div class="box-news">
        <ul class="ulnews">
            <?php
            foreach ($news as $k => $v) {
                if (isset($category_alias) && $category_alias != '')
                    $url = news_link($category_alias . '/' . $v->title_link);
                else
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
        <div class="toolbar"><div class="pages"><?php echo $pagnav; ?></div></div>
    </div>
    <div class="line-red">&nbsp;</div>
</div>