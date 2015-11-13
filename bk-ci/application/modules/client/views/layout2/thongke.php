<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $_meta['description']?>" />
<meta name="keywords" content="<?php echo $_meta['keywords']?>" />
<title><?php echo $_meta['title']?></title>
<meta property="og:image" content="<?php echo img_link('logo.png')?>" />
<?php if($meta_refresh_mb==true && $meta_refresh_mt==true && $meta_refresh_mn==true){?>
<meta http-equiv="refresh" content="900" />
<?php }?>
<link type="image/x-icon" href="<?php echo img_link('favicon.ico')?>" rel="shortcut icon" />
<link type="text/css" rel="stylesheet" href="<?php echo $uri_root?>min/g=css1411" />
<script type="text/javascript" src="<?php echo $uri_root?>min/g=js1411"></script>
<meta name="google-site-verification" content="_MdXAARqGNM7C1GRrfqgrQg59dJuCGxL_3E4tJf_se0" />
<script type="text/javascript">/*<![CDATA[*/var uri_root="<?php echo $uri_root?>";function loadtinhright(){var a=$("#f_rangeStart_right").val();if(a==""){alert("Vui lòng nhập ngày mở thưởng trên tờ vé !");document.form_doveso_right.ngay.focus();return false}$.ajax({type:"GET",url:"<?php echo $uri_root?>loadtinhs/<?php echo $lid_right?>/"+a,success:function(b){$("#boxCity_right").html(b);$("#select_provide").selectbox()}})}$(document).ready(function(a){loadtinhright()});function dovesoright(){if($("#so_right").val()==""){alert("Nhập đủ dãy số dự thưởng trên tờ vé của bạn! (6 số hoặc 5 số không bao gồm ký tự)");document.form_doveso_right.so.focus();return false}else{if($("#so_right").val().length<5){alert("Nhập đủ dãy số dự thưởng trên tờ vé của bạn! (6 số hoặc 5 số không bao gồm ký tự)");document.form_doveso_right.so.focus();return false}else{if($("#f_rangeStart_right").val()==""){alert("Vui lòng nhập ngày mở thưởng trên tờ vé !");document.form_doveso_right.ngay.focus();return false}else{document.form_doveso_right.submit()}}}}var googletag=googletag||{};googletag.cmd=googletag.cmd||[];(function(){var a=document.createElement("script");a.async=true;a.type="text/javascript";var c="https:"==document.location.protocol;a.src=(c?"https:":"http:")+"//www.googletagservices.com/tag/js/gpt.js";var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)})();googletag.cmd.push(function(){googletag.defineSlot("/35883025/xs_top",[970,90],"div-gpt-ad-1378288615889-0").addService(googletag.pubads());googletag.defineSlot("/35883025/xs_b1",[336,280],"div-gpt-ad-1378288615889-1").addService(googletag.pubads());googletag.defineSlot('/35883025/xs_right', [200,600], 'div-gpt-ad-1378288615889-2').addService(googletag.pubads());googletag.pubads().enableSingleRequest();googletag.enableServices()});/*]]>*/</script>
<?php if($c_module=='xoso'&&$c_func=='filter_date'&&isset($items[0])){$shared_content='Xổ Số '.$items[0]->name.' ngày '.$date.',';$shared_content.=' giải DB: '.$items[0]->a0.',';$shared_content.=' giải nhất: '.$items[0]->a1.',';$shared_content.=' giải nhì: '.$items[0]->a2.',';$shared_content.=' giải ba: '.$items[0]->a3.',';$shared_content.=' giải tư: '.$items[0]->a4.',';$shared_content.=' giải năm: '.$items[0]->a5.',';$shared_content.=' giải sáu: '.$items[0]->a6.',';$shared_content.=' giải bảy: '.$items[0]->a7;if($items[0]->area!='MB')$shared_content.=', giải tám: '.$items[0]->a8;echo '<meta property="og:description" content="'.$shared_content.'" />';}?>
</head>
<body>
<div id="wrapper">
<?php $this->load->view($layout_header)?>
<div class="content-wrap">
<div class="content">
<div class="main clearfix">
<?php $this->load->view($layout_col_left)?>
<div class="col-main">
<div class="col-content">
<?php 
//$tttt_mb = true;
//$tttt_mt = true;
//$tttt_mn = true;
if ($tttt_mb || $tttt_mt || $tttt_mn) {
    echo '<script type="text/javascript" src="' . js_link('jquery-blink.js') . '"></script>';
    if ($tttt_mb) {
        echo '<div class="tttt_link"><a class="tttt_blink" href="' . $uri_root . 'tuong-thuat-truc-tiep-ket-qua-xo-so/mien-bac.html">Tường thuật trực tiếp Xổ Số Miền Bắc</a></div>';
    } elseif ($tttt_mt) {
        echo '<div class="tttt_link"><a class="tttt_blink" href="' . $uri_root . 'tuong-thuat-truc-tiep-ket-qua-xo-so/mien-trung.html">Tường thuật trực tiếp Xổ Số Miền Trung</a></div>';
    } else {
        echo '<div class="tttt_link"><a class="tttt_blink" href="' . $uri_root . 'tuong-thuat-truc-tiep-ket-qua-xo-so/mien-nam.html">Tường thuật trực tiếp Xổ Số Miền Nam</a></div>';
    }
    echo "<script type=\"text/javascript\">$(document).ready(function() { $('.tttt_blink').blink({delay:100});});</script>";
}
$this->load->view($tmpl);
?>
<br/>
</div>
<div class="col-right">
<div class="mod-module">
<div id='div-gpt-ad-1378288615889-2' style='width:200px;'>
<script type='text/javascript'>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1378288615889-2'); });
</script>
</div>
</div>
<div class="mod-module">
<div class="mod-banner-right">
<?php foreach($banner as $v){if($v->position=='right'&&($v->page=='all'||$v->page==$c_module)){?>
<div><a target="_blank" href="<?php echo $v->url;?>" title="<?php echo view_title($v->name);?>"><img src="<?php echo site_url($v->image);?>" width="200" alt="<?php echo view_title($v->name);?>" /></a></div>
<?php }}?>
</div>
</div>
<div class="mod-module">
<div class="title-red title">
<div class="title-right"><span class="icon">Soi cầu loto hôm nay</span></div>
</div>
<ul class="category-provide">
<li><a title="Soi cầu loto Miền Bắc" href="<?php echo $uri_root ?>thongke-cau-bach-thu-mien-bac.html"><span>Soi cầu loto Miền Bắc</span></a></li>
<?php
foreach ($location_today['MT'] as $value)
    echo '<li><a title="Soi cầu loto ' . $value->name . '" href="' . $uri_root . 'thongke-cau-' . $value->alias . '.html">Soi cầu loto ' . $value->name . '</a></li>';
