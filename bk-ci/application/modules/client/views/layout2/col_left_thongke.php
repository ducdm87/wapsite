<div class="col-left">
<div class="mod-module">
<div class="title-red title">
<div class="title-right"><span class="icon">TƯỜNG THUẬT TRỰC TIẾP</span></div>
</div>
<ul class="category-provide">
<li><a href="<?php echo $uri_root?>tuong-thuat-truc-tiep-ket-qua-xo-so/mien-bac.html" title="Trực tiếp xổ số Miền Bắc"><span>Trực tiếp xổ số Miền Bắc</span></a></li>
<?php foreach($location_today['MT'] as $value){echo '<li><a href="'.$uri_root.'tuong-thuat-truc-tiep-ket-qua-xo-so/mien-trung.html" title="Trực tiếp xổ số '.$value->name.' - Xổ số Miền Trung"><span>Trực tiếp xổ số '.$value->name.'</span></a></li>';}foreach($location_today['MN'] as $value){echo '<li><a href="'.$uri_root.'tuong-thuat-truc-tiep-ket-qua-xo-so/mien-nam.html" title="Trực tiếp xổ số '.$value->name.' - Xổ số Miền Nam"><span>Trực tiếp xổ số '.$value->name.'</span></a></li>';}?>
</ul>

<div class="title title-yelow"><div class="title-right"><span class="icon">THỐNG KÊ XỔ SỐ</span></div></div>
<ul class="category-provide">
<li><a href="<?php echo $uri_root?>thongke-dau-duoi-0-9.html"><span>Thống kê đầu, đuôi</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-tong-chan.html"><span>Thống kê theo tổng chẵn</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-tong-le.html"><span>Thống kê theo tổng lẻ</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-theo-tong-0-9.html"><span>Thống kê tổng 2 số cuối</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-cap-so-tu-00-99.html"><span>Thống kê 00 - 99</span></a></li>
</ul>
<div class="title title-yelow"><div class="title-right"><span class="icon">THỐNG KÊ VIP</span></div></div>
<ul class="category-provide">
<li><a href="<?php echo $uri_root?>thong-ke-xo-so-hom-nay.html"><span>Thống kê xổ số hôm nay</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-vip-xo-so-3-mien.html"><span>Thống kê VIP xổ số 3 miền</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-so-dep-tu-cac-dien-dan-xo-so.html"><span>Số đẹp từ các diễn đàn xổ số</span></a></li>
<li><a target="_blank" href="<?php echo $uri_root?>thong-ke-tan-suat-loto.html"><span>Thông kê tần suất Loto</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-quan-trong.html"><span>Thống kê quan trọng</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-theo-bo-so.html"><span>Thống kê theo bộ số</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-lo-to-tinh.html"><span>Thống kê Loto nhanh</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-lo-gan.html"><span>Thống kê Loto gan</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-lo-to-theo-dau-duoi.html"><span>Thống kê Loto theo đầu/đuôi</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-lo-to-theo-tong.html"><span>Thống kê theo tổng</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-theo-chu-ky.html"><span>Thống kê theo chu kỳ</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-giai-dac-biet-theo-tuan.html"><span>Thống kê giải ĐB theo tuần</span></a></li>
<li><a href="<?php echo $uri_root?>thong-ke-giai-dac-biet-theo-thang.html"><span>Thống kê giải ĐB theo tháng</span></a></li>
</ul>
<div class="title title-yelow"><div class="title-right"><span class="icon">THỐNG KÊ CẦU</span></div></div>
<ul class="category-provide">
<li><a href="<?php echo $uri_root?>thongke-cau-xo-so.html"><span>Thống kê Cầu Loto</span></a></li>
<li><a href="<?php echo $uri_root?>thongke-cau-bach-thu-mien-bac.html"><span>Thống kê Cầu bạch thủ</span></a></li>
</ul>
    
<div class="title title-yelow"><div class="title-right"><span class="icon"><a href="<?php echo $uri_root.$url_mienbac?>.html">XỔ SỐ MIỀN BẮC</a></span></div></div>
<ul class="category-provide">
<li><a href="<?php echo $uri_root.$url_mienbac?>.html" title="Kết quả xổ số Miền Bắc">Kết quả xổ số Miền Bắc</a></li>
</ul>
<div class="title title-yelow"><div class="title-right"><span class="icon"><a href="<?php echo $uri_root.$url_mientrung?>.html">XỔ SỐ MIỀN TRUNG</a></span></div></div>
<ul class="category-provide">
<?php foreach($location_menu['MT'] as $value){echo '<li><a href="'.$uri_root.$value->alias.'.html" title="Kết quả xổ số '.$value->name.' - Xổ số Miền Trung"><span>Kết quả xổ số '.$value->name.'</span></a></li>';}?>
</ul>
<div class="title title-yelow"><div class="title-right"><span class="icon"><a href="<?php echo $uri_root.$url_miennam?>.html">XỔ SỐ MIỀN NAM</a></span></div></div>
<ul class="category-provide">
<?php foreach($location_menu['MN'] as $value){echo '<li><a href="'.$uri_root.$value->alias.'.html" title="Kết quả xổ số '.$value->name.' - Xổ số Miền Nam"><span>Kết quả xổ số '.$value->name.'</span></a></li>';}?>
</ul>
</div>
<div class="mod-module">
<div class="mod-banner-left">
<?php foreach($banner as $v){if($v->position=='left'&&($v->page=='all'||$v->page==$c_module)){?>
<div><a target="_blank" href="<?php echo $v->url;?>" title="<?php echo view_title($v->name);?>"><img src="<?php echo site_url($v->image);?>" width="211" alt="<?php echo view_title($v->name);?>" /></a></div>
<?php }}?>
</div>
</div>
</div>