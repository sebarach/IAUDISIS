<main class="main">
  <hr>
  <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
    <li class="breadcrumb-item ">
        <a href="<?php echo base_url("menu");?>">Menú</a>
    </li>
    <li class="breadcrumb-item active">
      <a href="">Asistencia</a>
    </li>
  </ol>
  <div class="container">
    <div class="animated fadeIn"><strong></strong>
      <div class="row">
        <div class="col-md-12">
          <div class='card card-property-single'>
            <?php if (!isset($JornadaUser)) {
              echo "<div class='property-details'>
                    <div class='clearfix'>
                      <div class='card-body p-3 clearfix'>
                        <i class='mdi mdi-human-handsup bg-danger p-3 font-2xl mr-3 float-left text-white'></i>
                        <div class='h5 text-danger mb-0 mt-2'>No tiene Jornadas por Marcar!</div>
                        <div class='text-muted text-uppercase font-weight-bold font-xs'>
                            <small>Favor de contactarse con su Supervisor si aún no le han asignado más jornadas.</small>
                        </div>
                      </div>                                                                        
                    </div>
                  </div>";
                } else if ($JornadaUser["ID_Permiso"]!=0) {
              echo "<div class='property-details'>
                    <div class='clearfix'>
                      <div class='card-body p-3 clearfix'>
                        <i  class='mdi mdi-human-handsup bg-danger p-3 font-2xl mr-3 float-left text-white'></i>
                        <div class='h5 text-danger mb-0 mt-2'>Hoy tienes Libre!</div>
                        <div class='text-muted text-uppercase font-weight-bold font-xs'>
                            <small>No es nesesario que marques Asistencia</small>
                        </div>
                      </div>                                                                        
                    </div>
                  </div>";
              }else{    
                $Edate=date_create($JornadaUser["entrada"]);
                $Edate2=date_format($Edate,"H:i A");
                $Sdate=date_create($JornadaUser["salida"]);
                $Sdate2=date_format($Sdate,"H:i A");; 
              echo"
            <div class='chart tab-pane active' id='revenue-chart' style='position: relative; height: 300px;'><div style='width: 100%; height: 100%;' id='map'></div></div>
                  <div class='card-body'>
                    <div class='rent-details'>
                    <div class='clearfix'>
                      <div class='h5'><strong>Marcar Asistencia</strong></div>
                       <div class='h6' id='lbmarca' style='color:green;' ></div>
                        <div class='btn-group' role='group'>
                            <button id='btn-MarcarAsistencia' class='btn btn-theme sweet-4' style='display: none;' > 
                            <i id='incMar' class='fa fa-map-marker'></i> Asistencia</button>&nbsp;
                            <button id='btn-MarcarColacion' style='display: none;' class='btn btn-outline-theme sweet-5'><i id='incMCola' class='mdi mdi-food-fork-drink'></i> Colación</button>
                             <button id='btn-SaldiaFR' style='display: none;' type='button' class='btn btn-outline-theme sweet-8'>Marcar Salida<i id='incMar' class='fa fa-map-marker '></i></button>
                                                                
                        </div>
                    </div>
                </div>
                
                <div class='btn-group' role='group' aria-label='Basic example'>
                                
                                  <button id='Actualizar' class='btn btn-outline-theme btn-sm '>Actualizar Mapa<i id='incRef' class='mdi mdi-refresh'></i></button>
                                  <button id='npdv' style='Display:none;' class='btn btn-outline-theme btn-sm sweet-7'>¿No es tu Punto?<i class='mdi mdi-map-marker-circle'></i></button>
                                    
                              </div>

                <div class='form-group row'>
                          <div class='col-md-12'>
                            <div class='input-group-vertical'> 
                              <span class='input-group-addon'>Hora Actual<i class='mdi mdi-clock'></i></span>
                              <input type='text' id='txt_HoraA' name='txt_HoraA' class='form-control' value='".$hora."'disabled >
                              <span class='input-group-addon'>Entrada<i class='mdi mdi-clock-in'></i></span>
                              <input type='text' id='txt_HoraE' name='txt_HoraE' class='form-control' value='".$Edate2."'disabled >
                            
                              <span class='input-group-addon'>Salida&nbsp;&nbsp;<i class='mdi mdi-clock-out'></i></span>
                              <input type='text' id='txt_HoraS' name='txt_HoraS' class='form-control' value='".$Sdate2."'disabled >
                            </div> 
                          </div>
                        </div>
                <form id='FrmAsistencia' method='POST'>
                <input type='hidden' id='HoraA' name='HoraA' value='".$hora."' >
                <input type='hidden' id='latitud1A' name='latitud1A' >
                <input type='hidden' id='NombrePDV' name='NombrePDV' value='".$JornadaUser["NombreLocal"]."'>
                <input type='hidden' id='longitud1A' name='longitud1A' >
                <input type='hidden' id='_HoraE' name='_HoraE' value='".$Edate2."' >
                <input type='hidden' id='_HoraS' name='_HoraS' value='".$Sdate2."' >
                <input type='hidden' id='latitud2PDO' name='latitud2PDO' value='".$JornadaUser["latitud"]."' >
                <input type='hidden' id='longitud2PDO' name='longitud2PDO' value='".$JornadaUser["longitud"]."'>
                <input type='hidden' id='DistanciaPDO' name='DistanciaPDO' >
                <input type='hidden' id='idHor' name='idHor' value='".$JornadaUser["ID_Horario"]."'>
                <input type='hidden' id='idJor' name='idJor' value='".$JornadaUser["FK_Jornadas_ID_Jornada"]."' >
                <div class='property-details'>
                
                    <hr>
                      <div class='clearfix'>
                        <div class='input-group'>
                          <span class='input-group-addon' > Rango &nbsp; <i class='mdi mdi-map-marker-radius'></i></span>
                          <input type='text' id='txt_rango' name='txt_rango' class='form-control' disabled>
                          
                          
                        </div>
                      </div>
                    <hr>

                    <div class='clearfix'>
                      <div class='input-group-vertical'>
                        <span class='input-group-addon'> Direccion &nbsp; <i class='mdi mdi-map-marker-circle'></i></span>
                        <input type='text'  class='form-control' value='".$JornadaUser["Direccion"]."' disabled >
                      </div>     
                      <div  id='val_longitud' style='color:red;'></div>                                                                         
                    </div>
                    <hr>
                    
                    <!-- end clearfix -->
                    <div class='clearfix'>
                      <div class='input-group-vertical'>
                        <span class='input-group-addon'>PDO Asignado &nbsp;<i class='fa fa-map-marker'></i></span>
                        <input type='text' id='txt_direccion' disabled name='txt_direccion' class='form-control' value='".$JornadaUser["NombreLocal"]."'>
                      </div> 
                    </div>
                    <hr>";
                    if (isset($ListarIncidencia[0])) {
                    echo"<div class='clearfix' >
                      <div class='input-group'>
                      <span class='input-group-addon'> Incidencias &nbsp;</span>
                        <select id='selectInc' name='selectInc' onchange='comentario();' class='form-control form-control-sm'>
                            <option value='1'>Tuviste algún problema para llegar a tu PDO??</option>";
                             foreach ($ListarIncidencia as $c) {
                              echo "<option value='".$c['ID_Incidencias']."'>".$c['NombreIncidencia']."</option>";}
                            
                  echo"</select>
                      </div> 
                    </div>
                    <hr>";}
                    echo"<div class='clearfix' id='comentario' style='display: none;' >
                      <div class='input-group'>
                        <span class='input-group-addon'>Comentario</span>
                        <textarea class='maxlength-textarea form-control' data-plugin='maxlength' data-placement='bottom-right-inside' id='txt_comentario' name='txt_comentario' maxlength='100'
                            rows='4' placeholder='Puedes Escribir un comentario de maximo 100 letras.(Opcional)'></textarea>
                      </div> 
                    </div>
                            
                            
                                    <!-- end clearfix -->
                </div> 
              </form>
                ";}?>
          </div>
        </div>
       
      </div>
    </div>
     
  </div>
  <div class="modal fade bs-example-modal-CorreoPDV-s" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="CorreoSoportePDV">
        <div class="modal-dialog ">
            <div class="modal-content" id="CorreoSoportesPDV">
             
            </div>
            <!-- /.modal-content -->
        </div>
        
        <!-- /.modal-dialog -->
    </div>
  
</main>

<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3412Cmx6-Q9TR0Zqad70sXtCUhb3505A&callback=initMap"></script>
<script type="text/javascript">
     $( document ).ready(
        function findMe(){
         //Obtenemos latitud y longitud actual
          function localizacion(posicion){
            var map =null;
            var infoWindow=null;
            // marker.setMap(null);
            var latitude = '';
            var longitude = '';
            $("#latitud1A").val(0);
            $("#longitud1A").val(0);
            var latitude = posicion.coords.latitude;
            var longitude = posicion.coords.longitude;
            $("#latitud1A").val(latitude.toFixed(8));
            $("#longitud1A").val(longitude.toFixed(8));
            var lat1 =$("#latitud1A").val();
            var lon1 =$("#longitud1A").val();
            var lat2 =$("#latitud2PDO").val();
            var lon2 =$("#longitud2PDO").val();
            var horaA =$("#txt_HoraA").val();
            var horaE =$("#txt_HoraE").val();
            var HoraS =$("#txt_HoraS").val();
            //calculo que mide en km la distancia de un punto A a un punto B con su Ltitud y Longitud
            rad = function(x) {return x*Math.PI/180;}
            var R = 6378.137; //Radio de la tierra plana en el ecuador(en los polos es 6357 Km y en el ecuador 6378 Km).
            var dLat = rad( lat2 - lat1 );
            var dLong = rad( lon2 - lon1 );
            var a = Math.sin(dLat/2)*Math.sin(dLat/2) + Math.cos(rad(lat1)) * Math.cos(rad(lat2)) * Math.sin(dLong/2) * Math.sin(dLong/2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            var d = R * c;
            //multiplicamos la distancia en km por 1000 para transformala en metros
            var m = d * 1000;
            var rango = <?php echo $JornadaUser["Rango"]; ?>;
            var distancia = m - rango;
            $("#DistanciaPDO").val(m.toFixed(2));
            var infoEntradaC = '<?php echo $colacion["EntradaColacion"]; ?>';
            var infoSalidaC = '<?php echo $colacion["SalidaColacion"]; ?>';
            var infoEntrada = '<?php echo $JornadaUser["FechaEntrada"]; ?>';
            var infoSalida = '<?php echo $JornadaUser["FechaSalida"]; ?>';
           if (m<rango) {
              $("#txt_rango").attr("style","color: white;background-color:#20bf6b");
              $("#txt_rango").val('Estas Dentro de Rango Permitido del PDO');
              $("#lbmarca").html("Estas dentro del rango permitido.");
              $("#btn-MarcarAsistencia").removeAttr("disabled");
              if (infoEntrada=='' && infoSalida==''  && infoEntradaC=='' && infoSalidaC=='') {
                $("#btn-MarcarAsistencia").html("<i id='incMar' class='fa fa-map-marker'></i> Marcar Entrada");
                $("#btn-MarcarAsistencia").removeAttr("style");
              }else if (infoEntrada=='' && infoSalida=='' && infoEntradaC!='' && infoSalidaC!='') {
                $("#btn-MarcarAsistencia").html("<i id='incMar' class='fa fa-map-marker'></i> Marcar Entrada");
                $("#btn-MarcarAsistencia").removeAttr("style");

              }else if (infoEntrada!='' && infoSalida=='' && infoEntradaC=='' && infoSalidaC=='') {
                $("#lbmarca").html("Marcar Salida");
                $("#btn-MarcarColacion").removeAttr("style");
                $("#btn-MarcarAsistencia").html("<i id='incMar' class='fa fa-map-marker'></i> Marcar Salida");
                $("#btn-MarcarAsistencia").removeAttr("style");
              }else if (infoEntrada!='' && infoSalida=='' && infoEntradaC!='' && infoSalidaC!='') {
                // $("#lbmarca").html("Marcar Salida");
                $("#btn-MarcarAsistencia").html("<i id='incMar' class='fa fa-map-marker'></i> Marcar Salida");
                $("#btn-MarcarAsistencia").removeAttr("style");
              }else if (infoEntrada!='' && infoSalida=='' && infoEntradaC!='' && infoSalidaC=='') {
                $("#btn-MarcarAsistencia").html("<i id='incMar' class='fa fa-map-marker'></i> Marcar Salida");
                $("#btn-MarcarAsistencia").removeAttr("style");
                $("#btn-MarcarColacion").removeAttr("style");    
              }

              if (infoEntrada!='' && infoSalida!='' && infoEntradaC!='' && infoSalidaC!='' ) {
                $("#lbmarca").html("Su asistencia para hoy ya esta completa para este local.");
                $("#btn-MarcarAsistencia").attr("style","display:none;");
              }else if (infoEntrada!='' && infoSalida!='') {
                $("#lbmarca").html("Su asistencia para hoy ya esta completa para este local.");
                $("#btn-MarcarAsistencia").attr("style","display:none;");
              }

              
              if (infoEntrada!='' && infoEntradaC=='' && infoSalidaC=='') {
                $("#btn-MarcarColacion").attr("style","display:inline;");
                $("#btn-MarcarColacion").html("<i id='incMCola' class='mdi mdi-food-fork-drink'></i>Iniciar Colación");
                var textoM = " Iniciar Colación";
              }else if (infoEntradaC!='' && infoSalidaC=='') {
                $("#btn-MarcarColacion").attr("style","display:inline;");
                $("#btn-MarcarColacion").html("<i id='incMCola' class='mdi mdi-food-fork-drink'></i>Fin Colación");
                var textoM = "Finalizar Colación";
              }else if (infoEntradaC!='' && infoSalidaC!='') {
                $("#btn-MarcarColacion").attr("style","display:none;");
              }  
            }else if (infoEntrada!='') {
              $("#txt_rango").attr("style","color: white;background-color:red");
              $("#txt_rango").val('Estas a '+distancia.toFixed(2)+'m Fuera del PDO');
              $("#npdv").removeAttr("style");
              $("#btn-SaldiaFR").removeAttr("style");
              $("#btn-MarcarAsistencia").attr("style","display:none;");
              $("#incMar").attr("class","fa fa-exclamation-triangle");
              $("#lbmarca").attr("style","color:red;");
              $("#lbmarca").html("Estas a "+distancia.toFixed(2)+"m fuera de Rango, Tienes que acercarte al punto y actualizar el mapa"); 

              if (infoEntradaC=='' && infoSalidaC=='') {
                $("#btn-MarcarColacion").attr("style","display:inline;");
                $("#btn-MarcarColacion").html("<i id='incMCola' class='mdi mdi-food-fork-drink'></i>Iniciar Colación");
                var textoM = " Iniciar Colación";
              }else if (infoEntradaC!='' && infoSalidaC=='') {
                $("#btn-MarcarColacion").attr("style","display:inline;");
                $("#btn-MarcarColacion").html("<i id='incMCola' class='mdi mdi-food-fork-drink'></i>Fin Colación");
                var textoM = "Finalizar Colación";
              }else if (infoEntradaC!='' && infoSalidaC!='') {
                $("#btn-MarcarColacion").attr("style","display:none;");
              } 
            }else{
              $("#txt_rango").attr("style","color: white;background-color:red");
              $("#txt_rango").val('Estas a '+distancia.toFixed(2)+'m Fuera del PDO');
              $("#npdv").removeAttr("style");
              $("#btn-MarcarAsistencia").attr("style","display:none;");
              $("#incMar").attr("class","fa fa-exclamation-triangle");
              $("#lbmarca").attr("style","color:red;");
              $("#lbmarca").html("Estas a "+distancia.toFixed(2)+"m fuera de Rango, Tienes que acercarte al punto y actualizar el mapa"); 

            }
          }
          navigator.geolocation.getCurrentPosition(localizacion);
    }); 
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      var map, infoWindow;

      // First, create an object containing LatLng and population for each city.
      //fijamos algunos puntos en el mapa con un circulo
      var citymap = {
          losangeles: {
          center: {lat: <?php echo $JornadaUser["latitud"]; ?>, lng: <?php echo $JornadaUser["longitud"]; ?>},
          population: 1
        }
      };
      
      //dibujar la posicion donde nos encontramos en el mapa
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.458348, lng: -70.6119832},
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

        var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
        var icons = {
          parking: {
            name: 'Parking',
            icon: iconBase + 'parking_lot_maps.png'
          },
          library: {
            name: 'Library',
            icon: iconBase + 'library_maps.png'
          },
          info: {
            name: 'Info',
            icon: iconBase + 'info-i_maps.png'
          }
        };

        var features = [
          {
            position: new google.maps.LatLng(-33.458348, -70.6119832),
            type: 'parking',
            title: 'Progestion'
          },
          {
            position: new google.maps.LatLng(<?php echo $JornadaUser["latitud"]; ?>, <?php echo $JornadaUser["longitud"]; ?>),
            type: 'info',
            title: 'Punto de Venta'
          }
          ];

        features.forEach(function(feature) {
          var marker = new google.maps.Marker({
            position: feature.position,
            icon: icons[feature.type].icon,
            map: map
          });
        });
        
         for (var city in citymap) {
        
          var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: citymap[city].center,
            radius: Math.sqrt(citymap[city].population) * <?php echo $JornadaUser["Rango"]; ?>
          });
        }

        infoWindow = null;
        infoWindow = new google.maps.InfoWindow;

       
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };


            infoWindow.setPosition(pos);
            infoWindow.setContent('Aquí te encuentras.');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          }

          );
        } else {
          
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: El servicio de Geolocalización no esta disponible.' :
                              'Error: Puede que no este Activado el GPS o no ha comportido su Localización');
        infoWindow.open(map);
      }

 

   $('#Actualizar').click(function(){ 
  
      window.location.reload(true);
    });

     function comentario(){
      var id =$("#selectInc").val();
      if (id>1) {
        $("#comentario").attr("style","");
      }
    }

    document.querySelector('.sweet-4').onclick = function () {
      var infoEntrada = '<?php echo $JornadaUser["FechaEntrada"]; ?>';
      var infoSalida = '<?php echo $JornadaUser["FechaSalida"]; ?>';
      if (infoEntrada=='' && infoSalida=='') {
        var textoM = "Entrada";
      }else if (infoEntrada!='' && infoSalida=='') {
        var textoM = "Salida";
      }if (infoEntrada!='' && infoSalida!='') {
        // $("#lbmarca").html("Su asistencia para hoy ya esta completa para este local.");
      }
    swal({
            title: "Marcar Asistencia",
            text: "¿ Estas seguro de Marcar "+textoM+" ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-theme',
            confirmButtonText: 'Si, Marcar',
            closeOnConfirm: true,
            //closeOnCancel: false
        },
        function () {
          $("#incMar").attr("class","fa fa-spin fa-circle-o-notch");
          if ($("#DistanciaPDO").val()!='' && $("#idHor").val()!='' && $("#idJor").val()!='') {
            $.ajax({                        
             type: "POST",                 
             url:"<?php echo site_url();?>Adm_ModuloAsistencia/MarcarAsistencia",                     
             data: $("#FrmAsistencia").serialize(), 
             success: function(data)             
             {
               data = data.replace("d ",'');
               // alert(data);
               if (data==1) {
               $("#incMar").attr("class","fa fa-spin fa-circle-o-notch");
               swal("Asistencia Registrada", "Su entrada ha sido registrada con exito.", "success");
               setTimeout(function(){window.location.reload();},1000);               
              } else if (data==2){
                $("#incMar").attr("class","fa fa-spin fa-circle-o-notch");
                swal("Asistencia Registrada", "Su salida ha sido registrada con exito.", "success");
                setTimeout(function(){window.location.reload();},1000);               
              }else if (data==3){
                $("#incMar").attr("class","fa fa-map-marker");                
               swal({
                  title: "Error",
                  text: "Usted ya tiene registrada la Asistencia para el dia de hoy",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar!'
                });               
              }else if (data==4){
                $("#incMar").attr("class","fa fa-map-marker");
                swal("Asistencia Registrada", "Su salida ha sido registrada con exito.", "success");
                setTimeout(function(){window.location.reload();},1000);
              }else if (data==5){
                $("#incMar").attr("class","fa fa-map-marker");
                swal({
                  title: "Error",
                  text: "No puede marcar salida si no ha finalizado su Colación",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
                });

              } else if (data==6){
                $("#incMar").attr("class","fa fa-spin fa-circle-o-notch");
                swal("Asistencia Registrada", "Su salida ha sido registrada con exito.", "success");
                setTimeout(function(){window.location.reload();},1000);  
              }else{
                $("#incMar").attr("class","fa fa-map-marker");
                swal({
                  title: "Error",
                  text: "Ha ocurrido un error, favor de recargar la página.",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
                });
                setTimeout(function(){window.location.reload();},1000); 
              }
             },error:function(data){
              $("#incMar").attr("class","fa fa-map-marker");

              swal({
                  title: "Error",
                  text: "Ha ocurrido un error, favor de recargar la página.",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
                });
                setTimeout(function(){window.location.reload();},1000);  
             }
        });
       }
      });
};

    document.querySelector('.sweet-5').onclick = function () {
      var infoEntrada = '<?php echo $JornadaUser["EntradaColacion"]; ?>';
      var infoSalida = '<?php echo $JornadaUser["SalidaColacion"]; ?>';
      if (infoEntrada=='' && infoSalida=='') {
        var textoM = " Iniciar Colación";
      }else if (infoEntrada!='' && infoSalida=='') {
        var textoM = "Salir de Colación";
      }else if (infoEntrada!='' && infoSalida!='') {
        // $("#lbmarca").html("Su asistencia para hoy ya esta completa para este local.");
        $("#btn-MarcarColacion").attr("style","display:none;");
      }else{
        // 
      }
    swal({
            title: "Marcar Colación",
            text: "¿ Desea "+textoM+" ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-theme',
            confirmButtonText: 'Si, Marcar',
            closeOnConfirm: true,
            //closeOnCancel: false
        },
        function () {
          $("#incMCola").attr("class","fa fa-spin fa-circle-o-notch");
          if ($("#latitud1A").val()!='' && $("#longitud1A").val()!='' && $("#idHor").val()!='' && $("#idJor").val()!='') {
          $.ajax({                        
             type: "POST",                 
             url:"<?php echo site_url();?>Adm_ModuloAsistencia/MarcarColacion",                     
             data: $("#FrmAsistencia").serialize(), 
             success: function(data)             
             {
               if (data==1) {
                swal("Colación Registrada", "Se ha iniciado su colacion con exito.", "success");                
                setTimeout(function(){window.location.reload();},1000);               
              } else if (data==2){
                swal("Colación Registrada", "Se ha Finalizado su colacion con exito.", "success");
                setTimeout(function(){window.location.reload();},1000);               
              }else if (data==3){
                $("#incMCola").attr("class","mdi mdi-food-fork-drink");
                swal({
                  title: "Error",
                  text: "Usted ya tiene su colación registrada para el dia de hoy",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
                }); 
              }else if (data==4){
                swal("Colación Registrada", "Se ha Finalizado su colacion con exito.", "success");
                setTimeout(function(){window.location.reload();},1000); 
              }else{
                $("#incMCola").attr("class","mdi mdi-food-fork-drink");
                swal({
                  title: "Error",
                  text: "Ha ocurrido un error, favor de recargar la página.",
                  type: "error",
                 showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
                }); 

              }
             },error:function(data){
              $("#incMCola").attr("class","mdi mdi-food-fork-drink");
              swal({
                  title: "Error",
                  text: "Ha ocurrido un error, favor de recargar la página.",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
                });  
             }
         });
         }else{
            swal({
            title: "Error",
            text: "Ha ocurrido un error, favor de recargar la página.",
            type: "error",
            showCancelButton: false,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: 'Aceptar'
          }); 
            $("#incMCola").attr("class","mdi mdi-food-fork-drink"); 
         }  
        });
};

