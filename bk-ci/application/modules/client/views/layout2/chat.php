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
<script type="text/javascript">/*<![CDATA[*/var uri_root="<?php echo $uri_root?>";var googletag=googletag||{};googletag.cmd=googletag.cmd||[];(function(){var a=document.createElement("script");a.async=true;a.type="text/javascript";var c="https:"==document.location.protocol;a.src=(c?"https:":"http:")+"//www.googletagservices.com/tag/js/gpt.js";var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)})();googletag.cmd.push(function(){googletag.defineSlot("/35883025/xs_top",[970,90],"div-gpt-ad-1378288615889-0").addService(googletag.pubads());googletag.defineSlot("/35883025/xs_b1",[336,280],"div-gpt-ad-1378288615889-1").addService(googletag.pubads());googletag.defineSlot('/35883025/xs_right', [200,600], 'div-gpt-ad-1378288615889-2').addService(googletag.pubads());googletag.pubads().enableSingleRequest();googletag.enableServices()});/*]]>*/</script>
<?php if($c_module=='xoso'&&$c_func=='filter_date'&&isset($items[0])){$shared_content='Xổ Số '.$items[0]->name.' ngày '.$date.',';$shared_content.=' giải DB: '.$items[0]->a0.',';$shared_content.=' giải nhất: '.$items[0]->a1.',';$shared_content.=' giải nhì: '.$items[0]->a2.',';$shared_content.=' giải ba: '.$items[0]->a3.',';$shared_content.=' giải tư: '.$items[0]->a4.',';$shared_content.=' giải năm: '.$items[0]->a5.',';$shared_content.=' giải sáu: '.$items[0]->a6.',';$shared_content.=' giải bảy: '.$items[0]->a7;if($items[0]->area!='MB')$shared_content.=', giải tám: '.$items[0]->a8;echo '<meta property="og:description" content="'.$shared_content.'" />';}?>
</head>
<body>
<div id="wrapper">
<?php $this->load->view($layout_header)?>
<div class="content-wrap">
<div class="content">
<div class="main clearfix">
    
<style type="text/css">.group-col-lr{font-family: arial,sans-serif;font-size: 12px;float:left;width:414px}</style>
<div class="group-col-lr">
<div class="col-right" style="float:left">
<div class="mod-module">
<div class="mod-banner-right">
<?php foreach($banner as $v){if($v->position=='right'&&($v->page=='all'||$v->page==$c_module)){?>
<div><a target="_blank" href="<?php echo $v->url;?>" title="<?php echo view_title($v->name);?>"><img src="<?php echo site_url($v->image);?>" width="200" alt="<?php echo view_title($v->name);?>" /></a></div>
<?php }}?>
</div>
</div>
</div>

<div class="col-left" style="float:right">
<div class="mod-module">
<div class="title-red title">
<div class="title-right"><span class="icon">TƯỜNG THUẬT TRỰC TIẾP</span></div>
</div>
<ul class="category-provide">
<li><a href="<?php echo $uri_root?>tuong-thuat-truc-tiep-ket-qua-xo-so/mien-bac.html" title="Trực tiếp xổ số Miền Bắc"><span>Trực tiếp xổ số Miền Bắc</span></a></li>
<?php foreach($location_today['MT'] as $value){echo '<li><a href="'.$uri_root.'tuong-thuat-truc-tiep-ket-qua-xo-so/mien-trung.html" title="Trực tiếp xổ số '.$value->name.' - Xổ số Miền Trung"><span>Trực tiếp xổ số '.$value->name.'</span></a></li>';}foreach($location_today['MN'] as $value){echo '<li><a href="'.$uri_root.'tuong-thuat-truc-tiep-ket-qua-xo-so/mien-nam.html" title="Trực tiếp xổ số '.$value->name.' - Xổ số Miền Nam"><span>Trực tiếp xổ số '.$value->name.'</span></a></li>';}?>
</ul>
</div>
</div>
    
<div style="clear:both"></div>
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

