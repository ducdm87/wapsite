<div class="title title-red">
    <div class="title-right">Dịch vụ SMS</div>
</div>
<div class="box-result" style="border:2px solid #e1e1e1;border-bottom-width:1px;border-top:none;background:#f7f7f7">
    <div class="box-sms">
        <ul class="list-sms">
           <li>Soạn <strong class="red">BHX KQ &lt;MaTinh&gt;</strong> gửi <strong class="red">8188</strong> để nhận thông tin kết quả <span>TỈNH</span> quay thưởng sớm nhất<br/>Ví dụ: <span>BHX KQ MB</span></li>
            <li>Soạn <strong class="red">BHX KQ &lt;MaTinh&gt; &lt;Ngaythang&gt;</strong> gửi <strong class="red">8188</strong> để nhận thông tin kết quả <span>TỈNH</span> bạn lựa chọn theo ngày tháng<br/>Ví dụ: <span>BHX KQ MB 31082013</span></li>
            <li>Soạn <strong class="red">BHX TT &lt;MaTinh&gt;</strong> gửi <strong class="red">8588</strong> để xem tường thuật trực tiếp kết quả của <span>TỈNH</span> quay thưởng<br/>Ví dụ: <span>BHX TT MB</span></li>
            <li>Soạn <strong class="red">BHX KQ &lt;MaTinh&gt;</strong> gửi <strong class="red">8788</strong> để nhận thông tin kết quả <span>TỈNH</span> quay thưởng trong 20 ngày<br/>Ví dụ: <span>BHX KQ MB</span></li>
            <li>Soạn <strong class="red">BHX KQ &lt;MaTinh&gt;</strong> gửi <strong class="red">8588</strong> để nhận thông tin kết quả <span>TỈNH</span> quay thưởng trong 10 ngày<br/>Ví dụ: <span>BHX KQ MB</span></li>
            <li>Soạn <strong class="red">BHX KQ &lt;MaTinh&gt; &lt;so&gt;</strong> gửi <strong class="red">8588</strong> để nhận thống kế số lần xuất hiện của cặp số của tỉnh mở thưởng trong 30 ngày gần nhất, ngày về gần nhất.<br/>Ví dụ: <span>BHX KQ MB 85</span></li>
        </ul>
    </div>
</div>

<?php
if ($c_module == 'soicau' || $c_module == 'thongke' || ($c_module == 'statistics' && $c_func != 'doveso')) {
    $width_data = '540';
    if ($c_func == 'chuky')
        $width_data = '960';
    elseif ($c_func == 'month')
        $width_data = '745';

    $this->load->view($thongke_block);
    ?>
    <div style="padding:10px">
        <div class="fb-comments" data-href="<?php echo current_url() ?>" data-width="<?php echo $width_data ?>" data-numposts="5" data-colorscheme="light"></div>
    </div>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&appId=273907246043986&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <?php
}
?>