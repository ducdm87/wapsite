<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo(isset($_meta['description'])?$_meta['description']:'');?>" />
<meta name="keywords" content="<?php echo(isset($_meta['keywords'])?$_meta['keywords']:'');?>" />
<title><?php echo(isset($_meta['title'])?$_meta['title']:'');?></title>
<meta http-equiv="refresh" content="900" />
<link type="image/x-icon" href="<?php echo img_link('favicon.ico');?>" rel="shortcut icon" />
<link type="text/css" rel="stylesheet" href="<?php echo $uri_root?>min/g=cssc1411" />
<script type="text/javascript" src="<?php echo $uri_root?>min/g=jsc1411"></script>
<script type="text/javascript">/*<![CDATA[*/var uri_root="<?php echo $uri_root?>";/*]]>*/</script>
<meta name="google-site-verification" content="_MdXAARqGNM7C1GRrfqgrQg59dJuCGxL_3E4tJf_se0" />
<script type="text/javascript">var googletag=googletag||{};googletag.cmd=googletag.cmd||[];(function(){var a=document.createElement("script");a.async=true;a.type="text/javascript";var c="https:"==document.location.protocol;a.src=(c?"https:":"http:")+"//www.googletagservices.com/tag/js/gpt.js";var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)})();googletag.cmd.push(function(){googletag.defineSlot("/35883025/xs_top",[970,90],"div-gpt-ad-1378288615889-0").addService(googletag.pubads());googletag.defineSlot("/35883025/xs_b1",[336,280],"div-gpt-ad-1378288615889-1").addService(googletag.pubads());googletag.pubads().enableSingleRequest();googletag.enableServices()});</script>
</head>
<body>
<div id="wrapper">
<?php $this->load->view($layout_header)?>
<div class="content-wrap">
<div class="content">
<div class="main clearfix">
<?php $this->load->view($layout_col_left)?>
<div class="col-main">
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
</div>
</div>
</div>
</div>
<?php $this->load->view($layout_footer)?>
</div>
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