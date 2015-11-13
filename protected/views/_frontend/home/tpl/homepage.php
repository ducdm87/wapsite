<?php 
    global $mainframe;
?>
<h2>Giá xăng dầu hôm nay</h2>
<div class="box-std">
    <div class="box-title">
        <h3 class="head">Giá bán lẻ xăng dầu</h3>
    </div>
    <div class="inner">
        <div class="head">
            <div class="col col-1">Sản phẩm</div>
            <div class="col col-2">Vùng 1</div>
            <div class="col col-3">Vùng 2</div>
        </div>
        <div class="rows">
            <?php 
                if(isset($giabanle) AND count($giabanle) > 0){
                    foreach ($giabanle as $row) {
                        ?>
                            <div class="row">
                                <div class="col col-1"><?php echo $row['title']; ?></div>
                                <div class="col col-2"><?php echo $mainframe->stdMoney($row['giavung1']); ?></div>
                                <div class="col col-3"><?php echo $mainframe->stdMoney($row['giavung2']); ?></div>
                            </div>
                        <?php
                    }
                }
            ?>
        </div>
    </div>
</div>


<div class="box-std gia-the-gioi">
    <div class="box-title">
        <h3 class="head">Giá xăng dầu thế giới</h3>
    </div>
    <div class="inner">
        <div class="head">
            <div class="col col-1">Sản phẩm</div>
            <div class="col col-2">Code</div>
            <div class="col col-3">Giá</div>
            <div class="col col-4">Thay đổi</div>
            <div class="col col-5">Mở cửa</div>
            <div class="col col-6">Cao</div>
            <div class="col col-7">Thấp</div>
        </div>
        <div class="rows">
            <?php 
                if(isset($giathegioi) AND count($giathegioi) > 0){
                    foreach ($giathegioi as $row) {
                        ?>
                            <div class="row">
                                <div class="col col-1"><?php echo $row['title']; ?></div>
                                <div class="col col-2"><?php echo $row['code']; ?></div>
                                <div class="col col-3"><?php echo $row['price']; ?></div>
                                <div class="col col-4"><?php echo $row['change']; ?></div>
                                <div class="col col-5"><?php echo $row['open']; ?></div>
                                <div class="col col-6"><?php echo $row['high']; ?></div>
                                <div class="col col-7"><?php echo $row['low']; ?></div>
                            </div>
                        <?php
                    }
                }
            ?>
        </div>
    </div>
</div>


<div class="box-std box-gia-co-so">
    <div class="box-title">
        <h3 class="head">Giá cơ sở hàng ngày</h3>
    </div>
    <div class="inner">
        <img src="/images/xangdau/gia-co-so-hang-ngay.png" />
    </div>
</div>

<div class="modules-bottom"> 
    <?php echo $tintuc; ?>
</div>