/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(window).ready(function($) {
    // thay doi bieu do
    $(".box-bieudo .chon-bieu-do select").change(function(){
        var val = $(this).val();
        var title = $(this).find("option:selected").attr("title");
        if($(this).hasClass("bieudo1")){
            $(".box-bieudo .bieudo1 .hinh-anh img").attr("src",val);
            $(".box-bieudo .bieudo1 .bieudo-title").text(title);
        }else{
            $(".box-bieudo .bieudo2 .hinh-anh img").attr("src",val);
            $(".box-bieudo .bieudo2 .bieudo-title").text(title);
        }
    });
    
    // phan trang trang bieu do tram xang
    var currentpage = $(".page-bando .pageNave li.active").attr("rel");
    showDanhSachTinh(currentpage);
    $(".page-bando .pageNave li").click(function(){
        var currentpage = $(this).attr("rel");
        showDanhSachTinh(currentpage);
        $(".page-bando .pageNave li").removeClass("active");
        $(this).addClass("active");
    });

    
});

function showDanhSachTinh(currentpage){
    var length = $(".page-bando .box-danhsach-tinhthanh .items li").length;
    $(".page-bando .box-danhsach-tinhthanh .items li").hide();
    var start = (currentpage - 1) * limit_bando_danhsach_tinh;
    var end = start + limit_bando_danhsach_tinh;
    if(end>length) end = length;
    for(i=start; i<end;i++){
        var el = $(".page-bando .box-danhsach-tinhthanh .items li")[i];
        $(el).show();
    }
}