document.querySelector('.sweet-7').onclick = function () {
    swal({
            title: "Actualización de PDV",
            text: "Esta solicitud será enviada directamente a soporte, con su posición geográfica actual para actualizar el punto de venta asignado.",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-warning',
            confirmButtonText: 'Enviar',
            closeOnConfirm: true,
            // closeOnCancel: true
        },
        function () {
          $.ajax({
            url: "<?php echo site_url();?>Adm_ModuloAsistencia/CorreoSoportePDV",
            type: "POST",
            data: $("#FrmAsistencia").serialize(),
            success: function(data) {
               swal("Notificación Enviada", "Se a Enviado la actualización geográfica del PDV con su actual posición.", "success");
            }
          });
          swal();             
        });
};


document.querySelector('.sweet-8').onclick = function () {
        var textoM = "Salida";
    swal({
            title: "Marcar Asistencia Fuera de Rango",
            text: "¿ Estas seguro de Marcar "+textoM+" ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-theme',
            confirmButtonText: 'Si, Marcar',
            closeOnConfirm: true,
            //closeOnCancel: false
        },
        function () {
          $("#incMar").attr("class","fa fa-spin fa-circle-o-notch");
          if ($("#DistanciaPDO").val()!='' && $("#idHor").val()!='' && $("#idJor").val()!='') {
            $.ajax({                        
             type: "POST",                 
             url:"<?php echo site_url();?>Adm_ModuloAsistencia/MarcarAsistencia",                     
             data: $("#FrmAsistencia").serialize(), 
             success: function(data)             
             {
              data = data.replace("d ",'');
              // alert(data);
               if (data==1) {
               $("#incMar").attr("class","fa fa-spin fa-circle-o-notch");
               swal("Asistencia Registrada", "Su entrada ha sido registrada con exito.", "success");
               setTimeout(function(){window.location.reload();},1000);               
              } else if (data==2){
                $("#incMar").attr("class","fa fa-spin fa-circle-o-notch");
                swal("Asistencia Registrada", "Su salida ha sido registrada con exito.", "success");
                setTimeout(function(){window.location.reload();},1000);               
              }else if (data==3){
                $("#incMar").attr("class","fa fa-map-marker");                
               swal({
                  title: "Error",
                  text: "Usted ya tiene registrada la Asistencia para el dia de hoy",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
                });               
               setTimeout(function(){window.location.reload();},1000);

              }else if (data==4){
                $("#incMar").attr("class","fa fa-map-marker");
                swal("Asistencia Registrada", "Su salida ha sido registrada con exito.", "success");
                setTimeout(function(){window.location.reload();},1000);
              }else if (data==5){
                $("#incMar").attr("class","fa fa-map-marker");
                swal({
                  title: "Error",
                  text: "No puede marcar salida si no ha finalizado su Colación",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
                });                
              } else if (data==6){
                $("#incMar").attr("class","fa fa-spin fa-circle-o-notch");
                swal("Asistencia Registrada", "Su salida ha sido registrada con exito.", "success");
                setTimeout(function(){window.location.reload();},1000); 
              } else if (data==7){
                $("#incMar").attr("class","fa fa-map-marker");
                swal({
                  title: "Error",
                  text: "Solo se puede marcar salida 10 minutos despues de marcar entrada",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
                });
                setTimeout(function(){window.location.reload();},1000); 
              }else{
                $("#incMar").attr("class","fa fa-map-marker");
                setTimeout(function(){window.location.reload();},1000);
                swal({
                  title: "Error",
                  text: "Ha ocurrido un error, favor de recargar la página.",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
                });
                setTimeout(function(){window.location.reload();},1000);
              }
             },error:function(data){
              $("#incMar").attr("class","fa fa-map-marker");

              swal({
                  title: "Error",
                  text: "Ha ocurrido un error, favor de recargar la página.",
                  type: "error",
                  showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
                }); 
              setTimeout(function(){window.location.reload();},1000);
             }
            });
          }else{
            swal({
              title: "Error",
              text: "Ha ocurrido un error, favor de recargar la página.",
              type: "error",
              showCancelButton: false,
              confirmButtonClass: 'btn-danger',
              confirmButtonText: 'Aceptar'
            });
            $("#incMar").attr("class","fa fa-map-marker");
            setTimeout(function(){window.location.reload();},1000);
          }   
            swal();
        });
};



        
</script>