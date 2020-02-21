<main class="main">
          

<!DOCTYPE html>
<html>
    <head>
                <link rel="canonical" href="https://www.coordenadas-gps.com/latitud-longitud/-33.458379/-70.611687/10/roadmap" />        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="description" content="Google map personalizado con una latitud de -33.458379 y longitud de -70.611687. Obtener direcciones para manejo, ciclismo, tránsito y peatones.
">
        <title>Google map personalizado | latitud: -33.458379, longitud: -70.611687
</title>
        <link rel="stylesheet" href="/css/maps.css" type="text/css" />
                    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css" />
            <link rel="stylesheet" href="/css/gps-coordinates.css" type="text/css" />
                <link rel="icon" type="image/x-icon" href="/favicon.ico?v1" />
        <link rel="apple-touch-icon" href="/apple-touch-icon.png?v1">
        
                <script>var loaderUrl = "/images/loader.gif";</script>
        <script>
if ( window.self !== window.top ) {
    window.top.location.href=window.location.href;
}        </script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="/js/html5shiv.js"></script>
        <script src="/js/respond.min.js"></script>

        <![endif]-->
                
        <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyC4Zt12Kgpaar2fMBofnlnslSF9cvG6F5M&language=es&libraries=places"></script>
<script>
var geocoder;
  var map;
  var infowindow = new google.maps.InfoWindow();
  var marker = new Array();
  var elevator;
  var directionsDisplay;
  var directionsService = new google.maps.DirectionsService();
  var noResolvedAddress = 'Sin dirección resuelta';

function initialize() {
    var input = document.getElementById('address');
    var inputDest = document.getElementById('addressDest');
    var options = {
    };
    autocomplete = new google.maps.places.Autocomplete(input, options);  
    autocompleteDest = new google.maps.places.Autocomplete(inputDest, options);  
    directionsDisplay = new google.maps.DirectionsRenderer();
    
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-33.458379, -70.611687);
    var myOptions = {
      zoom: 10,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("directionsPanel"));
    
    marker[0] = new google.maps.Marker({
    position: latlng,
    map: map,
    draggable: true
    });
    
    document.getElementById("latitudeDest").value=-33.458379;
    document.getElementById("longitudeDest").value=-70.611687;
    
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
      
      if (status == google.maps.GeocoderStatus.OK) {
        
    if (results[0]) {
      infowindow.setContent('<div id="info_window"><strong>Destino :</strong> ' + results[0].formatted_address + '<br/><strong>Latitud :</strong> ' + Math.round(document.getElementById('latitudeDest').value*1000000)/1000000 + ' | <strong>Longitud :</strong> ' + Math.round(document.getElementById('longitudeDest').value*1000000)/1000000  + bookmark() + '</div>');
          infowindow.open(map, marker[0]);
      document.getElementById("addressDest").value=results[0].formatted_address;
      bookUp(results[0].formatted_address, document.getElementById('latitudeDest').value, document.getElementById('longitudeDest').value);
        }
      } else {
          infowindow.setContent('<div id="info_window"><strong>Destino :</strong> ' + 'Sin dirección resuelta' + '<br/><strong>Latitud :</strong> ' + Math.round(document.getElementById('latitudeDest').value*1000000)/1000000 + ' | <strong>Longitud :</strong> ' + Math.round(document.getElementById('longitudeDest').value*1000000)/1000000 + bookmark() + '</div>');
          infowindow.open(map, marker[0]);
      document.getElementById("addressDest").value='Sin dirección resuelta';
      bookUp('No resolved address', document.getElementById('latitudeDest').value, document.getElementById('longitudeDest').value);
      }
    });
  }

  function codeAddress() {
    var address = document.getElementById("address").value;
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
        infowindow.setContent('<div id="info_window"><strong>Origen :</strong> <span id="geocodedAddress">' + document.getElementById("address").value + '</span><br/><strong>Latitud :</strong> ' + Math.round(latres*1000000)/1000000 + ' | <strong>Longitud :</strong> ' + Math.round(lngres*1000000)/1000000 + bookmark() + '</div>'  );
        infowindow.open(map, marker[1]);
    document.getElementById("latitude").value=latres;
    document.getElementById("longitude").value=lngres;
        bookUp(document.getElementById("address").value, latres, lngres);
    //ddversdms();
      } else {
        alert("Error de codificación geográfica: " + status);
      }
    });
  }

  function codeAddressDest() {
    var addressDest = document.getElementById("addressDest").value;
    geocoder.geocode( { 'address': addressDest}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
    marker[0].setPosition( results[0].geometry.location );
    latres = results[0].geometry.location.lat();;
    lngres = results[0].geometry.location.lng();
        infowindow.setContent('<div id="info_window"><strong>Destino :</strong>' + document.getElementById("address").value + '<br/><strong>Latitud :</strong> ' + Math.round(latres*1000000)/1000000 + ' | <strong>Longitud :</strong> ' + Math.round(lngres*1000000)/1000000 + bookmark() + '</div>'  );
        infowindow.open(map, marker[0]);
    document.getElementById("latitudeDest").value=latres;
    document.getElementById("longitudeDest").value=lngres;
        bookUp(document.getElementById("address").value, latres, lngres);
    //ddversdms();
      } else {
        alert("Error de codificación geográfica: " + status);
      }
    });
  }
  
  function codeLatLng(origin) {
    var lat = parseFloat(document.getElementById("latitude").value);
    var lng = parseFloat(document.getElementById("longitude").value);
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
      document.getElementById("address").value=results[0].formatted_address;
          bookUp(document.getElementById("address").value, lat, lng);
        }
      } else {
      if (marker[1] != null) marker[1].setMap(null);
      marker[1] = new google.maps.Marker({
              position: latlng,
              map: map
          });
          infowindow.setContent('<div id="info_window"><strong>Origen :</strong> <span id="geocodedAddress">' + noResolvedAddress + '</span><br/><strong>Latitud :</strong> ' + Math.round(lat*1000000)/1000000 + ' | <strong>Longitud :</strong> ' + Math.round(lng*1000000)/1000000 + bookmark() + '</div>');
          infowindow.open(map, marker[1]);
      document.getElementById("address").value=noResolvedAddress;
          bookUp(document.getElementById("address").value, lat, lng);
    alert("Error de codificación geográfica: " + status);
      }
    });
    map.setCenter(latlng);
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
      //document.getElementById("address").value=results[0].formatted_address;
      //document.getElementById("latitude").value=lat;
      //document.getElementById("longitude").value=lng;
      //ddversdms();
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
      //document.getElementById("address").value='No resolved address';
      //document.getElementById("latitude").value=lat;
      //document.getElementById("longitude").value=lng;
      //ddversdms();
    alert("Error de codificación geográfica: " + status);
    
      }
    });
  }

