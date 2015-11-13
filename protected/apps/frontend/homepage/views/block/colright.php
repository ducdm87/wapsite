<div class="col-right">
    <?php
    fnShowTienIch();
    
    if(getSysConfig("showMapsColumn", 1) == 1){
        $items = getMapsColRight(8);
         
        ?>
            <div class="box-std box-maps-column">
                  <div class="box-title">
                    <h3 class="head">Bản đồ cây xăng</h3>
                </div>
                <div class="inner">
                    <ul class="items">
                        <?php for($i=0;$i<count($items);$i++){ 
                            $item = $items[$i];
                            $item['slug'] = $item['id']."-".$item['alias'];
                            $item['link'] = Yii::app()->createUrl("giaxang/maps", array("location_alias"=>$item['alias']));
                           
                            ?>
                        <li class="item">
                            <a href="<?php echo $item['link']; ?>"> Bản đồ cây xăng <?php echo $item["title"]; ?></a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php
    }
    $showChartColumn = getSysConfig("showChartColumn", 1);
    if($showChartColumn == 1){
        ?>
            <div class="box-std box-chart-column">
                  <div class="box-title">
                    <h3 class="head">Đồ thị Giá dầu trên sàn Nymex </h3>
                </div>
                <div class="inner">
                    <a href="/bieu-do">
                        <img src="/images/xangdau/bieu-do-gia-dau-1y.png" />
                     </a>
                    <a href="/bieu-do">
                        <img src="/images/xangdau/bieu-do-gia-dau-brent-1y.png" />
                     </a>
                </div>
            </div>
        <?php
    }
    
    if(getSysConfig("showNewsColumn", 1) == 1){
    	$controll =Yii::app()->controller->id;
    	$action =Yii::app()->controller->action->id;
    	$cat_alias = Request::getVar('cat_alias',null);
    	$alias = Request::getVar('alias',null);
    	$cid = Request::getInt('cid',null);
 
    	if($controll != "news" OR $action != "category" OR $alias != "minh-bach-xang-dau")
 	       fnShowNewColRight("*", 7, 10);
        fnShowNewColRight("*", 20, 10);
    } 
    ?>
    
</div> 