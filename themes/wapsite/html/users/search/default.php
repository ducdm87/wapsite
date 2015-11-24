<div class="entry-container">
        <div class="entry-header">
            <div class="container-fluid">
                <div class="entry-title">
                    <div class="box-bg-left">
                        <div class="box-bg-right">
                            <div class="box-bg-center">                                
                                 <a href="#"><?php echo "Tìm thấy "; echo isset($videos) ? count($videos) : '' ?> kết quả, Với từ khóa: <?php echo isset($_GET['q']) ? $_GET['q'] : '' ?> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="container-fluid">
    <?php if (isset($videos) && $videos): ?>
        <?php $index = 1; ?>
        <?php foreach ($videos as $video): 
            $link = "videos/".$video['calias']."/".$video['id']."-".$video['alias'].".html";?>
            <div class="col-md-4 no-padding-md">
                <div class="row-mobile entry-body">
                    <div class="media item">
                        <div class="media-left entry-thunb">
                            <a href="<?php echo $this->createUrl($link); ?>">
                                <img class="media-object" src="<?php echo $video['image'] ?>" alt="Video <?php echo $video['title'] ?>">
                                <span class="entry_time"><?php echo $video['duration'] ?></span>
                            </a>
                        </div>
                        <div class="media-body entry-thunb">
                            <span class="media-heading"><a href="<?php echo $this->createUrl($link); ?>"><?php echo $video['title'] ?></a></span>
                            <span class="entry-control">
                                <span><i class="fa fa-thumbs-o-up"></i> <?php echo isset($video['value']) ? $video['value'] : 0; ?></span>
                                <span><i class="fa fa-play-circle-o"></i> <?php echo isset($video['viewed']) ? $video['viewed'] : 0; ?></span>
                            </span>
                           
                        </div>
                    </div>
                </div>
            </div>
            <?php echo ($index == 3) ? '<div class="break-line clearfix"></div>' : '' ?>
            <?php $index++; if($index==4) {$index=1;}   ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</div>