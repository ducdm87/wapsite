
<div class="page-videos">
    <div class="entry-container">
        <div class="entry-header">
            <div class="container-fluid">
                <div class="entry-title">
                    <div class="box-bg-left">
                        <div class="box-bg-right">
                            <div class="box-bg-center">                                
                                <?php echo isset($lable) ? $lable : 'Video Hot'; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php if (isset($videos) && $videos): ?>
            <div class="entry-body">
                <div class="container-fluid">
                    <div class="col-md-5 no-padding-md">
                        <div class="thumbnail">
                            <img src="<?php echo isset($videos[0]['image']) ? $videos[0]['image'] : '' ?>" alt="" style="height: 270px; width: 480px;">
                            <a href="<?php echo $this->createUrl('videos/detail?id=' . $videos[0]['id'] . '&alias=' . $videos[0]['alias']) ?>" class="icon-play"></a>
                            <div class="caption">
                                <a href="<?php echo $this->createUrl('videos/detail?id=' . $videos[0]['id'] . '&alias=' . $videos[0]['alias']) ?>"><?php echo isset($videos[0]['title']) ? $videos[0]['title'] : '' ?></a>
                            </div>
                        </div>
                    </div>
                    <?php unset($videos[0]); ?>
                    <div class="col-md-7 no-padding-md">
                        <div class="well">
                            <?php if (isset($videos) && $videos): ?>
                                <div class="row-mobile row">                                    
                                    <?php foreach ($videos as $video){ ?>
                                        <div class="col-md-6 row-box">
                                            <div class="media item">
                                                <div class="media-left entry-thunb">
                                                    <a href="<?php echo $this->createUrl('videos/detail?id=' . $video['id'] . '&alias=' . $video['alias']) ?>">
                                                        <img class="media-object" src="<?php echo isset($video['image']) ? $video['image'] : '' ?>" alt="Media <?php echo $video['title'] ?>">
                                                        <span class="entry_time"><?php echo $video['duration'] ?></span>
                                                    </a>
                                                </div>
                                                <div class="media-body entry-thunb">
                                                    <span class="media-heading"><a href="<?php echo $this->createUrl('videos/detail?id=' . $video['id'] . '&alias=' . $video['alias']) ?>"><?php echo buildHtml::truncateText($video['title'], 40) ?></a></span>
                                                    <span class="entry-control">
                                                        <span><i class="fa fa-thumbs-o-up"></i> <?php echo isset($video['value']) ? $video['value'] : 0; ?></span>
                                                        <span><i class="fa fa-play-circle-o"></i> <?php echo isset($video['viewed']) ? $video['viewed'] : 0; ?></span>
                                                    </span>
                                                    <div class="entry-social">
                                                        <div class="fb-like" data-href="<?php echo $this->createUrl('videos/detail?id=' . $video['id'] . '&alias=' . $video['alias']) ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        
                                    <?php } ?>
                                </div>                             
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="no-padding-md">
                        <div class="well" style="border: none;">
                            <?php if (isset($allvideos) && $allvideos): ?>
                                <div class="row-mobile row">
                                     
                                    <?php foreach ($allvideos as $video){ ?>
                                        <div class="col-md-4 row-box">
                                            <div class="media item">
                                                <div class="media-left entry-thunb">
                                                    <a href="<?php echo $this->createUrl('videos/detail?id=' . $video['id'] . '&alias=' . $video['alias']) ?>">
                                                        <img class="media-object" src="<?php echo isset($video['image']) ? $video['image'] : '' ?>" alt="Media <?php echo $video['title'] ?>">
                                                        <span class="entry_time"><?php echo $video['duration'] ?></span>
                                                    </a>
                                                </div>
                                                <div class="media-body entry-thunb">
                                                    <span class="media-heading"><a href="<?php echo $this->createUrl('videos/detail?id=' . $video['id'] . '&alias=' . $video['alias']) ?>"><?php echo buildHtml::truncateText($video['title'], 40) ?></a></span>
                                                    <span class="entry-control">
                                                        <span><i class="fa fa-thumbs-o-up"></i> <?php echo isset($video['value']) ? $video['value'] : 0; ?></span>
                                                        <span><i class="fa fa-play-circle-o"></i> <?php echo isset($video['viewed']) ? $video['viewed'] : 0; ?></span>
                                                    </span>
                                                    <div class="entry-social">
                                                        <div class="fb-like" data-href="<?php echo $this->createUrl('videos/detail?id=' . $video['id'] . '&alias=' . $video['alias']) ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    <?php } ?>
                                </div>                           
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="fill-data-morepage"></div>
    
    <div class="entry-container">
        <div class="entry-header">
            <div class="text-center more-page"><a href="_frontend">Xem thêm</a></div>
        </div>
    </div>
    
</div>