<link type="text/css" href="<?php echo css_link('chat.css') ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo js_link('jquery-ui-1.8.23.custom.min.js') ?>"></script>
<link type="text/css" href="<?php echo css_link('jquery-ui-1.8.23.custom.css') ?>" rel="stylesheet" />
<script type='text/javascript' src='<?php echo js_link('clock.js') ?>'></script>
<script type='text/javascript'>
    var year = '<?php echo date('Y') ?>';
    var month = '<?php echo date('m') ?>';
    var day = '<?php echo date('d') ?>';
    var hours = '<?php echo date('H') ?>';
    var minutes = '<?php echo date('i') ?>';
    var seconds = '<?php echo date('s') ?>';
    var ngay='';
    var date = new Date(year,month-1,day,hours,minutes,seconds);
    var weekday=['Chủ Nhật','Thứ Hai','Thứ Ba','Thứ Tư','Thứ Năm','Thứ Sáu','Thứ Bảy'];
    clock();
    setTimeout('timesync(1800000)',1800000);
</script>
<script type='text/javascript' src='<?php echo js_link('xoso.js') ?>'></script>
<script type="text/javascript">
    //var uid='<?php //echo isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '' ?>';
    var year = '<?php echo date('Y') ?>';        
    var staticdir='<?php echo $uri_root ?>';