function setStart(x,y)
{
  document.getElementById("address").value=document.getElementById("geocodedAddress").innerHTML;
  document.getElementById("latitude").value=x;
  document.getElementById("longitude").value=y;
  document.getElementById("buttonSet").innerHTML="Esta ubicación es su nuevo punto de partida.";
}

function setDest(x,y)
{
  document.getElementById("addressDest").value=document.getElementById("geocodedDest").innerHTML;
  document.getElementById("latitudeDest").value=x;
  document.getElementById("longitudeDest").value=y;
  document.getElementById("buttonSet").innerHTML="Esta ubicación es su nuevo destino.";
}
  
  function directions()
  {
    document.getElementById('directionsPanel').innerHTML = '';
    document.getElementById('loader').innerHTML = '&nbsp;<img src="/images/loader.gif" />';
    var travelMode = document.getElementById("travelMode").value
    var unit = document.getElementById("unit").value
    var highways = document.getElementById("highways").value
    var tolls = document.getElementById("tolls").value    
    var origin = new google.maps.LatLng(document.getElementById("latitude").value,document.getElementById("longitude").value);
    var destination = new google.maps.LatLng(document.getElementById("latitudeDest").value,document.getElementById("longitudeDest").value);
  
    if (travelMode=='Bicycling') travelMode=google.maps.TravelMode.BICYCLING;
    else if (travelMode=='Transit') travelMode=google.maps.TravelMode.TRANSIT;
    else if (travelMode=='Walking') travelMode=google.maps.TravelMode.WALKING;
    else travelMode=google.maps.TravelMode.DRIVING;
    
    if (unit=='Mile') unit=google.maps.UnitSystem.IMPERIAL;
    else unit=google.maps.UnitSystem.METRIC;
    
    if (highways=='Avoid') highways=true;
    else highways = false;
    
    if (tolls=='Avoid') tolls=true;
    else tolls = false;
    
    var request = {
      origin:origin,
      destination:destination,
      travelMode: travelMode,
      unitSystem: unit,
      avoidHighways: highways,
      avoidTolls: tolls
    };
    directionsService.route(request, function(result, status) {
      document.getElementById('loader').innerHTML = '';
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(result);
      }
      else
      {
    document.getElementById('directionsPanel').innerHTML = '<p>Error de cálculo o ruta no válida.</p>';
      }
  });
  }
  
    
  function bookmark() {
            return "";
      }
  
  function bookUp(address, latitude, longitude) {
        return false;
  }
  
  function simulateClick(latitude, longitude) {
    var mev = {
        stop: null,
        latLng: new google.maps.LatLng(latitude, longitude)
    }
    google.maps.event.trigger(map, 'click', mev);
  }

