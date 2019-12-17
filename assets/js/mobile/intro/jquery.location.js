$(document).on("pageshow", function(event,data){
    var defaultLatLng = new google.maps.LatLng(37.3394471,126.73511069999995);  // Default to Hollywood, CA when no geolocation support
    if ( navigator.geolocation ) {
	        function success(pos) {
            // Location found, show map with these coordinates
            drawMap(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
        }
        function fail(error) {
            drawMap(defaultLatLng);  // Failed to find location, show default map
        }
        // Find the users current position.  Cache the location for 5 minutes, timeout after 6 seconds
        navigator.geolocation.getCurrentPosition(success, fail, {maximumAge: 500000, enableHighAccuracy:true, timeout: 6000});
    } else {
        drawMap(defaultLatLng);  // No geolocation support, show default map
    }

    function drawMap(latlng) {
	        var myOptions = {
		            zoom: 19,
		            center: latlng,
		            mapTypeId: google.maps.MapTypeId.ROADMAP
	        };
	        var map = new google.maps.Map(document.getElementById("map"), myOptions);
        // Add an overlay to the map of current lat/lng
        var marker = new google.maps.Marker({
	            position: latlng,
	            map: map,
	            title: "Greetings!"
        });
    }
});