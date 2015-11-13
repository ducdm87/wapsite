<style type="text/css">
    .title_quayxs_block {
        clear: left;
        font-weight: 400;
        line-height: 22px;
        padding-bottom: 7px;
        text-align: center;
    }
    .title_quayxs {
        color: #AA0000;
        font-size: 18px;
        padding-top: 7px;
    }
    .subtitle_quayxs {
        color: #BB0000;
        font-size: 15px;
    }
    table {
        border-spacing: 0;
        empty-cells: show;
        width: 700px;
        margin:0 auto;
        line-height:30px;
    }
    .ctxs input {
        color: #222222;
        font-family: Tahoma,Geneva,sans-serif;
        font-size: 14px;
        font-weight: 400;
        padding: 2px;
        width: 80px;
    }
    .btarticle{float:none;text-align:center}
    .btarticle input.btn{float:none;font-size:18px}
    .red{color:red}
    .tbView_title,.tbView_title span{font-size:12px}
</style>
<div class="box-result">
    <div class="select-provice kqxs-block clearfix">
        <div class="title_quayxs_block">
            <div class="title_quayxs">Xổ số kiến thiết Miền Bắc</div>
            <div class="subtitle_quayxs">Ngày mở thưởng <?php echo date('d-m-Y') ?></div>
        </div>
    </div>

    <?php
    if ($row) {
        $data = $row->cache->data->MB->data;
        ?>
        <form method="post" action="" name="articles_form" id="articles_form" onsubmit="return checkData()">
            <table class="tbl-tt">
                <tr>
                    <td class="bg-gray border-right" width="1%" nowrap>
                        <div class="tbView_title"><span class="red">Giải đặc biệt</span></div>
                    </td>
                    <td class="bg-gray giaidb">
                        <div class="ctxs"><input type="text" name="db" maxlength="5" value="<?php echo $data[0] ?>" /></div>
                    </td>
                </tr>	
                <tr>
                    <td class="border-right">
                        <div class="tbView_title">Giải nhất</div>
                    </td>
                    <td class="giai1">
                        <div class="ctxs"><input type="text" name="g1" maxlength="5" value="<?php echo $data[1] ?>" /></div>
                    </td>
                </tr>
                <tr>
                    <td class="bg-gray border-right">
                        <div class="tbView_title">Giải nhì</div>
                    </td>
                    <td class="bg-gray">
                        <?php $value = explode('-', $data[2]); ?>
                        <div class="ctxs"><input type="text" name="g2[]" maxlength="5" value="<?php echo $value[0] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g2[]" maxlength="5" value="<?php echo $value[1] ?>" /></div>
                    </td>
                </tr>
                <tr>
                    <td class="border-right">
                        <div class="tbView_title">Giải ba</div>
                    </td>
                    <td>
                        <?php $value = explode('-', $data[3]); ?>
                        <div class="ctxs"><input type="text" name="g3[]" maxlength="5" value="<?php echo $value[0] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g3[]" maxlength="5" value="<?php echo $value[1] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g3[]" maxlength="5" value="<?php echo $value[2] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g3[]" maxlength="5" value="<?php echo $value[3] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g3[]" maxlength="5" value="<?php echo $value[4] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g3[]" maxlength="5" value="<?php echo $value[5] ?>" /></div>
                    </td>
                </tr>
                <tr>
                    <td class="bg-gray border-right">
                        <div class="tbView_title">Giải tư</div>
                    </td>
                    <td class="bg-gray">
                        <?php $value = explode('-', $data[4]); ?>
                        <div class="ctxs"><input type="text" name="g4[]" maxlength="4" value="<?php echo $value[0] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g4[]" maxlength="4" value="<?php echo $value[1] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g4[]" maxlength="4" value="<?php echo $value[2] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g4[]" maxlength="4" value="<?php echo $value[3] ?>" /></div>
                    </td>
                </tr>
                <tr>
                    <td class="border-right">
                        <div class="tbView_title">Giải năm</div>
                    </td>
                    <td>
                        <?php $value = explode('-', $data[5]); ?>
                        <div class="ctxs"><input type="text" name="g5[]" maxlength="4" value="<?php echo $value[0] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g5[]" maxlength="4" value="<?php echo $value[1] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g5[]" maxlength="4" value="<?php echo $value[2] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g5[]" maxlength="4" value="<?php echo $value[3] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g5[]" maxlength="4" value="<?php echo $value[4] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g5[]" maxlength="4" value="<?php echo $value[5] ?>" /></div>
                    </td>
                </tr>
                <tr>
                    <td class="bg-gray border-right">
                        <div class="tbView_title">Giải sáu</div>
                    </td>
                    <td class="bg-gray">
                        <?php $value = explode('-', $data[6]); ?>
                        <div class="ctxs"><input type="text" name="g6[]" maxlength="3" value="<?php echo $value[0] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g6[]" maxlength="3" value="<?php echo $value[1] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g6[]" maxlength="3" value="<?php echo $value[2] ?>" /></div>
                    </td>
                </tr>
                <tr>
                    <td class="border-right">
                        <div class="tbView_title">Giải bảy</div>
                    </td>
                    <td>
                        <?php $value = explode('-', $data[7]); ?>
                        <div class="ctxs"><input type="text" name="g7[]" maxlength="2" value="<?php echo $value[0] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g7[]" maxlength="2" value="<?php echo $value[1] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g7[]" maxlength="2" value="<?php echo $value[2] ?>" /></div>
                        <div class="ctxs"><input type="text" name="g7[]" maxlength="2" value="<?php echo $value[3] ?>" /></div>
                    </td>
                </tr>
            </table>
            <div class="btarticle">
                <input type="submit" class="btn" value="Lưu" />
            </div>
        </form>
        <script type="text/javascript">
            function checkData(){
                var myForm = document.articles_form;
                var giai;
                var pattern = /^[0-9+\*]+$/;
                                            
                var db = myForm.db;
                if(!db.value.match(pattern)){
                    alert('Nhap sai du lieu');
                    myForm.db.focus();
                    return false;
                }
                                            
                var g1 = myForm.g1;
                if(!g1.value.match(pattern)){
                    alert('Nhap sai du lieu');  
                    myForm.g1.focus();
                    return false;  
                }
                                    
                giai = myForm.elements['g2[]'];
                for (var i = 0; i < giai.length; i++) {
                    if(!giai[i].value.match(pattern)){
                        alert('Nhap sai du lieu');  
                        return false;  
                    }
                }
                            
                giai = myForm.elements['g3[]'];
                for (var i = 0; i < giai.length; i++) {
                    if(!giai[i].value.match(pattern)){
                        alert('Nhap sai du lieu');  
                        return false;  
                    }
                }
                            
                giai = myForm.elements['g4[]'];
                for (var i = 0; i < giai.length; i++) {
                    if(!giai[i].value.match(pattern)){
                        alert('Nhap sai du lieu');  
                        return false;  
                    }
                }
                            
                giai = myForm.elements['g5[]'];
                for (var i = 0; i < giai.length; i++) {
                    if(!giai[i].value.match(pattern)){
                        alert('Nhap sai du lieu');  
                        return false;  
                    }
                }
                            
                giai = myForm.elements['g6[]'];
                for (var i = 0; i < giai.length; i++) {
                    if(!giai[i].value.match(pattern)){
                        alert('Nhap sai du lieu');  
                        return false;  
                    }
                }
                            
                giai = myForm.elements['g7[]'];
                for (var i = 0; i < giai.length; i++) {
                    if(!giai[i].value.match(pattern)){
                        alert('Nhap sai du lieu');  
                        return false;  
                    }
                }
                                    
                return true;
            }
        </script>
        <?php
    } else {
        echo '<h3 style="text-align:center;font-weight:400;font-size:18px">Chưa đến giờ quay!</h3>';
    }
    ?>
</div>