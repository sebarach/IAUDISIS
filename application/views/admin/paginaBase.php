<main class="main">
            <!-- Breadcrumb -->
  <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
      <li class="breadcrumb-item ">
          <a href="">Inicio</a>
      </li>                
  </ol>
  <div class="container">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-pm-summary ">
            <div class="card-body">
              <div class="clearfix">
                <div class="float-left">
                  <div class="h3 text-dark">
                    <strong>Dashboard </strong>
                  </div>
                  <small class="text-darck"><?php echo date('F j, Y');  ?></small>
                </div>
                <!-- <div class="float-right">
                  <a class="btn btn-dark" href="<?php echo base_url("Adm_ModuloTareas/crearTarea");?>" ><small class="text-white"> Nueva Tarea</small>
                  </a>
                </div> -->
              </div>
              <hr>
              <div class="row">
                <div class="col-md-3">
                    <div class="card-body bg-theme">
                        <div class="widget-pm-summary">
                                 <i class="mdi mdi-map-marker-multiple"></i>
                            <div class="widget-text">
                                <div class="h2 text-white"><?php echo $DashL['nLocal']; ?></div>
                                <small class="text-white">N° de PDV</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-body bg-theme">
                        <div class="widget-pm-summary">
                            <i class="mdi mdi-pencil-box-outline"></i>
                            <div class="widget-text">
                                <div class="h2 text-white"><?php echo $DashF['nFormulario']; ?></div>
                                <small class="text-white" style='font-size:70%;'>N° de Formularios</small>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-body bg-theme">
                        <div class="widget-pm-summary">
                            <i class="mdi mdi-account"></i>
                            <div class="widget-text">
                                <div class="h2 text-white"><?php echo $DashU['Nuser']; ?></div>
                                <small class="text-white">N° de Usuarios</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-body bg-theme">
                        <div class="widget-pm-summary">
                            <i class="mdi mdi-message-bulleted"></i>
                            <div class="widget-text">
                                <div class="h2 text-white"><?php echo $DashT['nTareas']; ?></div>
                                <small class="text-white">Tareas Activas</small>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-12">
                  <div class='chart tab-pane active' id='revenue-chart' style='position: relative; height: 300px;'>
                    <div style='width: 100%; height: 100%;' id='map'></div>
                  </div>
                  <div class="card-body">
                    <div class="h5 text-dark">
                      <strong>Formularios Completados</strong>
                    </div>
                    <small class="text-theme">Año Actual</small>
                  </div>
                </div>
              </div>
              <!-- <div class="col-md-6">
                  <div class="card-body">
                      <h4 class="text-theme">Donute Chart</h4>
                      <div id="morris-donut-chart"></div>
                  </div>
              </div> -->
             <!--  <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <h4 class="text-theme">Extra Area Chart</h4>
                                    <div id="extra-area-chart"></div>
                                </div>
                               
                            </div>
                         
                        </div> -->
              <div class="row">   
                <div class="col-md-6">
                  <div class="card-body">
                      <h4 class="text-theme">Elementos por Categoría</h4>
                      <p>Estas son las cantidades de elementos por categoría. <strong>Cantidad de categorías totales según elementos: <?php echo $CantidadElemento;?></strong></p>
                      <br/>
                        
                        <div class="text-center">
                          <?php if($CantidadElemento!=0){?>
                            <div id="morris-donut-chart-ele"></div>
                            <?php }else{ ?>
                              <div id="morris-donut-chart-ele" style="display: none;"></div>
                              <br> <br> <br> <br> <br> <br>
                              <h1>NO HAY ELEMENTOS REGISTRADOS.</h1>
                        <?php } ?>
                        </div>
                        
                          
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card-body">
                    <h4 class="text-theme">Asistencias Marcadas</h4>
                    <p>Cantidad de usuarios que marcan asistencia el día de hoy por Local asignado. <strong>Cantidad de locales con marca: <?php echo $CantidadMarcada;?></strong></p>
                    <div class="text-center">
                        <?php if($CantidadMarcada!=0){?>
                          <div id="morris-donut-chart"></div>
                            <?php }else{ ?>
                          <div id="morris-donut-chart" style="display: none;"></div>
                              <br> <br> <br> <br> <br> <br> <br>
                              <h1>NO HAY ASISTENCIAS REGISTRADAS.</h1>
                        <?php } ?>
                    </div>
                  </div>           
                </div>
              </div>
              <hr>
              <div class="row">   
                <div class="col-md-6">
                  <div class="card-body">
                      <h4 class="text-theme">Archivos Descargados por Carpeta</h4>
                      <p>Estas son la cantidad de descargas hechas por carpetas.</p>
                      <div class="text-center">
                          <canvas id="chart6" height="150"></canvas>

                      </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card-body">
                    <h4 class="text-theme">Archivos Descargados por Usuarios</h4>
                    <p>Cantidad de descargas hechas por cada usuario.</p>
                    <div class="text-center">
                      <canvas id="chart7" height="150"></canvas>
                    </div>
                  </div>           
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyB3412Cmx6-Q9TR0Zqad70sXtCUhb3505A&language=es&libraries=places"></script>
<script src="<?php echo  site_url(); ?>assets/libs/raphael/raphael.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/chart.js/dist/Chart.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/raphael/raphael.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/charts-morris-chart/morris.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/charts-chartist/chartist.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/charts-chartist/chartist-plugin-tooltip.min.js"></script>
<script type='text/javascript'>
 // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      var map, infoWindow;    
      //dibujar la posicion donde nos encontramos en el mapa
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.458348, lng: -70.6119832},
          zoom: 9,
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

        var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.
        var markers = locations.map(function(location, i) {
          return new google.maps.Marker({
            position: location,
            label: labels[i % labels.length]
          });
        });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
      }

       <?php echo" 
        var locations = [";
           foreach ($Locales as $l) {
                echo"{lat: ".$l['Latitud'].", lng: ".$l['Longitud']."},";

            }
            echo "]";?> 

    </script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
<script type="text/javascript">

   Morris.Donut({
        element: 'morris-donut-chart-ele',     
        data: [<?php foreach ($CantidadElementos as $lt){ ?>{
            label: <?php echo '"'.$lt['categoria'].'"'; ?>,
            value: <?php echo '"'.$lt['Nele'].'"'; ?>,
        }, <?php } ?>],      
        resize: true,
        colors: ['#df0000', '#ea0000', '#f40000', '#ff0000', '#ff1d0b', '#ff2e16', '#ff3b1f']
    });

  Morris.Donut({
        element: 'morris-donut-chart',     
        data: [<?php foreach ($AsiLocales as $lt){ ?>{
            label: <?php echo '"'.$lt['NombreLocal'].'"'; ?>,
            value: <?php echo '"'.$lt['Nasi'].'"'; ?>,
        }, <?php } ?>],      
        resize: true,
        colors: ['#df0000', '#ea0000', '#f40000', '#ff0000', '#ff1d0b', '#ff2e16', '#ff3b1f']
    });

  var ctx = document.getElementById("chart6").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [<?php foreach ($DesCarpetas as $dc) {  echo '"'.$dc['Nombre_Carpeta'].'",'; }?>],
      datasets: [{
        label: 'Descargas',
        data: [<?php foreach ($DesCarpetas as $dc) {  echo '"'.$dc['NDescarga'].'",'; }?>],
        backgroundColor: "#F03434"
      }]
    }
  });

  var ctx = document.getElementById('chart7').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [<?php foreach ($DesUsuarios as $du) {  echo '"'.$du['Nombres'].'",'; }?>],
      datasets: [{
        label: 'Usuarios',
        data: [<?php foreach ($DesUsuarios as $du) {  echo '"'.$du['NDescarga'].'",'; }?>],
        backgroundColor: "#F03434"
      },]
    }
  });


    


</script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>