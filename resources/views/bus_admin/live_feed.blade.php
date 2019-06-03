@extends('layouts.base')

@section('title', 'Live Results')

@section('content')
            <div id="map" ></div> 
@endsection

@section('map')
<style type="text/css">
#map {
  position: initial !important;
}
  
</style>

<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyBFej8wK0uBBxVPLgdD0z5yBPb5xsYLkcE&callback=initMap"></script>
<script src="https://code.jquery.com/jquery.min.js"></script>
<script src="{{ asset('vendor/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('vendor/markerAnimate.js') }}"></script>
<script src="{{ asset('js/SlidingMarker.js') }}"></script>
    <script>
      var track_markers = []; // Create a marker array to hold your markers

      /*var customLabel = {
        restaurant: {
          label: 'BUS'
        },
        bar: {
          label: 'B'
        }
      };*/

        function initMap() {

            var map = new google.maps.Map(document.getElementById('map'), {
              center: new google.maps.LatLng(0.33783125, 32.56834694),
              zoom: 15
            });
            var infoWindow = new google.maps.InfoWindow;
            var markers;
            // Change this depending on the name of your PHP or XML file
            downloadUrl('{{ url('xml_feed') }}', function(data) {
              var xml = data.responseXML;
              var markers = xml.documentElement.getElementsByTagName('marker');
              // Reset the markers array
              track_markers = [];          
              Array.prototype.forEach.call(markers, function(markerElem) {
                var id = markerElem.getAttribute('id');
                var name = markerElem.getAttribute('bus_name');
                var address = markerElem.getAttribute('address');
                var type = markerElem.getAttribute('type');
                var point = new google.maps.LatLng(
                    parseFloat(markerElem.getAttribute('lat')),
                    parseFloat(markerElem.getAttribute('lng')));

                var infowincontent = document.createElement('div');
                var strong = document.createElement('strong');
                strong.textContent = name
                infowincontent.appendChild(strong);
                infowincontent.appendChild(document.createElement('br'));

                var text = document.createElement('text');
                text.textContent = address
                infowincontent.appendChild(text);
                var icon = 'icons8-bus-30-blue.png';
                var flag = markerElem.getAttribute('flag');

                if(flag == 1){
                  icon = 'icons8-bus-20-red.png';
                }
                var marker = new SlidingMarker({
                  id: id,
                  map: map,
                  position: point,
                  label: icon.label,                  
                  icon: '{{ asset('+icon+') }}'
                });
                track_markers.push(marker);
                marker.addListener('click', function() {
                  infoWindow.setContent(infowincontent);
                  infoWindow.open(map, marker);
                });
              });
            });
            setInterval(function() {
              downloadUrl('{{ url('xml_feed') }}', function(data) {
                var xml = data.responseXML;
                var markers = xml.documentElement.getElementsByTagName('marker');
                Array.prototype.forEach.call(markers, function(markerElem) {
                  var id = markerElem.getAttribute('id');
                  var flag = markerElem.getAttribute('flag');
                  var point = new google.maps.LatLng(
                      parseFloat(markerElem.getAttribute('lat')),
                      parseFloat(markerElem.getAttribute('lng')));

                  for (var i=0; i<track_markers.length; i++) {                    
                      if(track_markers[i].id == id) {
                        track_markers[i].setDuration(500);
                        track_markers[i].setEasing($.easing.easeInExpo);
                        if(flag == 1 ) {
                          track_markers[i].setIcon('{{ asset('icons8_bus_30_red.png') }}');
                        } else {
                          track_markers[i].setIcon('{{ asset('icons8_bus_30_blue.png') }}');                          
                        }
                        track_markers[i].setPosition(point);
                      }
                  }

                });
              });              
            }, 2000);
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
        $(function() {initMap();});
    </script>

@endsection
