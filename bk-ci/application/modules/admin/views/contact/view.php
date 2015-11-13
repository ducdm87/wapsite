<div class="editcate_top">
    <a href="javascript:void(0)" onclick ="$('#light_adct').hide();$('#fade_adct').hide()"><img src="<?php echo img_link('close.png', 'admin'); ?>" class="png" /></a>
</div>

<div class="editcate_ct" style="width: 673px;">
    <div class="boxadd">
        <ul class="metatags">
            <li>
                <span class="left"><b>Họ tên</b></span>
                <span class="right"><?php echo $row->fullname; ?></span>
            </li>
            <li>
                <span class="left"><b>Điện thoại</b></span>
                <span class="right"><?php echo $row->mobile; ?></span>
            </li>
            <li>
                <span class="left"><b>Địa chỉ</b></span>
                <span class="right"><?php echo $row->address; ?></span>
            </li>
            <li>
                <span class="left"><b>Email</b></span>
                <span class="right"><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a></span>
            </li>
            <li>
                <span class="left"><b>Nội dung</b></span>
                <span class="right"><?php echo $row->content; ?></span>
            </li>
        </ul>
    </div>
    <div class="btarticle">
        <input type="button" value="Đóng" class="btn" onclick="$('#light_adct').hide();$('#fade_adct').hide();" />
    </div>
</div>