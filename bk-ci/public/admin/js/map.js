//Defining some global variables
var map, geocoder, marker, infowindow;
var overlay;

var mapContainer = 'map-container';
var txtAddress = 'txtAddress';

var mapForm = 'formUpload';
var mapLatLng = 'txtMapLatLng';
var mapAddress = 'txtMapAddress';
var mapAddressHTML = 'onMapAddress';

var defaultLat = 21.033840;
var defaultLon = 105.850110;
var defaultZoom = 15;

var domain = window.location.hostname;

/**
 * initial map
 * @return 
 */
function initialize() {
    // Initialize default values
	var zoom = defaultZoom;
	var latlng = new google.maps.LatLng(defaultLat, defaultLon);
	
	//options
	var options = {
		zoom: zoom,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		disableDefaultUI: false,
		mapTypeControl: false,
		mapTypeControlOptions: {
			style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
			position: google.maps.ControlPosition.TOP_RIGHT,
			mapTypeIds:[
			    google.maps.MapTypeId.ROADMAP,
		        google.maps.MapTypeId.SATELLITE,
		        google.maps.MapTypeId.HYBRID,
		        google.maps.MapTypeId.TERRAIN
		   ]
		},
		navigationControl: true,
		navigationControlOptions: {
			position: google.maps.ControlPosition.LEFT,
			style: google.maps.NavigationControlStyle.SMALL//ANDROID//ZOOM_PAN//
		},
		scaleControl: true,
		disableDoubleClickZoom: false,
		draggable: true,
		scrollwheel: false,
		streetViewControl: true

	}
	
	map = new google.maps.Map(document.getElementById(mapContainer), options);
	
	marker = new google.maps.Marker({
	    position: latlng,	    
	    map: map,
	    draggable: true
	  });
	
	// Update current position info.
	updatePosition(latlng);
	
	//update form event
	updateFormEvent();
	
	
	/*// Attaching a click event to the map
	google.maps.event.addListener(map, 'click', function(e) {
		// Getting the address for the position being clicked
		getByLatLng(e.latLng);
	});*/

	// Attaching a click event to the map
	google.maps.event.addListener(marker, 'click', function() {
		// Getting the address for the position being clicked
		getByLatLng(marker.getPosition());
		showInfoWindow();
	});
	// Add dragging event listeners.
	google.maps.event.addListener(marker, 'dragstart', function() {
		//updateMarkerAddress('Dragging...');
		hideInfoWindow();
	});
  
	google.maps.event.addListener(marker, 'drag', function() {
		//updateMarkerStatus('Dragging...');
		updatePosition(marker.getPosition());
	});
  
	google.maps.event.addListener(marker, 'dragend', function() {
		//updateMarkerStatus('Drag ended');
		if (!marker) 
		{				
			marker = new google.maps.Marker({
				map: map
			});
			marker.setPosition(marker.getPosition());
		}
		
		
		geocodePosition(marker.getPosition());
		
		showInfoWindow();
	});
  
	google.maps.event.addListener(map, 'center_changed', onCenterChanged);	
	
	google.maps.event.addListener(map, 'zoom_changed', function(){
		$('#zoom').val(map.getZoom());
	});
	
	//autocomplete address
	$(function() {
	    $("#"+txtAddress).autocomplete({
	      //This bit uses the geocoder to fetch address values
	      source: function(request, response) {
	    	if(!geocoder) {
	    		geocoder = new google.maps.Geocoder();
	    	}
	        geocoder.geocode( {'address': request.term+',vn,Vietnam','region': 'vn','language':'vn'}, function(results, status) {
	          response($.map(results, function(item) {
	            return {
	              label:  item.formatted_address,
	              value: item.formatted_address,
	              latitude: item.geometry.location.lat(),
	              longitude: item.geometry.location.lng()
	            }
	          }));
	        })
	      },
	      
	      //This bit is executed upon selection of an address
	      select: function(event, ui) {	        
	        var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
	        marker.setPosition(location);
	        map.setCenter(location);
	      }
	    });
	  });
}

/**
 * zoom minimum
 */

function onZoomChanged() {
	 if (map.getZoom() < 6){
	       //alert("You cannot zoom out any further");
	       map.setZoom(6);
	    }

}

/**
 * update form events
 * 
 */
function updateFormEvent()
{	
	var form = document.getElementById(mapForm);
	
	// Catching the forms submit event
	form.onsubmit = function() {
		
		var address = document.getElementById(txtAddress).value+',vn';
		
		// Making the Geocoder call
		getByAddress(address);
				
		return false;
	}
	return false;
}
/**
 * update marker status
 */
function updateStatus(str) 
{
	//document.getElementById('markerStatus').innerHTML = str;
}

/**
 * update marker position
 */
function updatePosition(latLng) {
	$('#'+mapLatLng).val(latLng.lat().toFixed(6)+', '+latLng.lng().toFixed(6));
}

/**
 * update marker Address
 */
function updateAddress(str) {
	$('#'+mapAddress).val(str); 
	$('#'+mapAddressHTML).html(str);
}
/**
 *  get Center Lat Long
 */
