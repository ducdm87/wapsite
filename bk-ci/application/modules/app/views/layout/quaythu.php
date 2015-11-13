<br/>
<script type="text/javascript" src="<?php echo js_link('jquery-1.7.2.js') ?>"></script>
<div class="txt-center">
    <button name="submit" type="button" class="bt-green pad10" onclick="location.reload();"><strong>Quay lại</strong></button>
</div>
<div class="box-result">
    <div class="bor-top" id="load_kq"></div>
</div>
<script type="text/javascript">
    var t;
    var result = {<?php echo $str_result ?>};
    function randomMB(id)
    {   
        if(id <= 27){
            $("#g"+id).removeClass('imgloadig').html(result[id]);
            id++;
            t = setTimeout("randomMB("+id+")", 1500); 

        }else{
            clearTimeout(t);  
        }      
    }

    function randomMN(id)
    {   
        if(id <= 18){
            $("#g"+id).removeClass('imgloadig').html(result[id]);
            id++;
            t = setTimeout("randomMN("+id+")", 1500); 

        }else{
            clearTimeout(t);  
        }      
    }
    function randomMT(id)
    {   
        if(id <= 18){
            $("#g"+id).removeClass('imgloadig').html(result[id]);
            id++;
            t = setTimeout("randomMN("+id+")", 1500); 

        }else{
            clearTimeout(t);  
        }      
    }

    function runResult(){
        clearTimeout(t);
        var strUrl = '<?php echo $uri_root ?>app/quaythu/loadKq';
        $.ajax({
            type:"POST",
            url:strUrl,
            data:{lid:<?php echo $lid ?>,name:'<?php echo $name ?>',alias:'<?php echo $alias ?>',area:'<?php echo $area ?>'},            
            success:function(msg){  
                $("#load_kq").html(msg);
                t = setTimeout("random<?php echo $area ?>(1)", 2000);
            }
        });

    }
    $(document).ready(function(){runResult();});
</script>