 

<div class="page-videos">
    <div class="entry-container">
        <div class="entry-header">
            <div class="container-fluid">
                <div class="entry-title">
                    <div class="box-bg-left">
                        <div class="box-bg-right">
                            <div class="box-bg-center">                                
                                <a href="<?php echo $category['link']; ?>"><?php echo $category['title']; ?></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
            <div class="entry-body">                
                <?php if (isset($items) && $items): 
                    $item = $items[0];
                    unset($items[0]);
                    ?>
                <div class="container-fluid">
                    <div class="col-md-5 no-padding-md">
                        <div class="thumbnail">
                            <img src="<?php echo $item['image']; ?>" alt="" style="height: 270px; width: 480px;">
                            <a href="<?php echo $item['link']; ?>" class="icon-play"></a>
                            <div class="caption">
                                <a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a>
                            </div>
                        </div>
                    </div>                   
                    <div class="col-md-7 no-padding-md">
                        <div class="well">
                            <?php if (isset($items) && $items): ?>
                                <div class="row-mobile row">                                    
                                    <?php foreach ($items as $item){ ?>
                                        <div class="col-md-6 row-box">
                                            <div class="media item">
                                                <div class="media-left entry-thunb">
                                                    <a href="<?php echo $this->createUrl('videos/detail?id=' . $item['id'] . '&alias=' . $item['alias']) ?>">
                                                        <img class="media-object" src="<?php echo $item['image']; ?>" alt="Media <?php echo $item['title'] ?>">
                                                        <span class="entry_time"><?php echo $item['duration'] ?></span>
                                                    </a>
                                                </div>
                                                <div class="media-body entry-thunb">
                                                    <span class="media-heading"><a href="<?php echo $item['link'] ?>"><?php echo buildHtml::truncateText($item['title'], 40) ?></a></span>
                                                    <span class="entry-control">
                                                        <span><i class="fa fa-thumbs-o-up"></i> <?php echo $item['like']; ?></span>
                                                        <span><i class="fa fa-play-circle-o"></i> <?php echo $item['viewed']; ?></span>
                                                    </span>
                                                    <div class="entry-social">
                                                        <div class="fb-like" data-href="<?php echo $item['link'] ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
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
                <?php endif; ?>
                <div class="container-fluid">
                    <div class="no-padding-md">
                        <div class="well" style="border: none;">
                            <?php if (isset($items2) && $items2): ?>
                                <div class="row-mobile row">
                                     
                                    <?php foreach ($items2 as $item){ ?>
                                        <div class="col-md-4 row-box">
                                            <div class="media item">
                                                <div class="media-left entry-thunb">
                                                    <a href="<?php echo $item['link'] ?>">
                                                        <img class="media-object" src="<?php echo $item['image']; ?>" alt="Media <?php echo $item['title'] ?>">
                                                        <span class="entry_time"><?php echo $item['duration'] ?></span>
                                                    </a>
                                                </div>
                                                <div class="media-body entry-thunb">
                                                    <span class="media-heading"><a href="<?php echo $item['link'] ?>"><?php echo buildHtml::truncateText($item['title'], 40) ?></a></span>
                                                    <span class="entry-control">
                                                        <span><i class="fa fa-thumbs-o-up"></i> <?php echo $item['like']; ?></span>
                                                        <span><i class="fa fa-play-circle-o"></i> <?php echo $item['viewed']; ?></span>
                                                    </span>
                                                    <div class="entry-social">
                                                        <div class="fb-like" data-href="<?php echo $item['link'] ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
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
    </div>
    
    <div class="fill-data-morepage"></div>
    <?php if(isset($category['pagemore'])){?>
    <div class="entry-container">
        <div class="entry-header">
            <div class="text-center more-page"><a href="<?php echo $category['pagemore'];?>">Xem thêm</a></div>
        </div>
    </div>
    <?php } ?>
    
</div>