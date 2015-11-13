/**
 * @author	Tran Van Thanh
 * @date	30.08.2011
 */
function open_form(url)
{	
	$('#light_adct').html('').show();
	load_content('light_adct', url);
	$('#fade_adct').show();
}

function question_usually(question_id, status)
{	
	$.post(admin_url+'questions/change_usually', 'question_id='+question_id+'&status='+status, function(msg) {		
		if(msg == "yes") {
			load_content('row_'+question_id, admin_url+'questions/load_row/'+question_id);
            $('.linecate2').has('#row_'+question_id).css('background-color', '#FFFFE0');
		}
	});
}

function question_status(question_id, status)
{
	$.post(admin_url+'questions/change_status', 'question_id='+question_id+'&status='+status, function(msg) {		
		if(msg == "yes") {
			load_content('row_'+question_id, admin_url+'questions/load_row/'+question_id);
            $('.linecate2').has('#row_'+question_id).css('background-color', '#FFFFE0');
		}
	});
}

function questions_delete(question_id)
{
	if(!confirm('Are you sure ?')) {
	        return false;
	    }
	    
	$.post(admin_url+'questions/delete/'+question_id, function(msg) {		
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+question_id).fadeOut('slow').remove();
		}
	});
}

function tableprice_status(price_id, status)
{
	$.post(admin_url+'table_price/change_status', 'price_id='+price_id+'&status='+status, function(msg) {		
		if(msg == "yes") {
			load_content('row_'+price_id, admin_url+'table_price/load_row/'+price_id);
            $('.linecate2').has('#row_'+price_id).css('background-color', '#FFFFE0');
		}
	});
}

function tableprice_delete(price_id)
{
	if(!confirm('Are you sure ?')) {
        return false;
    }
    
	$.post(admin_url+'table_price/delete/'+price_id, function(msg) {		
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+price_id).fadeOut('slow').remove();
		}
	});
}

function slideshows_status(slideshow_id, status)
{
	$.post(admin_url+'slideshows/change_status', 'slideshow_id='+slideshow_id+'&status='+status, function(msg) {		
		if(msg == "yes") {
			load_content('row_'+slideshow_id, admin_url+'slideshows/load_row/'+slideshow_id);
            $('.linecate2').has('#row_'+slideshow_id).css('background-color', '#FFFFE0');
		}
	});
}

function slideshows_delete(slideshow_id)
{
	if(!confirm('Are you sure ?')) {
        return false;
    }
    
	$.post(admin_url+'slideshows/delete/'+slideshow_id, function(msg) {		
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+slideshow_id).fadeOut('slow').remove();
		}
	});
}

function contacts_delete(contact_id)
{
	if(!confirm('Are you sure ?')) {
        return false;
    }
    
	$.post(admin_url+'contacts/delete/'+contact_id, function(msg) {		
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+contact_id).fadeOut('slow').remove();
		}
	});
}

function booking_status(booking_id, status)
{
	$.post(admin_url+'booking/change_status', 'booking_id='+booking_id+'&status='+status, function(msg) {		
		if(msg == "yes") {
			load_content('row_'+booking_id, admin_url+'booking/load_row/'+booking_id);
            $('.linecate2').has('#row_'+booking_id).css('background-color', '#FFFFE0');
		}
	});
}

function booking_delete(booking_id)
{
	if(!confirm('Are you sure ?')) {
	        return false;
	    }
	    
	$.post(admin_url+'booking/delete/'+booking_id, function(msg) {		
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+booking_id).fadeOut('slow').remove();
		}
	});
}

function html_status(html_id, status)
{
	$.post(admin_url+'html/change_status', 'html_id='+html_id+'&status='+status, function(msg) {		
		if(msg == "yes") {
			load_content('row_'+html_id, admin_url+'html/load_row/'+html_id);
            $('.linecate2').has('#row_'+html_id).css('background-color', '#FFFFE0');
		}
	});
}

