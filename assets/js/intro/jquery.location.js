$(document).ready(function () {

    function initialize() {
        var location        = new google.maps.LatLng(37.3394471,126.73511069999995);
        var options         = {center: location, zoom: 18, mapTypeId: google.maps.MapTypeId.ROADMAP};

        var map             = new google.maps.Map(document.getElementById("map"), options);

        var pinColor        = "FE7569";
        var marker          = new google.maps.Marker({map: map, 
                                                      position: location, 
                                                      icon: new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
                                                      new google.maps.Size(64, 64),
                                                      new google.maps.Point(0, 0),
                                                      new google.maps.Point(0, 24))});
    }

    google.maps.event.addDomListener(window, 'load', initialize);
} );