foreach ($location_today['MN'] as $value)
    echo '<li><a title="Soi cầu loto ' . $value->name . '" href="' . $uri_root . 'thongke-cau-' . $value->alias . '.html">Soi cầu loto ' . $value->name . '</a></li>';
?>
</ul>

<div class="title-red title">
<div class="title-right"><span class="icon">Dự đoán xổ số hôm nay</span></div>
</div>
<ul class="category-provide">
<li><a href="<?php echo $uri_root?>du-doan-xo-so-mien-bac.html" title="Dự đoán xổ số Miền Bắc"><span>Dự đoán xổ số Miền Bắc</span></a></li>
<?php 
$idmt=array();
foreach($location_today['MT'] as $value){
$idmt[]=$value->id;
echo '<li><a href="'.$uri_root.'du-doan-'.$value->alias.'.html" title="Dự đoán xổ số '.$value->name.' - Xổ số Miền Trung"><span>Dự đoán xổ số '.$value->name.'</span></a></li>';
}
foreach($location_menu['MT'] as $value){
if(!in_array($value->id, $idmt)){
echo '<li class="dudoan_mt" style="display:none"><a href="'.$uri_root.'du-doan-'.$value->alias.'.html" title="Dự đoán xổ số '.$value->name.' - Xổ số Miền Trung"><span>Dự đoán xổ số '.$value->name.'</span></a></li>';
}
}
echo '<li><a href="javascript:;" onclick="showPopup(\'.dudoan_mt\')" title="" rel="nofollow">Dự đoán các tỉnh <strong class="cl-green">Miền Trung</strong></a></li>';
$idmn=array();
foreach($location_today['MN'] as $value){
$idmn[]=$value->id;
echo '<li><a href="'.$uri_root.'du-doan-'.$value->alias.'.html" title="Dự đoán xổ số '.$value->name.' - Xổ số Miền Nam"><span>Dự đoán xổ số '.$value->name.'</span></a></li>';
}
foreach($location_menu['MN'] as $value){
if(!in_array($value->id, $idmn)){
echo '<li class="dudoan_mn" style="display:none"><a href="'.$uri_root.'du-doan-'.$value->alias.'.html" title="Dự đoán xổ số '.$value->name.' - Xổ số Miền Trung"><span>Dự đoán xổ số '.$value->name.'</span></a></li>';
}
}
echo '<li><a href="javascript:;" onclick="showPopup(\'.dudoan_mn\')" title="" rel="nofollow">Dự đoán các tỉnh <strong class="cl-green">Miền Nam</strong></a></li>';
?>
</ul>