</script>
        
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        
          ga('create', 'UA-51725820-1', 'coordenadas-gps.com');
          ga('set', 'anonymizeIp', true);
          ga('send', 'pageview');
        
        </script>

        <!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
        <script type="text/javascript">
            window.cookieconsent_options = {"message":"Las cookies nos permiten ofrecer nuestros servicios. Al utilizar nuestros servicios, aceptas el uso que hacemos de las cookies.","dismiss":"OK!","learnMore":"Más información","link":null,"theme":"/cookieconsent/light-bottom.css"};
        </script>
        
        <script type="text/javascript" src="/cookieconsent/cookieconsent.js"></script>
        <!-- End Cookie Consent plugin -->
        
    </head>
    <body onload="initialize();">
        
    <!-- Wrap all page content here -->
    <div id="wrap">
                
        <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="clearfix"></div>
                <div class="collapse navbar-collapse">
                    <ul class="nav nav-tabs">
                        <li><a href="/">Inicio</a></li>
                        <li><a href="/google-maps-como-llegar">Como llegar</a></li>
                        <li><a href="/sistema-de-coordenadas">Sistema de Coordenadas</a></li>
                        <li><a href="/convertidor-de-coordenadas-gps">Convertidor</a></li>
                                                <li><a href="/mapa/paises">Mapa de País</a></li>
                        <li><a href="/mapa/estados">Estados</a></li>
                        <li class="active"><a href="/mapa-personalizado">Mapa Personalizado</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
            
      <!-- Begin page content -->
            <div class="container">
            
        <div class="row">
            <div class="col-md-12 pub" id="ad-top">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- coordenadas-gps-top -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-9379737428903517"
             data-ad-slot="1821564984"
             data-ad-format="auto"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
            </div>
        </div>
            
        <div class="page-header">
            <h1>Mapa personalizado</h1>
        <p>
          Cuando la página inicial se haya cargado, este mapa estará centrado en una <strong>ubicación GPS</strong> con latitud -33.458379 y longitud -70.611687<br>
          Este mapa es de tipo ROADMAP y el zoom inicial está establecido en 10.<br>
          Puede obtener direcciones desde cualquier punto hacia el centro inicial en el mapa rellenando su punto de partida en la columna izquierda. Puede usar su dirección,  su longitud y latitud o hacer clic en el mapa para especificar su ubicación.<br>
          También puede cambiar el punto de llegada arrastrando el marcador y estableciéndolo  como nuevo destino en la ventana de información.
        </p>
    </div>

        <div class="row">
            <div id="ad-content" class="col-md-12 pub">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- coordenadas-gps-content -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-9379737428903517"
             data-ad-slot="4775031384"
             data-ad-format="auto"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
            </div>  
        </div>
        <div class="row">
            <div class="col-md-4">
                <h3>Punto de Partida</h3>
        <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="address" class="col-md-3 control-label">Dirección</label>
                        <div class="col-md-9">
                            <input id="address" class="form-control" type="textbox" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-4">
                          <button type="button" class="btn btn-primary" onclick="codeAddress()">Establecer como origen</button>
                        </div>
                    </div>
                </form>
                
                <form class="form-horizontal" role="form">
                    <h4>Coordenadas GPS del punto de partida*</h4>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="latitude">Latitud</label>
                        <div class="col-md-9">
                            <input id="latitude" class="form-control" type="textbox">
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="longitude">Longitud</label>
                        <div class="col-md-9">
                            <input id="longitude" class="form-control" type="textbox">
                        </div>
                    </div>
 
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-4">
                          <button type="button" class="btn btn-primary" onclick="codeLatLng(1)">Establecer como origen</button>
                        </div>
                    </div>
                        
                </form>
        
        <h3>Destino</h3>
        <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="addressDest" class="col-md-3 control-label">Dirección</label>
                        <div class="col-md-9">
                            <input id="addressDest" class="form-control" type="textbox" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-4">
                          <button type="button" class="btn btn-primary" onclick="codeAddressDest()">Establecer como destino</button>
                        </div>
                    </div>
                </form>
        <form class="form-horizontal" role="form">
            <h4>Coordenadas GPS del punto de destino*</h4>
            <div class="form-group">
            <label class="col-md-3 control-label" for="latitudeDest">Latitud</label>
            <div class="col-md-9">
                <input id="latitudeDest" class="form-control" type="textbox">
            </div>
            </div>
            
            <div class="form-group">
            <label class="col-md-3 control-label" for="longitudeDest">Longitud</label>
            <div class="col-md-9">
                <input id="longitudeDest" class="form-control" type="textbox">
            </div>
            </div>
        
            <div class="form-group">
            <label class="col-md-3 control-label" for="travelMode">Modo</label>
            <div class="col-md-9">
              <select id="travelMode" class="form-control">
                <option>Driving</option>
                <option>Bicycling</option>
                <option>Transit</option>
                <option>Walking</option>
              </select>
            </div>
            </div>

            <div class="form-group">
            <label class="col-md-3 control-label" for="unit">Unidad</label>
            <div class="col-md-9">
              <select id="unit" class="form-control">
                <option>Kilometer</option>
                <option>Mile</option>
              </select>
            </div>
            </div>

            <div class="form-group">
            <label class="col-md-3 control-label" for="highways">Autopista</label>
            <div class="col-md-9">
              <select id="highways" class="form-control">
                <option>Ok</option>
                <option>Avoid</option>
              </select>
            </div>
            </div>

            <div class="form-group">
            <label class="col-md-3 control-label" for="tolls">Peaje</label>
            <div class="col-md-9">
              <select id="tolls" class="form-control">
                <option>Ok</option>
                <option>Avoid</option>
              </select>
            </div>
            </div>
        <div class="form-group">
            <div class="col-md-offset-3 col-md-4">
              <button type="button" class="btn btn-success" onclick="directions();">Obtener Direcciones<span id="loader"></span></button>
            </div>
        </div>
        </form>
        <span class="help-block"><small>* Sistema Geodésico Mundial 1984 (WGS 84)</small></span>
          
        
        </div>
            <div class="col-md-8">
                <div id="map_canvas"></div>
            
        <div id="directionsPanel"></div>
        </div>
        </div>
        <div class="row">
            <div class="col-md-12 pub" id="ad-bottom">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- coordenadas-gps-bottom -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-9379737428903517"
             data-ad-slot="9205230981"
             data-ad-format="auto"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
            </div>
        </div>
        <div class="row">
    <div class="col-md-12">
            </div>
