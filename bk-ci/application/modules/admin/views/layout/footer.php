<div id="waiting" style="display:none;">
    <img src="<?php echo img_link('ajax-loader.gif', 'admin'); ?>" title="Loader" alt="Loader" />
</div>
<div id="light_adct" class="white_content"></div>
<div id="fade_adct" class="black_overlay"></div>
<script type="text/javascript">
    function emeta(url)
    {
        document.getElementById('light_adct').style.display='block';
        document.getElementById('fade_adct').style.display='block';
        wh = getSizeWH();
        h = wh[1];
        var c;
        c = (h-600)/2;
        var arr = getScrollXY();
        var v = arr[1] + c;
        //alert(h);
        $('#light_adct').html('').show();
        load_content('light_adct', url);
        $('#fade_adct').show();
    }

    function getScrollXY() {
        var scrOfX = 0, scrOfY = 0;
        if( typeof( window.pageYOffset ) == 'number' ) {
            //Netscape compliant
            scrOfY = window.pageYOffset;
            scrOfX = window.pageXOffset;
        } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
            //DOM compliant
            scrOfY = document.body.scrollTop;
            scrOfX = document.body.scrollLeft;
        } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
            //IE6 standards compliant mode
            scrOfY = document.documentElement.scrollTop;
            scrOfX = document.documentElement.scrollLeft;
        }
        //return [ scrOfX, scrOfY ];
        return [scrOfX,scrOfY];
    }
</script>

</body>
</html>