function html_delete(html_id)
{
	if(!confirm('Are you sure ?')) {
	        return false;
	    }
	    
	$.post(admin_url+'html/delete/'+html_id, function(msg) {		
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+html_id).fadeOut('slow').remove();
		}
	});
}

function articles_status(articles_id, status)
{
	$.post(admin_url+'articles/change_status', 'articles_id='+articles_id+'&status='+status, function(msg) {		
		if(msg == "yes") {
			load_content('row_'+articles_id, admin_url+'articles/load_row/'+articles_id);
            $('.linecate2').has('#row_'+articles_id).css('background-color', '#FFFFE0');
		}
	});
}

function article_delete(articles_id)
{
	if(!confirm('Are you sure ?')) {
        return false;
    }
    
	$.post(admin_url+'articles/delete/'+articles_id, function(msg) {		
		if(msg == "yes") {
			$('#row_'+articles_id).css('display','none');
		}
	});
}

function product_type_status(product_type_id, status)
{	
	$.post(admin_url+'product_type/change_status', 'product_type_id='+product_type_id+'&status='+status, function(msg) {
		if(msg == "yes") {
			load_content('row_'+product_type_id, admin_url+'product_type/load_row/'+product_type_id);
            $('.linecate2').has('#row_'+product_type_id).css('background-color', '#FFFFE0');
		}
	});
}

function product_type_delete(product_type_id)
{
    if(!confirm('Are you sure ?')) {
        return false;
    }
    
	$.post(admin_url+'product_type/delete/'+product_type_id, function(msg) {		
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+product_type_id).fadeOut('slow').remove();
		}
	});
}

function product_status(product_id, status)
{
	$.post(admin_url+'products/change_status', 'product_id='+product_id+'&status='+status, function(msg) {
		if(msg == "yes") {
			load_content('row_'+product_id, admin_url+'products/load_row/'+product_id);
            $('.linecate2').has('#row_'+product_id).css('background-color', '#FFFFE0');
		}
	});
}

function product_hot(product_id, status)
{
	$.post(admin_url+'products/change_hot', 'product_id='+product_id+'&status='+status, function(msg) {
		if(msg == "yes") {
			load_content('row_'+product_id, admin_url+'products/load_row/'+product_id);
            $('.linecate2').has('#row_'+product_id).css('background-color', '#FFFFE0');
		}
	});
}

function product_best_sales(product_id, status)
{
	$.post(admin_url+'products/change_best_sales', 'product_id='+product_id+'&status='+status, function(msg) {
		if(msg == "yes") {
			load_content('row_'+product_id, admin_url+'products/load_row/'+product_id);
            $('.linecate2').has('#row_'+product_id).css('background-color', '#FFFFE0');
		}
	});
}

function product_delete(product_id)
{
    if(!confirm('Are you sure ?')) {
        return false;
    }
    
	$.post(admin_url+'products/delete/'+product_id, function(msg) {
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+product_id).fadeOut('slow').remove();
		}
	});
}

function company_status(company_id, status)
{	
	$.post(admin_url+'company/change_status', 'company_id='+company_id+'&status='+status, function(msg) {		
		if(msg == "yes") {
			load_content('row_'+company_id, admin_url+'company/load_row/'+company_id);
            $('.linecate2').has('#row_'+company_id).css('background-color', '#FFFFE0');
		}
	});
}

function company_delete(company_id)
{
    if(!confirm('Are you sure ?')) {
        return false;
    }
    
	$.post(admin_url+'company/delete/'+company_id, function(msg) {
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+company_id).fadeOut('slow').remove();
		}
	});
}

function news_delete(id, type)
{
    if(!confirm('Are you sure ?')) {
        return false;
    }
    
	$.post(admin_url+'news/delete', 'id='+id+'&type='+type, function(msg) {
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+id).fadeOut('slow').remove();
		}
	});
}

