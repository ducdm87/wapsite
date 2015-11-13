$(function () {	
	$('#check_all_01').click(function () {
		var status = $(this).attr('checked');
		$('input[type=checkbox]').attr('checked', status);
	});
	
	$('#check_all_02').click(function () {
		var status = $(this).attr('checked');
		$('input[type=checkbox]').attr('checked', status);
	});
	
	$('#act_button').click(function() {
	  var act = $('#act').val();
	  $('#list_order').append("<input type='hidden' value='"+act+"' name='act' />");
	  $('#list_order').submit();
	});
	$('#num_record_display').change(function() {
		var num_record_display = $('#num_record_display').val();
		alert('We are building!!!!');
	});
	$('#filter_button').click(function() {
		var keys = $('#keys').val();
		var id_select = $('#id_select').val();
		var base_url = $('#base_url').val();
		window.location = base_url + "?key=" + keys + "&field=" + id_select;
	});
	$('.btn').click(function(){
		$('#light').hide();
		$('#fade').hide();
	});
	$('#add_new_customer').click(function() {
		var base_url = $('#base_url').val();
		window.location = base_url+'?op=new_customer';
	});
	$('#add_new_order').click(function() {
		var base_url = $('#base_url').val();
		window.location = base_url;
	});
});
function closeForm(){
	$("#messageSent").show("slow");
	setTimeout('$("#messageSent").hide();$("#contactForm").slideD("slow");$("#contactLink").slideUp("slow");', 1000);
}

function view_cus(url)
{
	$('h2').text('View customer');
	$('#light').show();
	$('#fade').show();
	$('#content').load(url);
	$('.btarticle').hide();
}

function del_cus(url)
{
	$('h2').text('Are you sure?');
	$('#light').show();
	$('#fade').show();
	$('#content').load(url);
	$('.btarticle').hide();	
}

function edit_cus(url, cus_id)
{
	$('h2').text('Edit customer');
	$('.btarticle').show();
	$('#light').show();
	$('#fade').show();
	$('#content').load(url);
	$('#edit_cus').append("<input type='hidden' value='"+cus_id+"' name='cus_id' />");
}

function view_my_order(url, order_id)
{
	$('h2').text('View order: '+order_id);
	$('#light').show();
	$('#fade').show();
	$('#content').removeClass('contactForm2');
	$('#content').addClass('editcate_ct');
	$('#content').load(url);
}

/*calender*/
(function() {
    var Dom = YAHOO.util.Dom,
        Event = YAHOO.util.Event,
        cal1,
        over_cal = false,
        cur_field = '';

    var init = function() {
        cal1 = new YAHOO.widget.Calendar("cal1","cal1Container");
        cal1.selectEvent.subscribe(getDate, cal1, true);
        cal1.renderEvent.subscribe(setupListeners, cal1, true);
        Event.addListener(['cal1Date1', 'cal1Date2', 'cal1Date3'], 'focus', showCal);
        Event.addListener(['cal1Date1', 'cal1Date2', 'cal1Date3'], 'blur', hideCal);
        cal1.render();
        dp.SyntaxHighlighter.HighlightAll('code'); 
    }

    var setupListeners = function() {
        Event.addListener('cal1Container', 'mouseover', function() {
            over_cal = true;
        });
        Event.addListener('cal1Container', 'mouseout', function() {
            over_cal = false;
        });
    }

    var getDate = function() {
            var calDate = this.getSelectedDates()[0];
            calDate = (calDate.getMonth() + 1) + '/' + calDate.getDate() + '/' + calDate.getFullYear();
            cur_field.value = calDate;            
            over_cal = false;
            hideCal();
    }

    var showCal = function(ev) {
        var tar = Event.getTarget(ev);
        cur_field = tar;
    
        var xy = Dom.getXY(tar),
            date = Dom.get(tar).value;
        if (date) {
            cal1.cfg.setProperty('selected', date);
            cal1.cfg.setProperty('pagedate', new Date(date), true);
        } else {
            cal1.cfg.setProperty('selected', '');
            cal1.cfg.setProperty('pagedate', new Date(), true);
        }
        cal1.render();
        Dom.setStyle('cal1Container', 'display', 'block');
        xy[1] = xy[1] + 20;
        Dom.setXY('cal1Container', xy);
    }

    var hideCal = function() {
        if (!over_cal) {
            Dom.setStyle('cal1Container', 'display', 'none');
        }
    }

    Event.addListener(window, 'load', init);

})();

