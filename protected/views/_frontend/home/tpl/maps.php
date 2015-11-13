<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$location_alias = Request::getVar('location_alias', 'ha-noi');
$currentMap = null; 
$limit = 18;
$totalPage = ceil(count($maps)/$limit);
$currentPage = 1;

echo '<div class="page-bando">';
    echo '<div class="danhsach-bando left  width-30">';
        echo '<div class="box-std box-danhsach-tinhthanh">
                <div class="box-title">
                    <h3 class="head">Danh sách tỉnh thành</h3>
                </div>
                <script> var limit_bando_danhsach_tinh = '.$limit.'; </script>
               <div class="inner">';
                    echo '<ul class="items">';
                        foreach ($maps as $i => $map){
            //                alias
                            $link = Yii::app()->createUrl("giaxang/maps", array("location_alias"=>$map['alias']));
                            $class =  "";
                            if($location_alias == $map['alias']){
                                $class = "active";
                                $currentMap = $map;
                                $currentPage = ceil(($i + 1)/$limit);
                            }

                            echo '<li class="'.$class.'"><a href="'.$link.'">Bản đồ cây xăng '.$map['title'].'</a></li>';
                        }
                     echo '</ul>';
                    
                     echo '<ul class="pageNave">';
                        for($i=1;$i<=$totalPage; $i++){
                            $class = "";
                            if($currentPage == $i) $class = "active";
                            echo '<li class="'.$class.'" rel="'.$i.'">'.$i.'</li>';
                        }
                     echo '</ul>';
            echo '</div>';
        echo '</div>';
        echo '<div class="box-std box-chart-column">
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
            </div>';
    echo '</div>';
    
    echo '<div class="view-bando left  width-70">';
        echo '<div class="view-bando-inner">';
            echo '<h2>Bản đồ cây xăng, trạm xăng '.$currentMap['title'].'</h2>';
            $link_map = "http://maps.google.com/maps?ie=UTF8&fb=1&gl=vn&q=cây xăng&t=h&output=embed";
            $loc = "&ll=".$currentMap["latitude"].",".$currentMap["longitude"]."&spn=".$currentMap["spn"];
            $link_map = $link_map . $loc;
            
            echo '<div class="">'
                    .' <iframe src="'.$link_map.'" width="100%" height="500px;" frameborder="0"></iframe> '
                . '</div>';
        echo '</div>';
        echo '<div class="modules-bottom">';
            echo $tintuc;
        echo '</div>';
    echo '</div>';
echo '</div>';
    
$this->pageTitle = 'Bản đồ cây xăng, trạm xăng '.$currentMap['title'];
$this->metaKey = "bản đồ cây xăng, bản đồ cây xăng " . $currentMap['title'];
$this->metaDesc = "Bản đồ cây xăng trên mọi tỉnh thành trong cả nước, cây xăng hà nội, cây xăng tphcm, Bản đồ cây xăng ".$currentMap['title']." …";
 