</script>
<script type='text/javascript' src='<?php echo js_link('swfobject.js') ?>'></script>    
<style type="text/css">
    .closebutton:link,.closebutton:visited,.closebutton:hover,.closebutton:active{position:absolute;top:3px;right:3px;z-index:3;display:inline-block;width:15px;height:15px;background:url('<?php echo $uri_root ?>public/client/images/close.png') no-repeat scroll 0 -16px transparent;overflow:hidden}
    .closebutton:hover{background-position:0 -32px}
    input[type="text"]{padding:2px;height:15px;line-height:15px;font-family:arial,sans-serif}
    input[type="submit"]{cursor:pointer;font-family:arial,sans-serif}
    .msg {
        background: none repeat scroll 0 0 #f8ffea;
        border: 1px solid #b4eb41;
        color: #434600;
        display: inline-block;
        margin: 5px 0;
        padding: 5px;
    }
    .deletebutton:link, .deletebutton:visited, .deletebutton:hover, .deletebutton:active {
        background: url("<?php echo $uri_root ?>public/client/images/delete.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
        display: inline-block;
        height: 20px;
        overflow: hidden;
        position: absolute;
        right: -5px;
        top: -5px;
        width: 20px;
        z-index: 3;
    }

    .bet{float:left; border:#cdcdcd 1px solid; background:#f2f2f2; margin:5px; padding:2px 4px; font-size:12px; font-weight:bold; color:#333; position:relative; z-index:0; cursor:default}
    .bet_hover{border-color:#FF9E46}
    .betnum{font-size:18px; font-weight:bold; color:#bc1c18;line-height:22px}
    .bet_value{font-size:12px; font-weight:bold; color:#7101AD}
    .hilight{background:#FFE3AA}
    .selected{background:#d5d5d5; border-color:#cdcdcd}
    .trung{background:#fded93}
    .trung .nhay{position:absolute; top:-5px; right:-3px; z-index:2; background:red; color:white; padding:0 3px 0 3px; font-size:12px}
    .tool{position:absolute; top:-5px; right:-3px; z-index:3}
    #lichsu{width:560px;height:550px; overflow:auto}
    .lichsu{margin:5px 25px 5px 5px; border-collapse:collapse;width:530px}
    .lichsu th,.lichsu td{border:#cdcdcd 1px solid; text-align:center; font-size:13px;padding:5px}
    .lichsu th{background:#d5d5d5; color:#333; font-size:12px}
    .lichsu_lastrow td{background:#E6E6E6; font-weight:bold}

    .tbl_dangtheo{ margin:5px 30px 5px 5px; border-collapse:collapse}
    .tbl_dangtheo th,.tbl_dangtheo td{text-align:center; font-size:13px; font-weight:bold; border:#A8BEDF 1px solid}
    .tbl_dangtheo th{background:#CADDF9; color:#12499C; font-size:12px}
    .tbl_dangtheo .num{font-size:16px; color:#AA0088}
    .tbl_dangtheo .diemhoa{color:#008000}

    .pos{color:#00A000}
    .neg{color:#EE0000}

    .betnum_ls:link{text-decoration:none; color:#710196 !important; font-size:13px; font-weight:bold}
    .betnum_ls:visited{text-decoration:none; color:#710196 !important; font-size:13px; font-weight:bold}
    .betnum_ls:active{text-decoration:none; color:#FFA722 !important; font-size:13px; font-weight:bold}
    .betnum_ls:hover{text-decoration:none; color:#E67800 !important; font-size:13px; font-weight:bold}
</style>
<script type='text/javascript' src='<?php echo js_link('bet.js') ?>'></script>
<script type='text/javascript'>
    var betlimit=2000;
    //var curruser='<?php //echo isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : '' ?>';
    var editrestrict=true;
    var ngaybet='<?php echo $date_loto ?>';
    var balance=0;
    var balancedate='';
    var diem=0;
    var diemthang=0;
    var tt=0;
    var nextday='<?php echo $nextday_loto ?>';
    loadImg("<?php echo img_link('delete.png') ?>");
    loadImg("<?php echo img_link('loading5.gif') ?>");
    loadImg("<?php echo img_link('loading6.gif') ?>");
</script>

<div class="col-left">
<div class="mod-module">
    
<?php if($c_module!='loto_online'){?>    
<div class="title-red title">
<div class="title-right"><span class="icon">Dự đoán Xổ Số​</span></div>
</div>
<div style="border:1px solid #e1e1e1;border-top:none;background:#f7f7f7;margin-bottom:5px">
<div class="hello"></div>
<div style="padding-top:5px;margin:5px;border-top:1px solid #e1e1e1">
<div style='margin:0 0 5px; font-size:14px; color:#013FA5'>Bạn thích cặp số nào hôm nay?</div>
<form id=betform name=betform action='' onsubmit='return betformsubmit()' style='font-size:13px; font-weight:bold; color:#353535; padding:3px; margin-bottom:5px'>
    <input type=hidden size=8 id=ngay name=ngay style='font-size:12px; color:#8B2001' value='<?php echo date('d/m/Y', strtotime($date_loto)) ?>' />
    <table style="border-spacing:2px">
        <tr>
            <td>Cặp số: </td>
            <td colspan="2"><input type=text size=10 name=range style='font-size:15px; font-weight:bold; color:#bc1c18;width:115px' title='Có thể nhập nhiều cặp số, cách nhau bằng dấu phẩy' /></td>
        </tr>
        <tr>
            <td>Số điểm: </td>
            <td><input type=text size=2 name=bet style='font-size:15px; font-weight:bold; color:#62018B' /></td>
            <td><input type=submit name='betsubmit' value='   Ghi   ' style='font-size:15px; font-weight:bold; color:#01468B;background-color: #b8100d;background-image: linear-gradient(to bottom, #b8100d, #960501);border: #980804 1px solid;color: #f1f4f8;font-weight:bold; font-size:12px;font-family:arial,sans-serif;height:23px;padding:0 10px;border-radius: 3px;-moz-border-radius: 3px;-webkit-border-radius: 3px' /></td>
        </tr>
    </table>
</form>
<div style='font-family:tahoma,arial; font-size:11px; color:#9D9D9D'>Bạn không cần phải nạp tiền vào tài khoản để ghi lotto <a id='loonlinenotetogger' href='#' onclick='' style='font-size:11px'>[Tìm hiểu thêm]</a></div>
<div id='loonlinenote' style='color:#414042; margin:5px 0; padding:5px; background:#eee; border-radius:5px; display:none'>Lotto Online tại Xoso.com là trò chơi miễn phí và <b>không cần nạp tiền</b>, nghĩa là bạn không cần phải có tiền trước trong tài khoản mà có thể ghi ngay tối đa 2000 điểm cho mỗi cặp số. Nếu thắng thì bạn sẽ nhận được điểm trong tài khoản, nếu thua tài khoản của bạn sẽ bị âm. Điểm trong tài khoản của bạn không có giá trị rút thành tiền thật. Bạn cũng không phải trả tiền khi tài khoản bị âm.<br>Người chơi có số điểm trong top 50 sẽ được vinh danh trên bảng vàng tại trang chủ. </div>
<script>
$('#loonlinenotetogger').click(function(){$('#loonlinenote').show(); return false});
closable('#loonlinenote');
</script>
<div id="loadbettb"></div>
<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function(){
            $(".hello").html('Xin chào:<br/><strong>'+curruser+'</strong>');
            if(uid!=''){
                $("#loadbettb").html('<div style="border-top:1px solid #e1e1e1;padding-top:2px;margin-top:5px;font-size:13px; color:#333; font-weight:bold; text-align:center; margin-bottom:5px">Tài khoản hiện có: <span id="taikhoanloto">0</span> k</div>'
                +'<div id="betarea" style="border:#cdcdcd 1px solid; display:none">'
                    +'<div>'
                        +'<a name="betplace"></a>'
                        +'<div style="display:none">'
                            +'Điểm:&nbsp;<span id="tongdiem" style="padding:3px; background:#616A89; color:white">--</span>'
                            +'Chi:&nbsp;<span id="tongchi" style="padding:3px; background:#616A89; color:white">--</span>'
                            +'Nhận:&nbsp;<span id="tongnhan" style="padding:3px; background:#0052CC; color:white">--</span>'
                            +'Lãi-lỗ:&nbsp;<span id="thangthua" style="padding:3px; background:#616A89; color:white">--</span>'
                        +'</div>'
                        +'<div style="clear:both"></div>'
                    +'</div>'
                    +'<div id="betcontainer"></div>'	
                    +'<div style="clear:both"></div>'
                +'</div>');
                betupdate(1);
                $("#taikhoanloto").html(taikhoan);
            }
        },1000); 
    });
</script>
</div>
<div style='clear:both'></div>
</div>
<?php }?>
<a style="display:block;margin-bottom:5px" href="<?php echo $uri_root?>giao-luu-thao-luan-chot-so-lotto.html"><img src="<?php echo img_link('dudoan.gif');?>" width="211" height="111" /></a>
<div class="title-red title">
<div class="title-right"><span class="icon">TƯỜNG THUẬT TRỰC TIẾP</span></div>
</div>
<ul class="category-provide">
<li><a href="<?php echo $uri_root?>tuong-thuat-truc-tiep-ket-qua-xo-so/mien-bac.html" title="Trực tiếp xổ số Miền Bắc"><span>Trực tiếp xổ số Miền Bắc</span></a></li>
<?php foreach($location_today['MT'] as $value){echo '<li><a href="'.$uri_root.'tuong-thuat-truc-tiep-ket-qua-xo-so/mien-trung.html" title="Trực tiếp xổ số '.$value->name.' - Xổ số Miền Trung"><span>Trực tiếp xổ số '.$value->name.'</span></a></li>';}foreach($location_today['MN'] as $value){echo '<li><a href="'.$uri_root.'tuong-thuat-truc-tiep-ket-qua-xo-so/mien-nam.html" title="Trực tiếp xổ số '.$value->name.' - Xổ số Miền Nam"><span>Trực tiếp xổ số '.$value->name.'</span></a></li>';}?>
</ul>
<div class="title-red title">
<div class="title-right"><span class="icon">Quay thưởng hôm qua</span></div>
</div>
<ul class="category-provide">
<li><a href="<?php echo $uri_root.$url_mienbac?>.html" title="Kết quả xổ số Miền Bắc"><span>Kết quả xổ số Miền Bắc</span></a></li>
<?php foreach($location_lastday['MT'] as $value){echo '<li><a href="'.$uri_root.$value->alias.'.html" title="Kết quả xổ số '.$value->name.' - Xổ số Miền Trung"><span>Kết quả xổ số '.$value->name.'</span></a></li>';}foreach($location_lastday['MN'] as $value){echo '<li><a href="'.$uri_root.$value->alias.'.html" title="Kết quả xổ số '.$value->name.' - Xổ số Miền Nam"><span>Kết quả xổ số '.$value->name.'</span></a></li>';}?>
</ul>
<div class="title-red title">
<div class="title-right"><span class="icon">Tiện ích</span></div>
</div>
<ul class="category-provide">
<li><a href="<?php echo $uri_root?>tao-ma-nhung/ket-qua-xo-so.html"><span>Chèn KQXS vào website của bạn</span></a></li>
<li><a href="<?php echo $uri_root?>demo/index.html"><span>Demo tạo mã nhúng KQXS</span></a></li>
<li><a href="<?php echo $uri_root?>lich-mo-thuong-xo-so.html"><span>Lịch mở thưởng</span></a></li>
<li><a href="<?php echo $uri_root?>giai-dap-giac-mo.html"><span>Giải đáp giấc mơ</span></a></li>
<li><a href="<?php echo $uri_root?>quay-so-may-man.html"><span>Quay số may mắn</span></a></li>
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