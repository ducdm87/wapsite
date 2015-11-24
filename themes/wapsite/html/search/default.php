<div class="container-full">
    <div class="dialog-message">
        <div class="alert alert-warning alert-dismissible text-center" role="alert">
            <!--<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
            <p>Kết quả tìm kiếm với từ khóa <strong><?php echo isset($_GET['q']) ? $_GET['q'] : '' ?></strong> có <?php echo isset($videos) ? count($videos) : '' ?> kết quả</p>
        </div>
    </div>
</div>
<div class="container-fluid">
    <?php if (isset($videos) && $videos): ?>
        <?php $index = 0; ?>
        <?php foreach ($videos as $video): ?>
            <div class="col-md-4 no-padding-md">
                <div class="row-mobile entry-body">
                    <div class="media item">
                        <div class="media-left entry-thunb">
                            <a href="<?php echo $this->createUrl('videos/detail?id=' . $video['id'] . '&alias=' . $video['alias']) ?>">
                                <img class="media-object" src="<?php echo $video['image'] ?>" alt="Video <?php echo $video['title'] ?>">
                                <span class="entry_time"><?php echo $video['duration'] ?></span>
                            </a>
                        </div>
                        <div class="media-body entry-thunb">
                            <span class="media-heading"><a href="<?php echo $this->createUrl('videos/detail?id=' . $video['id'] . '&alias=' . $video['alias']) ?>"><?php echo $video['title'] ?></a></span>
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
            </div>
            <?php echo ($index == 2) ? '<div class="break-line clearfix"></div>' : '' ?>
            <?php $index++; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<style type="text/css">
    #wrapper{
        margin-bottom: 20px;
    }
</style>