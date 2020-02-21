var geocoder;
  var map;
  var infowindow = new google.maps.InfoWindow();
  var marker = new Array();
  var elevator;
  var directionsDisplay;
  var directionsService = new google.maps.DirectionsService();
  var noResolvedAddress = 'Sin dirección resuelta';

function IniciarCoordenadas() {
    var input = document.getElementById('txt_direccion');
    var options = {
    };
    autocomplete = new google.maps.places.Autocomplete(input, options);  
    directionsDisplay = new google.maps.DirectionsRenderer();
    
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-33.458379, -70.611687);
    var myOptions = {
      zoom: 10,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), {
          // center: {lat: latitude, lng: longitude},
          center: latlng,
          zoom: 10,
          mapTypeControl: false,
          disableDefaultUI: false, // le dejamos solo el mapa por default
          styles: [
            {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
            {
              featureType: 'administrative.locality',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'geometry',
              stylers: [{color: '#263c3f'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'labels.text.fill',
              stylers: [{color: '#6b9a76'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry',
              stylers: [{color: '#38414e'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry.stroke',
              stylers: [{color: '#212a37'}]
            },
            {
              featureType: 'road',
              elementType: 'labels.text.fill',
              stylers: [{color: '#9ca5b3'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry',
              stylers: [{color: '#746855'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry.stroke',
              stylers: [{color: '#1f2835'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'labels.text.fill',
              stylers: [{color: '#f3d19c'}]
            },
            {
              featureType: 'transit',
              elementType: 'geometry',
              stylers: [{color: '#2f3948'}]
            },
            {
              featureType: 'transit.station',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{color: '#17263c'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{color: '#515c6d'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.stroke',
              stylers: [{color: '#17263c'}]
            }
          ]
        });
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("directionsPanel"));
    
 
    
    elevator = new google.maps.ElevationService();
    
    google.maps.event.addListener(map, 'click', codeLatLngfromclick);
    
    google.maps.event.addListener(marker[0], 'dragend', function(evt){
    var lat = evt.latLng.lat();
    var lng = evt.latLng.lng();
    var latlng = new google.maps.LatLng(lat, lng);
    
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
          marker[0].setPosition( results[0].geometry.location );
          infowindow.setContent('<div id="info_window"><strong>Dirección :</strong> <span id="geocodedDest">' + results[0].formatted_address + '</span><br/><strong>Latitud :</strong> ' + Math.round(lat*1000000)/1000000 + ' | <strong>Longitud :</strong> ' + Math.round(lng*1000000)/1000000 + '<br/><br/><span id="buttonSet"><button type="button" class="btn btn-primary" onclick="setDest(' + lat + ',' + lng + ')">Establecer como destino</button></span>' + bookmark() + '</div>');
          infowindow.open(map, marker[0]);
        }
      } else {
          marker[0].setPosition( results[0].geometry.location );
          infowindow.setContent('<div id="info_window"><strong>Dirección :</strong> <span id="geocodedDest">' + noResolvedAddress + '</span><br/><strong>Latitud :</strong> ' + Math.round(lat*1000000)/1000000 + ' | <strong>Longitud :</strong> ' + Math.round(lng*1000000)/1000000 + '<br/><br/><span id="buttonSet"><button type="button" class="btn btn-primary" onclick="setDest(' + lat + ',' + lng + ')">Establecer como destino</button></span>' + bookmark() + '</div>');
          infowindow.open(map, marker[1]);
      }
    });
    
    });
        
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      
    });
  }

function BuscarCoordenadasDirecion(){
    var address = document.getElementById("txt_direccion").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            if (marker[1] != null) marker[1].setMap(null);
                marker[1] = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            latres = results[0].geometry.location.lat();;
            lngres = results[0].geometry.location.lng();
            infowindow.setContent('<div id="info_window"><strong>Origen :</strong> <span id="geocodedAddress">' + document.getElementById("txt_direccion").value + '</span><br/><strong>Latitud :</strong> ' + Math.round(latres*1000000)/1000000 + ' | <strong>Longitud :</strong> ' + Math.round(lngres*1000000)/1000000 + bookmark() + '</div>'  );
            infowindow.open(map, marker[1]);
            document.getElementById("txt_latitud").value=latres;
            document.getElementById("txt_longitud").value=lngres;
            bookUp(document.getElementById("txt_direccion").value, latres, lngres);
            $("#map_canvas").html(""); 
            initMap();
        } else {
            document.getElementById("txt_direccion").value="";
            document.getElementById("txt_latitud").value="";
            document.getElementById("txt_longitud").value="";
            alertify.error("Error de codificación geográfica"+ status);
            $("#map_canvas").html(""); 
        }
    });
}

  function BuscarCoordenadasLatLon(origin){
    var lat = document.getElementById("txt_latitud").value;
    var lng = document.getElementById("txt_longitud").value;
    if(lat!="" && lng!=""){
      var latlng = new google.maps.LatLng(lat, lng);
      //if (origin==1) ddversdms();
      geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
          if (marker[1] != null) marker[1].setMap(null);
            marker[1] = new google.maps.Marker({
              position: latlng,
              map: map
            });
            infowindow.setContent('<div id="info_window"><strong>Origen :</strong> <span id="geocodedAddress">' + results[0].formatted_address + '</span><br/><strong>Latitud :</strong> ' + Math.round(lat*1000000)/1000000 + ' | <strong>Longitud :</strong> ' + Math.round(lng*1000000)/1000000 + bookmark() + '</div>');
            infowindow.open(map, marker[1]);
            document.getElementById("txt_direccion").value=results[0].formatted_address;
            bookUp(document.getElementById("txt_direccion").value, lat, lng);
            $("#map_canvas").html(""); 
            initMap(); 
          }
        }else{
          if (marker[1] != null) marker[1].setMap(null);
          marker[1] = new google.maps.Marker({
                position: latlng,
                map: map
            });
            infowindow.setContent('<div id="info_window"><strong>Origen :</strong> <span id="geocodedAddress">' + noResolvedAddress + '</span><br/><strong>Latitud :</strong> ' + Math.round(lat*1000000)/1000000 + ' | <strong>Longitud :</strong> ' + Math.round(lng*1000000)/1000000 + bookmark() + '</div>');
            infowindow.open(map, marker[1]);
          document.getElementById("txt_direccion").value=noResolvedAddress;
          bookUp(document.getElementById("txt_direccion").value, lat, lng);
          document.getElementById("txt_direccion").value="";
          document.getElementById("txt_latitud").value="";
          document.getElementById("txt_longitud").value="";
          alertify.error("Error de codificación geográfica"+ status);
          $("#map_canvas").html("");          
        }
      });
      map.setCenter(latlng);
    }
  }

  function codeLatLngfromclick(event) {
    var lat = event.latLng.lat();
    var lng = event.latLng.lng();
    var latlng = event.latLng;
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
      if (marker[1] != null) marker[1].setMap(null);
      marker[1] = new google.maps.Marker({
              position: latlng,
              map: map
          });
          map.setCenter(latlng);
      infowindow.setContent('<div id="info_window"><strong>Dirección :</strong> <span id="geocodedAddress">' + results[0].formatted_address + '</span><br/><strong>Latitud :</strong> ' + Math.round(lat*1000000)/1000000 + ' | <strong>Longitud :</strong> ' + Math.round(lng*1000000)/1000000 + '<br/><br/><span id="buttonSet"><button type="button" class="btn btn-primary" onclick="setStart(' + lat + ',' + lng + ')">Establecer como origen</button></span>' + bookmark() + '</div>');
          infowindow.open(map, marker[1]);
          bookUp(results[0].formatted_address, lat, lng);
        }
      } else {
      if (marker[1] != null) marker[1].setMap(null);
      marker[1] = new google.maps.Marker({
              position: latlng,
              map: map
          });
          map.setCenter(latlng);
      infowindow.setContent('<div id="info_window"><strong>Dirección :</strong> <span id="geocodedAddress">' + noResolvedAddress + '</span><br/><strong>Latitud :</strong> ' + Math.round(lat*1000000)/1000000 + ' | <strong>Longitud :</strong> ' + Math.round(lng*1000000)/1000000 + '<br/><br/><span id="buttonSet"><button type="button" class="btn btn-primary" onclick="setStart(' + lat + ',' + lng + ')">Establecer como origen</button></span>' + bookmark() + '</div>');
          infowindow.open(map, marker[1]);
          bookUp(noResolvedAddress, lat, lng);
    alert("Error de codificación geográfica: " + status);
    
      }
    });
  }

  function findMe(){
      var output = document.getElementById('map_canvas');
      
      if (!navigator.geolocation) {
       output.innerHTML = "<p>Tu navegador no soporta Geolocalizacion</p>";
      }
      //Obtenemos latitud y longitud
      function localizacion(posicion){
        var latitude = document.getElementById("txt_latitud").value;
        var longitude = document.getElementById("txt_longitud").value;
        var imgURL = "https://maps.googleapis.com/maps/api/staticmap?center="+latitude+","+longitude+"&zoom=11&size=1200x800&markers=color:red%7C"+latitude+","+longitude+"&key=AIzaSyC4Zt12Kgpaar2fMBofnlnslSF9cvG6F5M";
        output.innerHTML ="<img src='"+imgURL+"' style='width: 100%; height: 100%;'>";
      }

      function error(){
        output.innerHTML = "<p>No se pudo obtener tu ubicación</p>";
      }
      navigator.geolocation.getCurrentPosition(localizacion,error);
  }

   function initMap() {
        var lat = document.getElementById("txt_latitud").value;
        var lng = document.getElementById("txt_longitud").value;
        var latlng = new google.maps.LatLng(lat, lng);
        // var latlng = {lat: -33.458348, lng: -70.6119832}
        map = new google.maps.Map(document.getElementById('map_canvas'), {
          // center: {lat: latitude, lng: longitude},
          center: latlng,
          zoom: 15,
          mapTypeControl: false,
          disableDefaultUI: false, // le dejamos solo el mapa por default
          styles: [
            {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
            {
              featureType: 'administrative.locality',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'geometry',
              stylers: [{color: '#263c3f'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'labels.text.fill',
              stylers: [{color: '#6b9a76'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry',
              stylers: [{color: '#38414e'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry.stroke',
              stylers: [{color: '#212a37'}]
            },
            {
              featureType: 'road',
              elementType: 'labels.text.fill',
              stylers: [{color: '#9ca5b3'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry',
              stylers: [{color: '#746855'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry.stroke',
              stylers: [{color: '#1f2835'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'labels.text.fill',
              stylers: [{color: '#f3d19c'}]
            },
            {
              featureType: 'transit',
              elementType: 'geometry',
              stylers: [{color: '#2f3948'}]
            },
            {
              featureType: 'transit.station',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{color: '#17263c'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{color: '#515c6d'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.stroke',
              stylers: [{color: '#17263c'}]
            }
          ]
        });
         marker[1] = new google.maps.Marker({
              position: latlng,
              map: map
          });
          map.setCenter(latlng);
      }


  function bookmark() {
    return "";
  }
  
  function bookUp(address, latitude, longitude) {
    return false;
  }