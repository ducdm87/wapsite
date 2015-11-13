<div class="footer-wrap">
<div class="footer">
<?php if($meta_refresh_mb==true && $meta_refresh_mt==true && $meta_refresh_mn==true){?>
<div class="facebook_block">
<div>
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Ftoiyeuxoso&amp;width=990&amp;colorscheme=light&amp;show_faces=true&amp;stream=false&amp;header=true&amp;height=324" scrolling="no" frameborder="0" style="border:0;overflow:hidden;width:990px;height:324px" allowTransparency="true"></iframe>
</div>
<div class="fanpage_block">
Đây là Fanpage <a href="https://www.facebook.com/toiyeuxoso">xoso.com</a> Nếu không vào được <a href="http://cachvaofacebook.com">Facebook</a> mời bạn xem <a href="http://cachvaofacebook.com/cach-vao-facebook-moi-nhat.html"> Cách vào facebook</a> nhé!
</div>
</div>
<?php }?>
<div class="fooer-top clearfix">
<ul class="nav-footer left">
<li class="nav-fhome"><a href="<?php echo $uri_root?>">Trang chủ</a></li>
<li><a href="<?php echo $uri_root?>tuong-thuat-truc-tiep-ket-qua-xo-so.html">Tường thuật trực tiếp</a></li>
<li><a href="<?php echo $uri_root?>ket-qua.html">Kết quả</a></li>
<li><a href="<?php echo $uri_root?>xo-so-mien-bac.html">Xổ số miền Bắc</a></li>
<li><a href="<?php echo $uri_root?>xo-so-tp-ho-chi-minh.html">Xổ số Tp.HCM</a></li>
<li><a href="<?php echo $uri_root?>thong-ke-quan-trong.html">Thống kê quan trọng</a></li>
<li><a href="<?php echo $uri_root?>thongke-cau-xo-so.html">Thống kê Cầu Loto</a></li>
</ul>
<a href="#top" class="backtop">backtop</a>
</div>
<?php $banner_f='';foreach($banner as $v){if($v->position=='bottom'&&($v->page=='all'||$v->page==$c_module)){$banner_f.='<div><a target="_blank" href="'.$v->url.'" title="'.view_title($v->name).'"><img src="'.site_url($v->image).'" alt="'.view_title($v->name).'" /></a></div>';}}if($banner_f!='')echo '<div class="footer-cen"><div class="mod-banner-bottom">'.$banner_f.'</div></div>';?>
<div class="footer-bot clearfix">
Thông tin chỉ mang tính tham khảo, chúng tôi sẽ không chịu bất kỳ trách nhiệm gì về việc sử dụng thông tin của các bạn.<br />
Theo nguồn từ các công ty xổ số trên toàn quốc<br />
© 2012 <a href="<?php echo $uri_root?>">xổ số</a>, All rights reserved. <span id="mobilev"></span>
</div>
</div>
</div>
<?php $banner_f='';foreach($banner as $v){if($banner_f==''&&$v->position=='bottom_right'&&($v->page=='all'||$v->page==$c_module)){$banner_f='<a target="_blank" href="'.$v->url.'" title="'.view_title($v->name).'"><img style="width: 260px;" src="'.site_url($v->image).'" alt="'.view_title($v->name).'" /></a>';}}if($banner_f!=''){?>
<div style="height:160px" id="right_float">
<div id="right_float1">
<div id="right_float2">
<div id="right_float3">
<ul id="right_float_ul">
<li id="right_float_hide"><a class="min" href="#" onClick="right_float_clickhide()" title="Ẩn đi">Ẩn</a></li>
<li id="right_float_show" style="display:none"><a class="max" href="#" onClick="right_float_clickshow()" title="Hiện lại">Xem</a></li>
<li id="right_float_close"><a class="close" href="#" onClick="right_float_clickclose()" title="Đóng lại">Đóng</a></li>
</ul>
</div>
<div id="right_float_banner">
<table align=center cellpadding="0" width=100% cellspacing="0" border="0">
<tr>
<td align=center>
<?php echo $banner_f?>
</td>
</tr>
</table>
</div>
</div>
</div>
</div>
<script type="text/javascript">right_float_bottomLayer=document.getElementById("right_float");var right_float_IntervalId=0;var right_float_maxHeight=252;var right_float_minHeight=16;var right_float_curHeight=0;function right_float_show(){right_float_curHeight=right_float_maxHeight;clearInterval(right_float_IntervalId);right_float_bottomLayer.style.height=right_float_curHeight+"px"}function right_float_hide(){right_float_curHeight=right_float_minHeight;clearInterval(right_float_IntervalId);right_float_bottomLayer.style.height=right_float_curHeight+"px"}right_float_IntervalId=setInterval("right_float_show()",5);function right_float_clickhide(){document.getElementById("right_float_hide").style.display="none";document.getElementById("right_float_show").style.display="inline";right_float_IntervalId=setInterval("right_float_hide()",5);return false}function right_float_clickshow(){document.getElementById("right_float_hide").style.display="inline";document.getElementById("right_float_show").style.display="none";right_float_IntervalId=setInterval("right_float_show()",5);return false}function right_float_clickclose(){document.body.style.marginBottom="0px";right_float_bottomLayer.style.display="none";return false};</script>
<?php }?>