<div class="title-red title">
<div class="title-right"><span class="icon font11">Soi cầu đặc biệt hôm nay</span></div>
</div>
<ul class="category-provide">
<li><a title="Soi cầu đặc biệt Miền Bắc" href="<?php echo $uri_root ?>thongke-cau-bach-thu-mien-bac.html?t=1"><span>Soi cầu đặc biệt Miền Bắc</span></a></li>
<?php
foreach ($location_today['MT'] as $value){
    $name = $value->name;
    if($value->name == 'Thừa Thiên Huế')
        $name = 'TTH';
    echo '<li><a title="Soi cầu đặc biệt ' . $value->name . '" href="' . $uri_root . 'thongke-cau-' . $value->alias . '.html?t=1">Soi cầu đặc biệt ' . $name . '</a></li>';
}
foreach ($location_today['MN'] as $value){
    $name = $value->name;
    if($value->name == 'Tp. Hồ Chí Minh')
        $name = 'Tp. HCM';
    echo '<li><a title="Soi cầu đặc biệt ' . $value->name . '" href="' . $uri_root . 'thongke-cau-' . $value->alias . '.html?t=1">Soi cầu đặc biệt ' . $name . '</a></li>';
}
?>
</ul>

<div class="title title-yelow"><div class="title-right"><span class="icon">Các dự đoán hiệu quả</span></div></div>
<ul class="category-provide">
<?php
foreach ($xs_lotonuoi as $value)
    echo '<li><a title="'.$value->title.'" href="' . $uri_root . 'du-doan/' . $value->title_link . '.html">'.$value->title.'</a></li>';
?>
</ul>

<div class="title title-yelow"><div class="title-right"><span class="icon">Kinh nghiệm nuôi lô</span></div></div>
<ul class="category-provide">
<?php
foreach ($xs_kinhnghiem as $value)
    echo '<li><a title="'.$value->title.'" href="' . $uri_root . 'kinh-nghiem/' . $value->title_link . '.html">'.$value->title.'</a></li>';
?>
</ul>