<div class=topbox>
    <div class="contentbox_header" style='background: url("<?php echo $uri_root ?>public/client/images/box_top_bg.gif") repeat-x scroll 0 0 rgba(0, 0, 0, 0);height:38px;line-height:38px;margin:0 1px;position:relative'>
        <span class=coins>&nbsp;</span> <span style='text-shadow:1px 1px #bfbfbf; color:#ab1714;position:absolute; bottom:0; left:30px; display:inline-block; font-weight:bold'>Bảng xếp hạng theo tuần</span>
        
        <div style="float:right" class="a_green">            
            <a class=lototop href='javascript:;' rel='<?php echo $tuan_nay ?>'>Tuần này</a> | 
            <a class=lototop href='javascript:;' rel='<?php echo $tuan_truoc ?>'>Tuần trước</a>&nbsp;&nbsp;&nbsp;
        </div>
    </div>
    <div id="lototop_result" style='border-top:1px solid #ddd;height:155px; overflow:auto; *position:relative'>
        <table class=toptbl cellspacing=1 cellpadding=3>
            <?php
            if ($loto_top_tuan) {
                foreach ($loto_top_tuan as $i => $item) {
                    ?>
                    <tr rel='<?php echo $item['userid'] ?>'>
                        <td class=ord><?php echo $i + 1 ?></td>
                        <td class=name rel='<?php echo $item['fullname'] ?>'>
                            <div><?php echo $item['fullname'] ?></div>
                        </td>
                        <td class=balance><?php echo number_format($item['taikhoan'], 0, '.', '.') ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
</div>
<script type="text/javascript">
    $('.lototop').click(function(){
        $('.lototop').removeClass('a_active');
        $(this).addClass('a_active');
        $.ajax({type:"GET",url:"<?php echo $uri_root?>client/chat/lototop?tuan="+$(this).attr('rel'),success:function(b){$("#lototop_result").html(b);}});
        return false;
    });
</script>

<div class=topbox>
    <div class="contentbox_header lototop_thang_header" style='background: url("<?php echo $uri_root ?>public/client/images/box_top_bg.gif") repeat-x scroll 0 0 rgba(0, 0, 0, 0);height:38px;line-height:38px;margin:0 1px;position:relative'>
        <span class=coins>&nbsp;</span> <a href="javascript:;" id="lototop_thang_title" style='text-shadow:1px 1px #bfbfbf; color:#ab1714;position:absolute; bottom:0; left:30px; display:inline-block; font-weight:bold'>Bảng xếp hạng theo tháng</a>
        
        <div style="float:right" class="a_green">            
            <a class=lototop_thang href='javascript:;' rel='<?php echo $thang_nay ?>'>Tháng này</a> | 
            <a class=lototop_thang href='javascript:;' rel='<?php echo $thang_truoc ?>'>Tháng trước</a>&nbsp;&nbsp;&nbsp;
        </div>
    </div>
    <div id="lototop_thang_result" style='border-top:1px solid #ddd;height:0; overflow:auto; *position:relative'>
        <table class=toptbl cellspacing=1 cellpadding=3>
            <?php
            if ($loto_top_thang) {
                foreach ($loto_top_thang as $i => $item) {
                    ?>
                    <tr rel='<?php echo $item['userid'] ?>'>
                        <td class=ord><?php echo $i + 1 ?></td>
                        <td class=name rel='<?php echo $item['fullname'] ?>'>
                            <div><?php echo $item['fullname'] ?></div>
                        </td>
                        <td class=balance><?php echo number_format($item['taikhoan'], 0, '.', '.') ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
</div>
<script type="text/javascript">
    function lototop_thangpopup(){
            $('#lototop_thang_result').animate({'height':155});
        clearTimeout(window.notiPopdownTimeout);
    }
    function lototop_thangdown(){
        $('#lototop_thang_result').animate({'height':0});
    }
    $('#lototop_thang_title').click(function(){
        if($(this).hasClass('lototop_thang_active')){		
            $(this).removeClass('lototop_thang_active');
            lototop_thangdown();
        }else{
            $('.lototop_thang_active').removeClass('lototop_thang_active');
            $(this).addClass('lototop_thang_active');
            lototop_thangpopup();
        }
    });

    $('.lototop_thang').click(function(){
        $('.lototop_thang').removeClass('a_active');
        $(this).addClass('a_active');
        $.ajax({type:"GET",url:"<?php echo $uri_root?>client/chat/lototop?thang="+$(this).attr('rel'),success:function(b){$('.lototop_thang_active').removeClass('lototop_thang_active');$('#lototop_thang_title').addClass('lototop_thang_active');lototop_thangpopup();$("#lototop_thang_result").html(b);}});
        return false;
    });
</script>

<div class=topbox>
    <div class="topdaigia_header" style='background: url("<?php echo $uri_root ?>public/client/images/box_top_bg.gif") repeat-x scroll 0 0 rgba(0, 0, 0, 0);height:38px;line-height:38px;margin:0 1px;position:relative'>
        <span class=coins>&nbsp;</span> <a href="javascript:;" id="topdaigia" style='cursor:pointer;text-shadow:1px 1px #bfbfbf; color:#ab1714;position:absolute; bottom:0; left:30px; display:inline-block; font-weight:bold'>Top Đại gia Lotto online</a><span id='toplisthelp' class='tip' style='position:absolute; right:8px; top:8px' rel='Top đại gia Lotto online là danh sách 50 người có tài khoản lotto cao nhất'><span class='questiontip'>&nbsp;</span></span>
    </div>
    <div id="topdaigia_result" style='border-top:1px solid #ddd;height:0; overflow:auto; *position:relative'>
        <table class=toptbl cellspacing=1 cellpadding=3>
            <?php
            if ($topdaigia) {
                foreach ($topdaigia as $i => $item) {
                    ?>
                    <tr rel='<?php echo $item['id'] ?>'>
                        <td class=ord><?php echo $i + 1 ?></td>
                        <td class=name rel='<?php echo $item['fullname'] ?>'>
                            <div><?php echo $item['fullname'] ?></div>
                        </td>
                        <td class=balance><?php echo number_format($item['taikhoan'], 0, '.', '.') ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
    <script type="text/javascript">
        function topdaigiapopup(){
            $('#topdaigia_result').animate({'height':155});
            clearTimeout(window.notiPopdownTimeout);
        }
        function topdaigiadown(){
            $('#topdaigia_result').animate({'height':0});
        }
        $('#topdaigia').click(function(){
            if($(this).hasClass('topdaigia_active')){		
                $(this).removeClass('topdaigia_active');
                topdaigiadown();
            }else{
                $('.topdaigia_active').removeClass('topdaigia_active');
                $(this).addClass('topdaigia_active');
                topdaigiapopup();
            }
        });
    </script>
</div>
<script type='text/javascript'>hovertip('#toplisthelp', 1)</script>
<style type="text/css">
    .coins{position:absolute; bottom:0; left:4px; width:23px; height:30px; background:url(<?php echo $uri_root ?>public/client/images/coins.png) no-repeat; overflow:hidden; display:inline-block; *background-image:none; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo $uri_root ?>public/client/images/coins.png, sizingMethod=scale)}
    .topbox{margin:5px 0; text-align:left; border:#ddd 1px solid}
    .toptbl{background:white; border-spacing:1px}
    .toptbl .ord{width:20px; background:#EAEAEA}
    .toptbl .name{background:#f0f0c3}
    .toptbl .name div{color:#069; font-weight:bold; width:215px; overflow:hidden}
    .toptbl .name_hover{background:#DEDFA7; cursor:pointer;border-radius:0;-moz-border-radius:0px;-webkit-border-radius:0px}
    .toptbl .balance{background:#ffef93; color:#008000; font-weight:bold}
    .toptbl .balance_hover{background:#EFDC77}
    .toptbl td{padding:4px}
    .lototop_thang_header a:hover,.topdaigia_header a:hover{left:32px !important}
</style>
<script type="text/javascript">
    $('.toptbl tr').hover(function(){
        $(this).find('.name').addClass('name_hover');
        $(this).find('.balance').addClass('balance_hover');
    },
    function(){
        $(this).find('.name').removeClass('name_hover');
        $(this).find('.balance').removeClass('balance_hover');
    });

    $('.toptbl td.name').click(function(){
        var receiver=$(this).parent().attr('rel');
        receiverName=$(this).find('div').html();
        ppchatInit(receiver,receiverName,0,1);
    });
    hovertip('.toptbl td.name');
</script>
    
<div class="contentbox">
    <div class=contentbox_header>
        <div style='color:#b43939;font-size:14px'>
            <div style="float:left;color:#b43939;font-size:14px;padding:0">Lô chơi nhiều</div>
            <div style="float:right" class="a_green">
                <?php if ($date_chot > date('Y-m-d')) { ?>
                    <?php if ($hour >= 18) { ?>
                        <a class=trenddaysw href='<?php echo $uri_root ?>chat_trend?list&amp;alone&amp;day=<?php echo date('Y-m-d') ?>' rel='<?php echo date('Y-m-d') ?>' target='_blank'>hôm nay</a> | 
                    <?php } ?>            
                <?php } ?>
                <a class=trenddaysw href='<?php echo $uri_root ?>chat_trend?list&amp;alone&amp;day=<?php echo date('Y-m-d', strtotime('-1 days')) ?>' rel='<?php echo date('Y-m-d', strtotime('-1 days')) ?>' target='_blank'>hôm qua</a> | 
                <a class=trenddaysw href='<?php echo $uri_root ?>chat_trend?list&amp;alone&amp;day=<?php echo date('Y-m-d', strtotime('-2 days')) ?>' rel='<?php echo date('Y-m-d', strtotime('-2 days')) ?>' target='_blank'>hôm kia</a> | 
                <span style='display:inline-block; position:relative'>
                    <input type=text id='trenddayselect' size=10 style='font-size:12px;color:#6ab400;background:#f0f0f0;padding:0;border:none;position:relative;z-index:98' />
                    <a id='trendayselect_guide' href='#' style='line-height:normal;background:#f0f0f0;position:absolute;top:0;left:0;z-index:99'>Chọn ngày&nbsp;&nbsp;</a>
                </span>
            </div>
        </div>
    </div>
</div>
<div id='oldtrendplace'></div>
<div id='trendplace'>
    <div id='trend_<?php echo $date_chot ?>'>
        <div class=contentbox>
            <div class=contentbox_header>
                <div style='color:#b43939;font-size:14px'>Lotto được chơi nhiều ngày <?php echo date('d/m/Y', strtotime($date_chot)) ?></div>
            </div>
            <div class=contentbox_body>
                <div>
                    <div class='trendholder'>
                        <?php
                        if ($trendday) {
                            $dem = 0;
                            $fontsize = 27;
                            $tmp = 0;
                            foreach ($trendday as $so => $nguoichoi) {
                                $dem++;
                                if ($dem > 20)
                                    break;
                                
                                if ($dem == 1) {
                                    $tmp = $nguoichoi;
                                } else {
                                    if ($nguoichoi < $tmp && $fontsize > 12) {
                                        $fontsize = $fontsize - 3;
                                    }
                                    $tmp = $nguoichoi;
                                }
                                echo "<a class='trend_number' href='javascript:;' style='font-family:arial; font-size:" . $fontsize . "px' title='" . $nguoichoi . " người chơi'>" . $so . "</a>";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div style='clear:both'></div>
            </div>
        </div>
    </div>
</div>
<?php if ($hour >= 18) { ?>
    <script type="text/javascript">loadtrend("<?php echo date('Y-m-d') ?>","#oldtrendplace",1);</script>
<?php } ?>
<script type="text/javascript">
    $('.trenddaysw').click(function(){
        $('.trenddaysw').removeClass('a_active');
        $(this).addClass('a_active');
        $('#trenddayselect').val('');
        $('#trendayselect_guide').show();
        loadtrend($(this).attr('rel'),"#oldtrendplace",1); 
        return false;
    });
    $('#trendayselect_guide').click(function(){$(this).hide();$('#trenddayselect').focus(); return false});
    $('#trenddayselect').change(function(){
        if($(this).val()=='')
        {
            $('#trendayselect_guide').show();
        }
        else
        {
            $('.trenddaysw').removeClass('a_active');
            loadtrend(sqldate($(this).val()),"#oldtrendplace",1);
        }
    });
    if($.datepicker){
        $('#trenddayselect').datepicker({
            monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            showAnim:'',
            minDate:new Date(<?php echo $minDate ?>),
            maxDate:new Date(<?php echo $maxDate ?>),
            onClose:function(text){if(text=='')$('#trendayselect_guide').show()}
        });
    }
    else{
        $('#trenddayselect').blur(function(){
            if($(this).val()=='')
            {
                $('#trendayselect_guide').show();
            }
        });
    }
    trendLoadInterval=60000;
    setTimeout(function(){loadtrend('<?php echo $date_chot ?>')},60000);
</script>
<style type="text/css">
    .contentbox{margin:7px 0;border:#ddd 1px solid;text-align:left}
    .contentbox_header {
        background: url("<?php echo $uri_root ?>public/client/images/box_top_bg.gif") repeat-x scroll 0 0 rgba(0, 0, 0, 0);
        height: 38px;
        line-height:38px;
        margin:0 1px;            
    }
    .contentbox_header div{font-weight:bold;color:#606060;font-size:12px;text-shadow:1px 1px #fff;position:relative;padding-left:5px}
    .contentbox_body{border-top:#ddd 1px solid;padding:5px}

    .trendholder{text-align:left}
    .trend_number:link, .trend_number:visited,.trend_number:hover,.trend_number:active{line-height:normal;display:inline-block; position:relative; color:#b43939; text-decoration:none; margin:0 8px 0 0}
    .trend_number:hover,.trend_number:active{color:#DF5900}
    .trend_old:link,.trend_old:visited,.trend_old:hover,.trend_old:active{color:#6C6C6C}
    .trend_old:hover,.trend_old:active{color:#DF5900}
    .trend_number:link span,.trend_number:visited span,.trend_number:hover span,.trend_number:active span{display:inline-block; width:12px; height:12px; overflow:hidden; position:absolute; right:-5px; top:-2px; text-align:center; font-size:11px; font-family:tahoma,arial; color:white; background:url('<?php echo $uri_root ?>public/client/images/rounddotbg.png'); background-repeat:no-repeat}
</style>    

<script type='text/javascript' src='<?php echo js_link('chot.js') ?>'></script>
<script type='text/javascript'>
    var ngaychot='<?php echo $date_chot ?>';
    var chotlock=0;
    var lastchotid=0;
    var lastchotupdate=0;
    var chotlist_intv=30000;
    var chotlist_timeout=15000;
</script>
<div id='chotshowarea'>
    <div class="contentbox" style="margin:0">
        <div class=contentbox_header>
            <div style='color:#b43939;font-size:14px'>
                <div style="float:left;color:#b43939;font-size:14px;padding:0">Xem lại chốt số</div>
                <div style="float:right" class="a_green">
                    <?php if ($date_chot > date('Y-m-d')) { ?>
                        <?php if ($hour >= 18) { ?>
                            <a class=chotdaysw href='#<?php echo date('Y-m-d') ?>' rel='<?php echo date('Y-m-d') ?>'>hôm nay</a> | 
                        <?php } ?>
                    <?php } ?>
                    <a class=chotdaysw href='#<?php echo date('Y-m-d', strtotime('-1 days')) ?>' rel='<?php echo date('Y-m-d', strtotime('-1 days')) ?>'>hôm qua</a> | 
                    <a class=chotdaysw href='#<?php echo date('Y-m-d', strtotime('-2 days')) ?>' rel='<?php echo date('Y-m-d', strtotime('-2 days')) ?>'>hôm kia</a> | 	
                    <span style='display:inline-block; position:relative'>
                        <input type=text id='chotdayselect' size=10 style='font-size:12px;color:#6ab400;background:#f0f0f0;padding:0;border:none;position:relative;z-index:98' />
                        <a id='chotdayselect_guide' href='#' style='line-height:normal;background:#f0f0f0;position:absolute;top:1px;left:0;z-index:99'>Chọn ngày&nbsp;&nbsp;&nbsp;</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div style="clear:both"></div>
    <div id='oldchotholder'></div>
</div>
<?php if ($hour >= 18) { ?>
    <script type="text/javascript">showchotlist("<?php echo date('Y-m-d') ?>");</script>
<?php } ?>
<script type="text/javascript">showchotlist("<?php echo $date_chot ?>");</script>
<div style='font-size:11px; text-align:left; padding:0 5px'>Trỏ chuột vào tên thành viên để xem tỷ lệ chốt trúng của thành viên đó (tỷ lệ trúng cao có màu nền đậm)</div>
<script type="text/javascript">
    $('.chotdaysw').click(function(){
        $('.chotdaysw').removeClass('a_active');
        $(this).addClass('a_active');
        $('#chotdayselect').val('');
        $('#chotdayselect_guide').show();
        showchotlist($(this).attr('rel'),'oldchotholder'); 
        return false;
    });
    $('#chotdayselect_guide').click(function(){$(this).hide();$('#chotdayselect').focus(); return false});
    $('#chotdayselect').change(function(){
        if($(this).val()=='')
        {
            $('#chotdayselect_guide').show();
        }
        else
        {
            $('.chotdaysw').removeClass('a_active');
            showchotlist(sqldate($(this).val()),'oldchotholder'); 
        }
    });
    if($.datepicker){
        $('#chotdayselect').datepicker({
            monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            showAnim:'',
            minDate:new Date(<?php echo $minDate ?>),
            maxDate:new Date(<?php echo $maxDate ?>),
            onClose:function(text){if(text=='')$('#chotdayselect_guide').show()}
        });
    }
    else{
        $('#chotdayselect').blur(function(){
            if($(this).val()=='')
            {
                $('#chotdayselect_guide').show();
            }
        });
    }
</script>
<style type="text/css">
    .col-content {
        font-family: arial,sans-serif;
        font-size: 12px;
    }
    .a_blue a:link,.a_blue a:visited,.a_blue a:hover,.a_blue a:active,
    .noticontent a:link,.noticontent a:visited,.noticontent a:hover,.noticontent a:active {text-decoration: none;color: #b10e0d}
    .a_blue a:visited,.noticontent a:visited {color: #884270}
    .a_blue a:active,.a_blue a:hover,.noticontent a:active,.noticontent a:hover {color: #ff8022}
    .a_green a:link,.a_green a:visited,.a_green a:hover,.a_green a:active{text-decoration: none;color: #6ab400}
    .a_green a:visited {color: #6ab400}
    .a_green a:active,.a_green a:hover {color: #ff8022}
    input#chot_submit{cursor:pointer}
    .col-content input[type="text"] {
        font-family: arial,sans-serif;
        height: 15px;
        line-height: 15px;
        padding: 2px;
    }
    .tip_hover{color:#555;background:#ffef93;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-decoration:none}
    .tipcontent{position:absolute;z-index:1003;display:inline-block;background:#ffef93;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;max-width:400px;*width:400px}
    .tipcontent_inner{display:inline-block;font-size:12px;font-weight:normal;text-align:left;color:#555;padding:3px 5px 5px 5px}
    .tiparrow{position:absolute;z-index:1002;display:inline-block;margin:0;padding:0;width:9px;height:9px;overflow:hidden;background:url('<?php echo $uri_root ?>public/client/images/arrow_down.png') center center no-repeat;*background-image:none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=<?php echo $uri_root ?>public/client/images/arrow_down.png,sizingMethod=scale)}
    .questiontip,.questiontip2 {
        background: url("<?php echo $uri_root ?>public/client/images/question.png") no-repeat scroll center center rgba(0, 0, 0, 0);
        display: inline-block;
        height: 20px;
        margin:0;
        overflow: hidden;
        width: 20px;
    }
    .questiontip2{background: url("<?php echo $uri_root ?>public/client/images/question2.png") no-repeat scroll center center rgba(0, 0, 0, 0);height:32px;width: 32px}
    .tip {
        cursor: pointer;
        display: inline-block;
    }
    .msg{display:inline-block;background:#f8ffea;border:#b4eb41 1px solid;color:#434600;padding:5px;margin:5px 0}
    .msgerr{display:inline-block;background:#fff2ea;border:#fa8e74 1px solid;color:#d91c00;padding:5px;margin:5px 0}
    .closebutton:link,.closebutton:visited,.closebutton:hover,.closebutton:active{position:absolute;top:3px;right:3px;z-index:3;display:inline-block;width:15px;height:15px;background:url('<?php echo $uri_root ?>public/client/images/close.png') no-repeat scroll 0 -16px transparent;overflow:hidden}
    .closebutton:hover{background-position:0 -32px}

    table#chottbl{border-spacing:1px;width:auto}
    #chottbl th,#chottbl td{color:#393939;padding:4px}
    #chottbl .chotinput{font-weight:bold; color:#333333;font-family:arial,sans-serif;padding:2px}
    #chottbl th{background:#E9E9E9}
    #chottbl td{background:#F2F2F2}

    .chotlisttbl{margin:5px 0px; text-align:left; border:#d0d0d0 1px solid; max-height:330px; overflow:hidden}
    .chotlisttbl .chotlisthead{text-shadow:1px 1px #a65957;background:url('<?php echo $uri_root ?>public/client/images/chot-today.jpg') scroll repeat-x 0 0; font-weight:bold; color:#fff; padding:5px;height:22px;line-height:22px;font-size:14px}
    .chotlisttbl .headhilight{background:#33B6E8}
    .chotlisttbl_old{border:#d0d0d0 1px solid}
    .chotlisttbl_old .chotlisthead{text-shadow:1px 1px #71935d;background:url('<?php echo $uri_root ?>public/client/images/chot-oldday.jpg') scroll repeat-x 0 0; font-weight:bold; color:#333; padding:5px;height:22px;line-height:22px;font-size:14px}
    .chotlistarea{padding:2px; max-height:300px; *height:300px; *position:relative; overflow:auto}

    .chotline{position:relative; background:#F6F6F6; margin-top:1px; padding:3px; font-weight:bold; color:#333333; border-bottom:#DFDFDF 1px solid}
    .chotline_hover{background:#DFDFDF}
    .chothight{background:#f0f0c3; border-bottom:#DFDFB5 1px solid}
    .chothight.chotline_hover{background:#DFDFB5}
    .chotline_new{background:#E7FDE1}
    .chotline_update{background:#FFF1C4}
    .chotline.trunglo{border-left:#23E800 3px solid}
    .chotline.trungde{border-left:#FF4415 3px solid}
    .chotline_deleting{background:#FFE3DD}
    .chotline_lo{margin-left:3px; color:#045CFF}
    .chotline_lodau{margin-left:3px; color:#045CFF}
    .chotline_lodit{margin-left:3px; color:#045CFF}
    .chotline_lobt{margin-left:3px; color:#E47301}

    .chotline_de{margin-left:3px; color:#7E15FF}
    .chotline_dedau{margin-left:3px; color:#7E15FF}
    .chotline_dedit{margin-left:3px; color:#7E15FF}
    .chotline_debt{margin-left:3px; color:#FF0000}
    .chotname{font-weight:700; color:#802a00; padding:2px}
    .chotcount{font-weight:700}
    .tip_hover{color:#555}
    .chotname .tipcontent{color:#E4CEFF; font-size:11px; font-weight:bold}
    .chottime{color:#393939; font-size:11px; font-weight:normal; font-style:italic}
    .votes{display:inline-block; margin:0 5px; font-size:11px; font-weight:bold}
    .clnhay{color:#008000; font-weight:normal; font-family:tahoma,arial; font-size:11px}
    .cdnhay{color:red; font-weight:normal; font-family:tahoma,arial; font-size:11px}
    .tk-home .content-2 .module span{margin:0 8px}
</style>
    
<br/>
<div style='text-align:center;font-size:12px;font-weight:700;color:#393939;padding:5px 0'>Bạn đã nghiên cứu xong chưa? Hãy chốt số để chia sẻ với mọi người:</div>
<div style="text-align:center"><a href='javascript:;' onclick='chotsw(this); return false' style='background-color: #b8100d;background-image: linear-gradient(to bottom, #b8100d, #960501);border: #980804 1px solid;color: #f1f4f8;display:inline-block; font-weight:bold; font-size:12px;height:32px;line-height:32px;padding:0 30px;border-radius: 3px;-moz-border-radius: 3px;-webkit-border-radius: 3px;'>Bấm để chốt số ngày <span id='ngaychotshow'><?php echo date('d/m/Y', strtotime($date_chot)) ?></span> <span class='updownarr'>▼</span></a></div>
<form name='chotform' id='chotform' style='margin:0 auto;width:340px;display:none' onsubmit='chotso(); return false'>
    <div id='chotmsgplace' style='position:absolute'></div>
    <div id='chotstatus' style='padding-top:5px; color:#008000; font-size:11px'></div>
    <table id='chottbl' border=0 cellspacing=1 cellpadding=4 style='background:white; border:#C5C5C5 1px solid'>
        <tr>
            <th></th>
            <th>Cặp số</th>
            <th>Đầu</th>
            <th>Đuôi</th>
            <th>Bạch thủ</th>
        </tr>
        <tr class='chotlo'>
            <td style='font-weight:bold; color:#045CFF'>Lô:</td>
            <td><input type=text class='chotinput' name='chotlo' size=15 value='' /></td>
            <td><input type=text class='chotinput' name='chotlodau' size=2 value='' /></td>
            <td><input type=text class='chotinput' name='chotlodit' size=2 value='' /></td>
            <td align=center><input type=text class='chotinput' name='chotlobt' size=2 value='' style='width:30px' /></td>
        </tr>
        <tr class='chotde'>
            <td style='font-weight:bold; color:#7E15FF'>ĐB:</td>
            <td><input type=text class='chotinput' name='chotde' size=15 value='' /></td>
            <td><input type=text class='chotinput' name='chotdedau' size=2 value='' /></td>
            <td><input type=text class='chotinput' name='chotdedit' size=2 value='' /></td>
            <td align=center><input type=text class='chotinput' name='chotdebt' size=2 value='' style='width:30px' /></td>
        </tr>
        <tr>
            <td colspan="5">
                <div style="text-align:center;position:relative">
                    <input type=submit id='chot_submit' name='chot_submit' value=' Chốt số ' style='background-color: #b8100d;background-image: linear-gradient(to bottom, #b8100d, #960501);border: #980804 1px solid;color: #f1f4f8;font-weight:bold; font-size:12px;font-family:arial,sans-serif;height:32px;padding:0 20px;border-radius: 3px;-moz-border-radius: 3px;-webkit-border-radius: 3px;' />
                    <span id='chotguide' class='tip' style="position:absolute; right:0; top:0" rel='<b>Bạn có thể nhập:</b><br/>- Tối thiểu: 1 số<br/> - Tối đa:<br/>+ Lô: 10 con<br/>+ Lô đầu: 3 số<br/>+ Lô đuôi: 3 số<br/>+ ĐB: 20 con<br/>+ ĐB đầu: 6 số<br/>+ ĐB đuôi: 6 số <br/>+ Bạch thủ: 1 con mà bạn cho là đẹp nhất.<br/>Các số nhập cách nhau bằng dấu phẩy.<br/> Ví dụ: 12,23,56.<br/> <i>Bạn chỉ được sửa các con số mình chốt trước 18h00.</i>'><span class='questiontip2'>&nbsp;</span></span>
                    <script type='text/javascript'>hovertip('#chotguide')</script>
                </div>
            </td>
        </tr>
    </table>
</form>
<script type='text/javascript'>
    $('.chotinput').keypress(function(){unlockchotform();});
    unlockchotform();
</script>

<br/>
<div class="tk-home">
    <div class="content-2">
        <h3>Thống kê nhanh cho xổ số Miền Bắc đến ngày <?php echo date('d/m/Y') ?></h3>
        <div class="module">
            <h3>Loto lâu chưa ra (loto gan):</h3>
            <div style="padding:15px 3px">
                <?php
                foreach ($itemsImportant['cautious'] as $k => $v) {
                    echo '<span><strong>' . $v['number'] . '</strong>' . $v['not_count'] . ' ngày</span>';
                }
                ?>
            </div>
        </div>
        <div class="module">
            <h3>Loto ra nhiều trong tháng qua:</h3>
            <div style="padding:15px 3px">
                <?php
                foreach ($items_30['nhieu_nhat'] as $k => $v) {
                    echo '<span><strong>' . $v['number'] . '</strong>' . $v['count'] . ' lần</span>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>

</div>
    
<div class="col-main" style="width:566px">
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