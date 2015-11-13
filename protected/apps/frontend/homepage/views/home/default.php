<?php 
function showBlockHome($items, $title = "Video Hot", $url = "", $type="video"){
    if(count($items)<1) return false;
    $item = $items[0];
    unset($items[0]);
    
    if(isset($item['image'])) $item['thumbnail'] = $item['image'];
    ?>
        <div class="entry-container">
                <div class="entry-header">
                    <div class="container-fluid">
                        <div class="entry-title">
                            <div class="box-bg-left">
                                <div class="box-bg-right">
                                    <div class="box-bg-center">                                
                                        <a href="<?php echo $url; ?>"><?php echo $title; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right entry-all">
                            <a href="<?php echo $url; ?>">Xem tất cả <i class="fa fa-caret-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="entry-body">                    
                        <div class="container-fluid">
                            <div class="col-md-4 no-padding-md">                                 
                                    <div href="<?php echo $item['link']; ?>" class="thumbnail">
                                        <img src="<?php echo $item['thumbnail'] ?>" alt="<?php echo $item['title'] ?>">
                                        <?php if($type == "video"){?>
                                            <a href="<?php echo $item['link']; ?>" class="icon-play"></a>
                                        <?php } ?>
                                        <div class="caption">
                                            <a href="<?php echo $item['link']; ?>"><?php echo isset($item['title']) ? $item['title'] : '' ?></a>
                                        </div>
                                    </div>                                
                            </div>
                            <div class="col-md-8 no-padding-md">
                                <div class="well">
                                    <div class="row">
                                        <?php foreach ($items as $key => $item):
                                            if(isset($item['image'])) $item['thumbnail'] = $item['image'];
                                            ?>
                                            <div class="col-md-6 row-box">
                                                <div class="media item">
                                                    <div class="media-left entry-thunb">
                                                        <a href="<?php echo $item['link']; ?>">
                                                            <img class="media-object" src="<?php echo $item['thumbnail'] ?>" alt="Video <?php echo $item['title'] ?>">
                                                            <?php if(isset($item['duration'])){ ?>
                                                                <span class="entry_time"><?php echo $item['duration'] ?></span>
                                                            <?php } ?>
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="media-heading"><a href="<?php echo $item['link']; ?>"><?php 
//                                                        echo buildHtml::truncateText($item['title'], 40) ;
                                                        echo $item['title'];
                                                                ?></a></span>
                                                        <span class="entry-control">
                                                            <span><i class="fa fa-thumbs-o-up"></i> <?php echo isset($item['value']) ? $item['value'] : 0; ?></span>
                                                            <span><i class="fa fa-play-circle-o"></i> <?php echo isset($item['viewed']) ? $item['viewed'] : 0; ?></span>
                                                        </span>
                                                        <div class="entry-social hidden-lg hidden-md">
                                                            <div class="fb-like" data-href="<?php echo $item['link']; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                             
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
    <?php
}
 
 
?>
 

<div class="page-home">
    <?php foreach($items_videos as $category){     
        ?>
        <?php showBlockHome($category['videos'], $category['title'], $category['link'] ); ?>
    <?php } ?>
    
    <?php showBlockHome($items_news, "Tin tức", Yii::app()->createUrl("articles/"),"article" ); ?>
</div>
       
     