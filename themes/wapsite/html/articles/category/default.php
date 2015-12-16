 

<div class="page-news">  
        <div class="entry-container">
            <div class="entry-header">                
                <div class="container-fluid">                
                    <div class="entry-title">
                        <div class="box-bg-left">
                            <div class="box-bg-right">
                                <div class="box-bg-center">                                
                                    <a href="<?php echo $category['link']; ?>"><?php echo $category['title'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>                
                </div>                
            </div>
            <div class="entry-body">     
                <div class="container-fluid">
                    <?php if (isset($category['items']) && $category['items']): ?>
                        <?php foreach ($category['items'] as $obj_article):                             
                            ?>
                            <div class="media entry-news">
                                <div class="media-left media-middle">
                                    <a href="<?php echo $obj_article['link']; ?>" class="thumb">
                                        <img class="media-object" src="<?php echo $obj_article['thumbnail'] ?>" alt="<?php echo $obj_article['title'] ?>" height="105" width="105">
                                    </a>
                                </div>
                                <div class="media-body entry-caption">
                                    <h4 class="media-heading"><a href="<?php echo $obj_article['link']; ?>"><?php echo $obj_article['title'] ?></a></h4>
                                    <?php echo $obj_article['introtext'] ?>
                                    <div class="readmore">
                                        <a href="<?php echo $obj_article['link']; ?>">Xem thêm >></a>
                                    </div>
                                </div>
                            </div>
                            <div class="clear-fix break-line border-botton "></div>
                        <?php endforeach; ?>                    
                    <?php endif; ?>               
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
         <div class="fill-data-morepage"></div>
        <?php if(isset($category['pagemore'])){?>
        <div class="entry-container">
            <div class="entry-header">
                <div class="text-center more-page"><a href="<?php echo $category['pagemore'];?>">Xem thêm</a></div>
            </div>
        </div>
        <?php } ?>
</div>
