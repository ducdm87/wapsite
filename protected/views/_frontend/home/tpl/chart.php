<?php 
    global $mainframe;
    echo '<script src="https://www.google.com/jsapi"> </script>';
?>
<h2>Biểu đồ giá xăng dầu</h2>
<div class="bieudo-giaxang">
     <?php
     for($i=0;$i<count($bieudogia);$i++){
         $bieudo = $bieudogia[$i];
          $bieudo['html'] = preg_replace('/\{width\:\s*696/ism', "{width: 660", $bieudo['html']);
         ?>
            <div class="box-std box-bieudo">
                  <div class="box-title">
                    <h3 class="head"><?php echo $bieudo['title'] ?></h3>
                </div>
                <div class="inner">
                    <?php echo $bieudo['html']; ?>
                </div>
            </div>
         <?php
     }
     ?>
    <div class="box-std box-bieudo">
        <div class="box-title">
            <h3 class="head">Đồ thị Giá dầu ngọt nhẹ WTI trên sàn Nymex </h3>
        </div>
        <div class="inner bieudo1">
            <div class="hinh-anh">
                <img src="/images/xangdau/bieu-do-gia-dau-6m.png" />
            </div>
            <div class="bieudo-title">Biểu đồ giá dầu 6 tháng</div>
            <div class="chon-bieu-do">
                <select class="bieudo1">
                    <option value="/images/xangdau/bieu-do-gia-dau-7d.png" title="Biểu đồ giá dầu 7 ngày">7 ngày</option>
                    <option value="/images/xangdau/bieu-do-gia-dau-1m.png" title="Biểu đồ giá dầu 1 tháng">1 tháng</option>
                    <option value="/images/xangdau/bieu-do-gia-dau-3m.png" title="Biểu đồ giá dầu 3 tháng">3 tháng</option>
                    <option selected="" value="/images/xangdau/bieu-do-gia-dau-6m.png" title="Biểu đồ giá dầu 6 tháng">6 tháng</option>
                    <option value="/images/xangdau/bieu-do-gia-dau-1y.png" title="Biểu đồ giá dầu 1 năm">1 năm</option>
                    <option value="/images/xangdau/bieu-do-gia-dau-3y.png" title="Biểu đồ giá dầu 3 năm">3 năm</option>
                    <option value="/images/xangdau/bieu-do-gia-dau-5y.png" title="Biểu đồ giá dầu 5 năm">5 năm</option>
                    <option value="/images/xangdau/bieu-do-gia-dau-10y.png" title="Biểu đồ giá dầu 10 năm">10 năm</option>
                </select>
             </div>
        </div>
    </div>  
    <div class="box-std box-bieudo">
        <div class="box-title">
            <h3 class="head">Đồ thị giá dầu thô Brent trên sàn Nymex </h3>
        </div>
        <div class="inner bieudo2">
            <div class="hinh-anh">
                <img src="/images/xangdau/bieu-do-gia-dau-brent-6m.png" />
            </div>
            <div class="bieudo-title">Biểu đồ giá dầu brent 6 tháng</div>
            <div class="chon-bieu-do">
                <select class="bieudo2">
                   <option value="/images/xangdau/bieu-do-gia-dau-brent-7d.png" title="Biểu đồ giá dầu brent 7 ngày">7 ngày</option>
                   <option value="/images/xangdau/bieu-do-gia-dau-brent-1m.png" title="Biểu đồ giá dầu brent 1 tháng">1 tháng</option>
                   <option value="/images/xangdau/bieu-do-gia-dau-brent-3m.png" title="Biểu đồ giá dầu brent 3 tháng">3 tháng</option>
                   <option selected="" value="/images/xangdau/bieu-do-gia-dau-brent-6m.png" title="Biểu đồ giá dầu brent 6 tháng">6 tháng</option>
                   <option value="/images/xangdau/bieu-do-gia-dau-brent-1y.png" title="Biểu đồ giá dầu brent 1 năm">1 năm</option>
                   <option value="/images/xangdau/bieu-do-gia-dau-brent-3y.png" title="Biểu đồ giá dầu brent 3 năm">3 năm</option>
                   <option value="/images/xangdau/bieu-do-gia-dau-brent-5y.png" title="Biểu đồ giá dầu brent 5 năm">5 năm</option>
                   <option value="/images/xangdau/bieu-do-gia-dau-brent-10y.png" title="Biểu đồ giá dầu brent 10 năm">10 năm</option>
               </select>
            </div>
        </div>
    </div>  
</div>

 