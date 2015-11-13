<script type="text/javascript" src="<?php echo js_link('jquery-1.7.2.js') ?>"></script>
<br/>
<?php
$current = time();
$time_area = date('H\hi', strtotime($timer));
$time = date('H:i');

if ($area == 'MB') {
    $title = 'MIỀN BẮC';
    $title2 = 'Miền Bắc';
    $time_end = '18:00';
} elseif ($area == 'MT') {
    $title = 'MIỀN TRUNG';
    $title2 = 'Miền Trung';
    $time_end = '17:00';
} else {
    $title = 'MIỀN NAM';
    $title2 = 'Miền Nam';
    $time_end = '16:00';
}

$counter = (strtotime(date($timer)) - $current) * 1000;
$today = date('d/m/Y', time());
?>
<div class="waiting t-cen" id="icon-load">
    <img src="<?php echo img_link('icon-xs/007.gif'); ?>" width="145" height="15" alt="" /><br />
    Đang chờ Kết quả Xổ số <?php echo $title2 ?> lúc<br />
    <strong><?php echo $time_area . ' ngày ' . $today ?></strong>. Chúc các bạn may mắn!!!
</div>
<div id="xstt-block">
    <div class="box-current t-cen">
        <p><span class="red font16"><?php if ($counter > 0) { ?>Hiện tại không phải giờ xổ số!!!<?php } else { ?>Tường thuật trực tiếp kết quả xổ số<?php } ?></span></p>
        <?php if ($area != 'MB') { ?>
            <p>Lịch quay số mở thưởng ngày <?php echo $today ?></p>
            <p class="red">
                <?php
                foreach ($location_today[$area] as $k => $v)
                    echo ($k == 0 ? '' : ' - ') . $v->name;
                ?>
            </p>
        <?php } ?>
    </div>
    <div class="box-wait" id="xstt">
        <div class="wait-inner">
            <ul class="clearfix">
                <li><span class="num hour">00</span></li>
                <li><span class="num min">00</span></li>
                <li><span class="num sec">00</span></li>
            </ul>
        </div>
    </div>
</div>
<div class="mb10 clearfix"></div>
<div id="kqxs-block"></div>
<script type="text/javascript">
/*<![CDATA[*/
var counter=<?php echo $counter ?>;var checkTime=3000;var clockTime=1000;var timerCheck;var timerClock=setInterval("clockUpdate();",clockTime);<?php if($time<$time_end){?>timerCheck=setInterval("checkUpdate();",checkTime);<?php } ?>
function clockUpdate(){if(counter>-1){mb=countDown(counter);counter=mb.time;$("#xstt .hour").html(mb.hour);$("#xstt .min").html(mb.min);$("#xstt .sec").html(mb.sec)}else{timerCheck=setInterval("checkUpdate();",checkTime);clearInterval(timerClock)}}
function countDown(f){f=f-clockTime;var a=Math.floor(f/(1000*60*60));var e=Math.floor(f/(1000*60));var c=Math.floor(f/1000);var b=e-a*60;var d=c-e*60;if(a<0){b="00"}else{if(b<10){b="0"+b}}if(a<0){d="00"}else{if(d<10){d="0"+d}}if(a<0){a="00"}else{if(a<10){a="0"+a}}return Object({hour:a,min:b,sec:d,time:f})}
function checkUpdate(){if(counter<=0){$.ajax({type:"GET",timeout:3000,url:"<?php echo $uri_root . 'app/tructiep/xstt/' . $area.'?t='.$timer; ?>",success:function(a){if(a!=1){$("#xstt-block").html(a);$("#kqxs-block").html('');$("#icon-load").html('')}}});}}
$(document).ready(function(a){
clockUpdate();checkUpdate();
<?php if($time<$time_end){?>$.ajax({type:"GET",timeout:3000,url:"<?php echo $uri_root . 'app/tructiep/xstt/' . $area.'?t='.$timer; ?>",success:function(a){if(a!=1){$("#kqxs-block").html(a)}}});<?php } ?>
});
/*]]>*/
</script>