</div>
<div class="mod-module">
<form id="form_doveso_right" name="form_doveso_right" method="get" action="<?php echo $uri_root?>do-ve-so.html">
<div class="title title-yelow"><div class="title-right"><span class="icon">DÒ VÉ SỐ ONLINE</span></div></div>
<div class="box-online">
<div class="rows clearfix">
<label>Ngày</label>
<div class="input-box">
<input type="text" id="f_rangeStart_right" name="ngay" class="input-date" value="<?php echo $fromdate_right?>" />
</div>
</div>
<div class="rows clearfix">
<label>Vé số</label>
<div class="input-box"><input type="text" id="so_right" name="so" value="<?php echo $so_right?>" maxlength="6" /></div>
</div>
<div class="rows clearfix">
<label>Tỉnh</label>
<div class="input-box">
<div class="left" id="boxCity_right"></div>
</div>
</div>
<div class="rows clearfix">
<label>&nbsp;</label>
<div class="input-box space">
<button type="button" class="button" onclick="return dovesoright()"><span><span>Dò kết quả</span></span></button>
</div>
</div>
</div>
</form>
</div>
<div class="mod-module">
<div class="title title-yelow"><div class="title-right"><span class="icon">XỔ SỐ HÔM NAY</span></div></div>
<div class="mod-content-date">
<?php if(!isset($alias)||$alias==''){$alias='ket-qua';}$date_time=date('Ymd',time());if(isset($date)&&$date!=''){$date_time=date('Ymd',strtotime($date));}?>
<div id="calendar-container"></div>
</div>
</div>
<div class="mod-module">
<div class="title title-yelow"><div class="title-right"><span class="icon">TIN MỚI</span></div></div>
<ul class="category-provide category-news">
<?php foreach($lastnews as $k=>$row){?>
<li><a class="font11" href="<?php echo news_link($row->title_link);?>" title="<?php echo view_title($row->title)?>"><?php echo short_text($row->title,35)?></a></li>
<?php }?>
</ul>
</div>
<div class="mod-module">
<div class="mod-banner-right">
<?php foreach($banner as $v){if($v->position=='bottom_new'&&($v->page=='all'||$v->page==$c_module)){?>
<div><a target="_blank" href="<?php echo $v->url;?>" title="<?php echo view_title($v->name);?>"><img src="<?php echo site_url($v->image);?>" width="200" alt="<?php echo view_title($v->name);?>" /></a></div>
<?php }}?>
</div>
</div>
<div class="mod-module">
<div class="title title-yelow"><div class="title-right"><span class="icon">Mã Tỉnh / Thành Phố</span></div></div>
<div class="title-provide">MIỀN BẮC</div>
<ul class="category-provide list-provide">
<li class="clearfix"><span class="span-bna">MB</span><a href="<?php echo $uri_root.$url_mienbac?>.html">Xổ số Miền Bắc</a></li>
</ul>
<div class="title-provide">MIỀN TRUNG</div>
<ul class="category-provide list-provide">
<?php foreach($location_menu['MT'] as $value){echo '<li class="clearfix"><span class="span-bna">'.$value->code.'</span><a href="'.$uri_root.$value->alias.'.html">Xổ số '.$value->name.'</a></li>';}?>
</ul>
<div class="title-provide">MIỀN NAM</div>
<ul class="category-provide list-provide">
<?php foreach($location_menu['MN'] as $value){echo '<li class="clearfix"><span class="span-bna">'.$value->code.'</span><a href="'.$uri_root.$value->alias.'.html">Xổ số '.$value->name.'</a></li>';}?>
</ul>
</div>
<div class="mod-module footer-cen">
<?php foreach($xs_keyword as $v)echo $v->name;?>
</div>
</div>
</div>
</div>
</div>
</div>
<?php $this->load->view($layout_footer)?>
</div>
<script type="text/javascript">/*<![CDATA[*/var LEFT_CAL=Calendarc.setup({cont:"calendar-container",max:<?php echo date('Ymd',time())?>,date:<?php echo $date_time?>,selectionType:Calendarc.SEL_SINGLE,showTime:12,onSelect:function(c){var b=c.selection.get();if(b){b=Calendarc.intToDate(b);var a=Calendarc.printDate(b,"%d-%m-%Y");window.location.href="<?php echo $uri_root.$alias?>/"+a+".html"}}});$(function(){$("#select_provide").selectbox()});$("#f_rangeStart_right").datepick({dateFormat:"dd-mm-yyyy",maxDate:+0,onSelect:function(){loadtinhright()}});/*]]>*/</script>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-31260907-1', 'xoso.com');
ga('require', 'displayfeatures');
ga('send', 'pageview');
</script>
</body>
</html>