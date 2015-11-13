 

<div class="page-video">
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/jwplayer/jwplayer.js"></script>
    <script type="text/javascript">jwplayer.key = "Il334Pdk5OF2EBrjO5LrSA/ZK7qdYC/nL80QExPiIxoQ96iqPROaAEye70E=";</script>

    <div class="wrapper">
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
                <?php if (isset($item) && $item): ?>
                <h1><a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a></h1>
                    <div class="container-fluid">
                        <div class="col-md-5">
                            <div class="row">
                                <?php //$item['videocode'] = ""; 
                                echo fnDisplayVideo($item); ?>                                
                                <div class="entry-contrainer-info">
                                    <div class="entry-info">
                                        <div class="pull-left">
                                            <ul class="list-inline btn-group">
                                                <li>
                                                    <?php 
                                                    if($item['allowlike'] == true){
                                                    ?>
                                                    <a href="javascript:void(0)" class="" onclick="like_video('<?php echo $item['link_like']; ?>')"><i class="fa fa-thumbs-o-up fa-x2"></i></a>
                                                    <?php }else{ ?>
                                                        <a href="javascript:void(0)" class="" ><i class="fa fa-thumbs-o-up fa-x2" style="color: black;"></i></a>
                                                    <?php } ?>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="share_vide()"><i class="fa fa-share-alt fa-x2"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="pull-right">
                                            <span class="entry-viewed">Lượt xem <span><?php echo isset($item['viewed']) ? $item['viewed'] : 0 ?></span></span>
                                        </div>

                                    </div>
                                    <div class="entry-caption">
                                        <div class="info-social">
                                            <strong>Chia sẻ :</strong> 
                                            <a href="javascript:void(0)" onclick="return share_facebook('<?php echo htmlspecialchars($item['title']) ?>', '<?php echo htmlspecialchars($item['info']) ?>',null, '<?php echo $item['image']?>');">
                                                <i class="fa fa-facebook-square fa-2x "></i>
                                            </a>
                                            <a href="javascript:void(0)" onclick="return sharingTweet('<?php echo htmlspecialchars($item['info']) ?>', '<?php echo $item['image']?>', null)" >
                                                <i class="fa fa-twitter-square fa-2x"></i>
                                            </a>
                                        </div>
                                        <div class="info-description">
                                            <span><?php echo isset($item['info']) ? $item['info'] : 'Đang cập nhật...' ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($items) && $items): ?>
                            <div class="col-md-7 no-padding-md">
                                <div class="well">
                                    <div class="row-mobile row">
                                        <?php foreach ($items as $key => $item): ?>
                                            <div class="col-md-6 no-padding-md">
                                                <div class="row-mobile">
                                                    <div class="media item">
                                                        <div class="media-left entry-thunb">
                                                            <a href="<?php echo $item['link']; ?>">
                                                                <img class="media-object" src="<?php echo $item['image'] ?>" alt="Video <?php echo $item['title'] ?>">
                                                                <span class="entry_time"><?php echo $item['duration'] ?></span>
                                                            </a>
                                                        </div>
                                                        <div class="media-body entry-thunb">
                                                            <span class="media-heading"><a href="<?php echo $item['link']; ?>"><?php echo buildHtml::truncateText($item['title'], 40) ?></a></span>
                                                            <span class="entry-control">
                                                                <span><i class="fa fa-thumbs-o-up"></i> <?php echo isset($item['value']) ? $item['value'] : 0; ?></span>
                                                                <span><i class="fa fa-play-circle-o"></i> <?php echo isset($item['viewed']) ? $item['viewed'] : 0; ?></span>
                                                            </span>
                                                            <div class="entry-social">
                                                                <div class="fb-like" data-href="<?php echo $item['link']; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if ($key == 1): ?>
                                                <div class="break-line clearfix"></div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
            <div class="entry-header-box">
                <div class="container">
                    <div class="entry-box">
                        <h2>
                            <span>Bạn muốn xem</span>
                        </h2>
                    </div>
                    <div class="entry-box-body">
                        <?php if (isset($items2) && $items2): ?>
                            <?php $index = 0; ?>
                            <?php foreach ($items2 as $item): ?>
                                <div class="col-md-4 no-padding-md">
                                    <div class="row-mobile">
                                        <div class="media item">
                                            <div class="media-left entry-thunb">
                                                <a href="<?php echo $item['link']; ?>">
                                                    <img class="media-object" src="<?php echo $item['image'] ?>" alt="Video <?php echo $item['title'] ?>">
                                                    <span class="entry_time"><?php echo $item['duration'] ?></span>
                                                </a>
                                            </div>
                                            <div class="media-body entry-thunb">
                                                <span class="media-heading"><a href="<?php echo $item['link']; ?>"><?php echo $item['title'] ?></a></span>
                                                <span class="entry-control">
                                                    <span><i class="fa fa-thumbs-o-up"></i> <?php echo isset($item['value']) ? $item['value'] : 0; ?></span>
                                                    <span><i class="fa fa-play-circle-o"></i> <?php echo isset($item['viewed']) ? $item['viewed'] : 0; ?></span>
                                                </span>
                                                <div class="entry-social">
                                                    <div class="fb-like" data-href="<?php echo $item['link']; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
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
                </div>
            </div>
        </div>
    </div>
    </div>
</div>