function user_status(user_id, status)
{
	$.post(admin_url+'user/change_status', 'user_id='+user_id+'&status='+status, function(msg) {
		if(msg == "yes") {
			load_content('row_'+user_id, admin_url+'user/load_row/'+user_id);
            $('.linecate2').has('#row_'+user_id).css('background-color', '#FFFFE0');
		}
	});
}

function member_status(user_id, status)
{
	$.post(admin_url+'user_member/change_status', 'user_id='+user_id+'&status='+status, function(msg) {
		if(msg == "yes") {
			load_content('row_'+user_id, admin_url+'user_member/load_row/'+user_id);
            $('.linecate2').has('#row_'+user_id).css('background-color', '#FFFFE0');
		}
	});
}

function member_delete(user_id)
{
    if(!confirm('Are you sure ?')) {
        return false;
    }
    
	$.post(admin_url+'user_member/delete/', 'id='+user_id, function(msg) {
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+user_id).fadeOut('slow').remove();
		}
	});
}

function user_delete(user_id)
{
    if(!confirm('Are you sure ?')) {
        return false;
    }
    
	$.post(admin_url+'user/delete/', 'id='+user_id, function(msg) {
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+user_id).fadeOut('slow').remove();
		}
	});
}

function email_status(id, status)
{
	$.post(admin_url+'email_temp/change_status', 'id='+id+'&status='+status, function(msg) {
		if(msg == "yes") {
			load_content('row_'+id, admin_url+'email_temp/load_row/'+id);
            $('.linecate2').has('#row_'+id).css('background-color', '#FFFFE0');
		}
	});
}

function email_delete(id)
{
    if(!confirm('Are you sure ?')) {
        return false;
    }
    
	$.post(admin_url+'email_temp/delete/', 'id='+id, function(msg) {
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+id).fadeOut('slow').remove();
		}
	});
}

function destination_status(id, status)
{
	$.post(admin_url+'destination/change_status', 'id='+id+'&status='+status, function(msg) {
		if(msg == "yes") {
			load_content('row_'+id, admin_url+'destination/load_row/'+id);
            $('.linecate2').has('#row_'+id).css('background-color', '#FFFFE0');
		}
	});
}

function destination_delete(id)
{
    if(!confirm('Are you sure ?')) {
        return false;
    }
    
	$.post(admin_url+'destination/delete/', 'id='+id, function(msg) {
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+id).fadeOut('slow').remove();
		}
	});
}

function load_content(div_return, url)
{	
	var waiting = false;
	if(arguments[2] == true) waiting = true;
	if(waiting == true) $('#waiting').show();
	
	$("#"+div_return).load(url, function() {
    	$('#waiting').fadeOut();
	});
}

function add_more_image()
{
	var new_image = '<li>';
		new_image += '<span class="left">&nbsp;</span>';
		new_image += '<span class="right">';
		new_image += '<input type="file" name="images[]" value="" />';
		new_image += '</span>';
		new_image += '</li>';
	$('#add_more').before(new_image);
}

function content_filter(url)
{
    keyword = $('#keyword').val();
    if(keyword == 'Keyword') keyword = '';
	window.location.href = url + '?keyword='+keyword+'&cat_id='+$('#cat_id').val();
}

function close_light()
{
	$('#light_adct, #fade_adct').hide();
	return false;
}

function partners_status(articles_id, status)
{
	$.post(admin_url+'partners/change_status', 'articles_id='+articles_id+'&status='+status, function(msg) {		
		if(msg == "yes") {
			load_content('row_'+articles_id, admin_url+'partners/load_row/'+articles_id);
            $('.linecate2').has('#row_'+articles_id).css('background-color', '#FFFFE0');
		}
	});
}

function partners_delete(articles_id)
{
	if(!confirm('Are you sure ?')) {
        return false;
    }
    
	$.post(admin_url+'partners/delete/'+articles_id, function(msg) {		
		if(msg == "yes") {
			$('div.linecate2').has('#row_'+articles_id).fadeOut('slow').remove();
		}
	});
}