function getCenterLatLngText() {
    return '(' + map.getCenter().lat() +', '+ map.getCenter().lng() +')';
  }

/**
 * change center event 
 */
function onCenterChanged() {	
    
    var latlng = new google.maps.LatLng(map.getCenter().lat(), map.getCenter().lng());
   
    if (!marker) {      
      marker = new google.maps.Marker({
        map: map
      });
    }
    
    // Setting the position of the marker to the returned location
    marker.setPosition(latlng);
    
    //update position   
    updatePosition(latlng);
    
    //get position by latlng
    getByLatLng(latlng);
    
    //hide info window
    hideInfoWindow();
    return false;
}
/**
 * get address from position
 */
function geocodePosition(pos) {
	if(!geocoder) {
		geocoder = new google.maps.Geocoder();
	}
	
	geocoder.geocode({latLng: pos}, function(responses) {
		if (responses && responses.length > 0) {			
			 var content = responses[0].formatted_address;
			 
			 //update infowindow
			 map.setCenter(pos);
			 updateInfoWindow(content);
		} else {
			//alert('Cannot determine address at this location.');
		}
	});
}

/**
 * update infowindow
 */
function updateInfoWindow(content)
{
	// Check to see if we've already got an InfoWindow object
    if (!infowindow) {
      // Creating a new InfoWindow
      infowindow = new google.maps.InfoWindow();
    }
    
    var contentHTML = 	'<div id="info">' +						    
						    '<h3>'+content+'</h3>' +
						    '<div id="controls"><a href="javascript:;" style="float:none;padding-bottom:0px;" title="Lưu lại" onclick="$(\'#saveMap\').click();"><img src="http://'+domain+'/public/themes/rc/images/save_map_1.gif" title="Lưu lại" alt="Lưu lại"></a></div>' +						    
					    '</div>';

    // Adding the content to the InfoWindow
    /*content = content + '<div style="margin-top:0px;"><a href="#" style="float:none;padding-bottom:0px;" title="Lưu lại" onclick="$(\'#saveMap\').click();"><img src="http://'+domain+'/public/themes/rc/images/save_map_1.gif" title="Lưu lại" alt="Lưu lại"></a>';
    content = content + '</div>';*/
    
    infowindow.setContent(contentHTML);
        
    return false;
}

/**
 * show infowindow
 */
function showInfoWindow()
{
	// Check to see if we've already got an InfoWindow object
    if (!infowindow) {
      // Creating a new InfoWindow
      infowindow = new google.maps.InfoWindow();
    }
        
    // Opening the InfoWindow
    infowindow.open(map, marker);
}

/**
 * hide infowindow
 */
function hideInfoWindow()
{
	// Check to see if we've already got an InfoWindow object
    if (!infowindow) {
      // Creating a new InfoWindow
      infowindow = new google.maps.InfoWindow();
    }
        
    infowindow.close();
}

/**
 * get position by address
 */
function getByAddress(address) {	
	if(!geocoder) 
	{
		geocoder = new google.maps.Geocoder();		
	}
	
	var geocoderRequest = 
	{
		address: address,
		'region':'vn'
	}
	
	// Making the Geocode request
	geocoder.geocode(geocoderRequest, function(results, status) {		
		if (status == google.maps.GeocoderStatus.OK) 
		{						
			map.setCenter(results[0].geometry.location);
			
			if (!marker) 
			{				
				marker = new google.maps.Marker({
					map: map
				});
			}
			
			marker.setPosition(results[0].geometry.location);
			
			geocodePosition(marker.getPosition());
			
			var content = results[0].formatted_address;			
			updateInfoWindow(content);
			
			updateAddress(results[0].formatted_address);
		}
	});
}

/**
 * get address by position
 */
function getByLatLng(latLng) {	  
	  if (!geocoder) {
	    geocoder = new google.maps.Geocoder();
	  }
	  
	  var geocoderRequest = {
	    latLng: latLng
	  }
	  
	  geocoder.geocode(geocoderRequest, function(results, status){
		  if (!infowindow) 
		  {
			  infowindow = new google.maps.InfoWindow();			  
		  }
		  
		  infowindow.setPosition(latLng);
		  
		  if (status == google.maps.GeocoderStatus.OK) {
	      // Looping through the result
	      //for (var i = 0; i < results.length; i++) {
	        if (results[0].formatted_address) {
	        	var content = results[0].formatted_address;//latLng.toUrlValue()
	        	updateInfoWindow(content);	        	
	    	    //infowindow.setContent(content);
	    	    
	    	    //infowindow.open(map);
	    	    
	    	    updateAddress(results[0].formatted_address);
	        }
	      //}
		  }
		  
		  else {
			  content += '<div>No address could be found. Status = ' + status + '</div>';
			  
		  }
		  
	  });
	  
	  return false;
	  
	}

/*
function initialize() {
  var myLatlng = new google.maps.LatLng(-34.397, 150.644);
  var myOptions = {
    zoom: 8,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(document.getElementById("smapContainer"), myOptions);
  //$('#showMapPopup').click();
}*/
  
/*function loadScript() {
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
  document.body.appendChild(script);
}
*/  
//window.onload = initialize;
