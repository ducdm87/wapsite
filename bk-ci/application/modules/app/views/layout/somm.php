<script type="text/javascript" src="<?php echo js_link('jquery-1.7.2.js') ?>"></script>
<script type="text/javascript" src="<?php echo $mxoso . 'public/client/js/common.js' ?>"></script>
<br/>
<div class="box-result dudoan_block">					
    <div class="select-provice">
        <form id="form_search" name="form_search" method="post" action="">
            <div class="clearfix rows">
                <div class="box">
                    <div class="box-note">
                        <div class="interpreted">Nhập họ tên, ngày tháng năm sinh, giới tính, ngày hiện tại và lựa chọn xem con số may mắn theo</div>
                        <p>- Con số may mắn trong ngày cho bạn biết con số may mắn của bạn hôm nay là số nào </p>
                        <p>- Mệnh của bạn hợp với con số nào trong ngày: Soi số may mắn ứng với mệnh Kim, Mộc, Thủy, Hỏa, Thổ của bạn</p>
                        <p>- Con số định mệnh của bạn</p>
                    </div>
                </div>

                <div class="bg_yellow">
                    <div class="magb10 cl-green">Trước khi quay số hay điền đầy đủ thông tin của bạn vào đây</div>
                    <div class="magb10 clred"></div>
                    <ul class="col-25-75">
                        <li>
                            <label class="in-block"><strong>Họ tên:</strong></label>
                            <div class="in-block">
                                <input type="text" name="fullname" id="fullname" value="" />
                            </div>
                        </li>
                        <li>
                            <label class="in-block"><strong>Bạn sinh:</strong></label>
                            <div class="in-block">
                                <select name="birth_day" id="birth_day">
                                    <option value="0">Ngày</option>
                                    <?php
                                    for ($i = 1; $i <= 31; $i++) {
                                        echo '<option value="' . $i . '" >' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <select name="birth_month" id="birth_month">
                                    <option value="0">Tháng</option>
                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<option value="' . $i . '" >' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <select name="birth_year" id="birth_year">
                                    <option value="0">Năm</option>
                                    <?php
                                    $cur_year = date('Y');
                                    $min_year = $cur_year - 80;
                                    for ($i = $min_year; $i <= $cur_year - 10; $i++) {
                                        echo '<option value="' . $i . '" >' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label class="in-block"><strong>Giới tính:</strong></label>
                            <div class="in-block">
                                <select name="sex">
                                    <option value="1" selected>Nam</option>
                                    <option value="0" >Nữ</option>
                                </select>

                            </div>
                        </li>
                        <li>
                            <label class="in-block"><strong>Hôm nay:</strong></label>
                            <div class="in-block">
                                <input name="now_day" type="text" class="percent-32"  value="<?php echo date('d') ?>" disabled="disabled" />
                                <input name="now_month" type="text" class="percent-32"  value="<?php echo date('m') ?>" disabled="disabled" />
                                <input name="now_year" type="text" class="percent-32"  value="<?php echo date('Y') ?>" disabled="disabled" />
                            </div>
                        </li>
                        <li>
                            <label class="in-block"><strong>Hiện tại là:</strong></label>
                            <div class="in-block">
                                <input type="text" name="time_now"  value="<?php echo date('H:i:s') ?>" disabled="disabled" />
                            </div>
                        </li>
                    </ul>
                    <div class="bg_org pad10-5">
                        <em>Trời đất trở che, thánh thần thiêng liêng có cầu thì hỏi, có bói thì thông, chữ rằng: "có thánh có thần có cầu có ứng"</em>
                    </div>

                    <h2 class="s18 txt-center">Chọn con số bạn muốn tìm</h2>
                    <p class="mag5-0 cl-green"><img width="16" height="15" class="mag-r5" alt="icon check" src="<?php echo img_link('ic-check.png') ?>" />Người xem chỉ được chọn 1 trong những lựa chọn trên, muốn xem thêm thì chọn lại</p>
                    <p class="mag5-0"><input checked name="type" value="1" type="radio" class="mag-r5" />Tìm con số may mắn của bạn trong ngày</p>
                    <p class="mag5-0"><input name="type" value="2" type="radio" class="mag-r5" />Mệnh của bạn hợp với số nào trong ngày</p>
                    <p class="mag5-0"><input name="type" value="3" type="radio" class="mag-r5" />Con số định mệnh</p>
                    <div class="pad10 txt-center">
                        <button name="submit" type="button" class="bt-green pad10" onclick="timedCount();"><strong>Quay Số</strong></button>
                    </div>
                    <div class="number-lucky clearfix txt-center">
                        <div class="in-block">
                            <span class="bt-lucky mag-r5 relative">
                                <strong class="s24" id="result_1"></strong>
                                <img width="49" height="8" class="absolute" alt="" src="<?php echo img_link('line-bt.png') ?>" />
                            </span>
                            <span class="bt-lucky mag-r5 relative">
                                <strong class="s24" id="result_2"></strong>
                                <img width="49" height="8" class="absolute" alt="" src="<?php echo img_link('line-bt.png') ?>" />
                            </span>
                            <span class="bt-lucky mag-r5 relative">
                                <strong class="s24" id="result_3"></strong>
                                <img width="49" height="8" class="absolute" alt="" src="<?php echo img_link('line-bt.png') ?>" />
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    function setCookie(name,value,expires,path,domain,secure){
        var today=new Date();
        today.setTime(today.getTime());
        if(expires){
            expires=expires*1000*60*60;
        }
        var expires_date=new Date(today.getTime()+(expires));
        document.cookie=name+"="+escape(value)+
            ((expires)?";expires="+expires_date.toGMTString():"")+
            ((path)?";path="+path:"")+
            ((domain)?";domain="+domain:"")+
            ((secure)?";secure":"");
    }
    function getCookie(name){
        var start=document.cookie.indexOf(name+"=");
        var len=start+name.length+1;
        if((!start)&&(name!=document.cookie.substring(0,name.length))){
            return null;
        }
        if(start==-1)return null;
        var end=document.cookie.indexOf(";",len);
        if(end==-1)end=document.cookie.length;
        return unescape(document.cookie.substring(len,end));
    }
    function preg_replace(i,m,j,c){if(c===undefined){c=-1}var d=i.substr(i.lastIndexOf(i[0])+1),f=i.substr(1,i.lastIndexOf(i[0])-1),a=new RegExp(f,d),b=null,h=[],l=0,k=0,g=j;if(c===-1){var e=[];do{e=a.exec(j);if(e!==null){h.push(e)}}while(e!==null&&d.indexOf("g")!==-1)}else{h.push(a.exec(j))}for(l=h.length-1;l>-1;l--){e=m;for(k=h[l].length-1;k>-1;k--){e=e.replace("${"+k+"}",h[l][k]).replace("$"+k,h[l][k]).replace("\\"+k,h[l][k])}g=g.replace(h[l][0],e)}return g};
    var count=0;
    var rate=10;
    function random(){c1=Math.floor(Math.random()*90)+10;c2=Math.floor(Math.random()*90)+10;c3=Math.floor(Math.random()*90)+10;document.getElementById("result_1").innerHTML=c1;document.getElementById("result_2").innerHTML=c2;document.getElementById("result_3").innerHTML=c3;return c1+","+c2+","+c3};
    var counter=50;
    var clockTime=1;
    var timerClock;
    function clockUpdate(){if(counter>-1){mb=counter-clockTime;counter=mb;random()}else{var c=$("#fullname").val();c=preg_replace("/[^a-zA-Z0-9]/g","",c);var f=$("#birth_day").val();var e=$("#birth_month").val();var h=$("#birth_year").val();var g=$("#form_search input[type='radio']:checked").val();var b=c+f+e+h+g+"<?php echo date('dmY') . $lid ?>";var d=random();if(!getCookie(b)){setCookie(b,d,4,"/","","")}else{d=getCookie(b);var a=d.split(",");document.getElementById("result_1").innerHTML=a[0];document.getElementById("result_2").innerHTML=a[1];document.getElementById("result_3").innerHTML=a[2]}clearInterval(timerClock)}};
    function timedCount(){if($("#fullname").val()==""){alert("Bạn chưa nhập họ tên");document.form_search.fullname.focus();return false}else{if($("#birth_day").val()==0){alert("Bạn chưa nhập ngày sinh");document.form_search.birth_day.focus();return false}else{if($("#birth_month").val()==0){alert("Bạn chưa nhập tháng sinh");document.form_search.birth_month.focus();return false}else{if($("#birth_year").val()==0){alert("Bạn chưa nhập năm sinh");document.form_search.birth_year.focus();return false}}}}counter=50;timerClock=setInterval("clockUpdate();",100)};
    function stopCount(){clearTimeout(t)};
</script>