</div>
        

    
    </div>
        
            </div>

    <div id="footer">
      <div class="container">
        <p class="text-muted credit"><small>Copyright &copy; 2018 www.coordenadas-gps.com</small> | <a href="/contacto">Contacto</a> | <a href="/privacy">Privacidad</a> | <a href="/terms">Terms</a></p>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
          $("form").keypress(function(e) {
            //Enter key
            if (e.which == 13) {
              return false;
            }
          });
        });
    </script>
        <script>
    $(document).ready(function() {
        
        $('#wrap').on('click', '.favorite', function(e) {
            $('#dp_pointbundle_point_submit').trigger('click');
            $(this).replaceWith('<button type="button" class="bookmarked btn btn-primary"><span class="glyphicon glyphicon-star"></span></button>');
        });
        
        $('#form_wrap').on('submit', 'form', function(e) {
            e.preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                cache: false,
                url: $(this).attr('action'), 
                data: $(this).serialize(),
                dataType: "json",
                success: function(data){
        
                    if (data.responseCode==200) {}
                    else if (data.responseCode==400) alert(data.message);
                    else alert("ok");
                
                    $.ajax({
                        url: "/point/update",
                        cache: false,
                        success: function(data2){
                
                            if (data2.responseCode==200) $('#bookmarks_wrap').html(data2.updated);
                            //else if (data2.responseCode==400) alert(data2.message);
                            //else alert("ok");
                            
                            
                            
                            
                            
                        },
                        error: function(xhr, err){
                
                            //alert("This is taking too long. You may have internet connectivity issues or the server is down.");
                        }
                    });
                
                },
                error: function(xhr, err){
        
                    alert("Error. You may have internet connectivity issues or the server is down.");
                }
            });
        
            return false;
        });                        
  
        $('#bookmarks_wrap').on('submit', 'form', function(e) {
            e.preventDefault();
            $(this).replaceWith('<img src="/images/loader.gif" style="margin-left: 25px; margin-top: 8px;"/>');
            $.ajax({
                type: $(this).attr('method'),
                cache: false,
                url: $(this).attr('action'), 
                data: $(this).serialize(),
                dataType: "json",
                success: function(data){
        
                    if (data.responseCode==200) {}
                    else if (data.responseCode==400) alert(data.message);
                    else alert("ok");
                    
                    
                    $.ajax({
                        url: "/point/update",
                        cache: false,
                        success: function(data2){
                
                            if (data2.responseCode==200) $('#bookmarks_wrap').html(data2.updated);
                           // else if (data2.responseCode==400) alert(data2.message);
                            //else alert("Error");
                            
                            
                            
                            
                            
                        },
                        error: function(xhr, err){
                
                            //alert("Error");
                        }
                    });
                    
                    
                },
                error: function(xhr, err){
        
                    alert("Error. You may have internet connectivity issues or the server is down.");
                }
            });
        
            return false;
        });                        
    
    });                    

</script>

    <script type="text/javascript">
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js?onload=onLoadCallback';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
    </body>
</html>


        </main>
        <!-- end main -->