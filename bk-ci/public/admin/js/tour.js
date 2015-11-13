$(function (){
	//setTimeout("hide_message()",5000); 
});

function change_tab(id)
{
	$(".titletab li a").removeClass('active');
	$(".boxeditor").css('display','none');
	$("#li_"+id+' a').addClass('active');
	$("#d_"+id).css('display','block');
}

function hide_message()
{
	$(".error").css('display','none');
	$(".success").css('display','none');
}

function load_form(url){
	$("#light").empty();
    $.ajax({
        url: url,
        type: 'GET',
        error: function(){
            alert('Error !');
        },
        success: function(success)
        {  
        	$("#light").html(success);
        }
    });
}

function cen_popup(pageURL, title,w,h) {
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 

function add_item()
{
	str = '<tr><td class="pdd"><input name="pid[]" id="pid[]" type="hidden" /><input type="text" name="per[]" value="" style="border:1px #ddd solid; width:200px;" /></td><td class="pdd"><input type="text" name="pri[]" value="" style="border:1px #ddd solid; width:200px;" /></td></tr>';
	$(".pricing table").append(str);
	return false;
}



