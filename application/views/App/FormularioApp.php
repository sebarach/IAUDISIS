<link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/css/switch-especial.css">
<script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
 <style type="text/css">
  
  
#loader {
  position: absolute;
  left: 50%;
  top: 60%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #f03434;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}

.abc-checkbox .check::before {
    background-color: #D8D8D6;
}

.abc-radio .check::before {
    background-color: #D8D8D6;
}
.pad0{
  padding-right: 4px;
  padding-left: 4px;
}

.form-control{
     border: 1px solid #f4c1bc; 
}

 </style>
<main class='main'>
  <hr>
  <ol class='breadcrumb bc-colored bg-theme' id='breadcrumb'>
    <li class='breadcrumb-item '>
        <a href="<?php echo base_url("menu");?>">Menú</a>
      </li>
      <li class="breadcrumb-item active">
          <a href="<?php echo base_url("App_ModuloTareas/elegirTareasAsignadas");?>">Tareas</a>
      </li>
      <li class="breadcrumb-item active">
          <a href="<?php echo base_url("App_ModuloTareas/elegirTareasAsignadas");?>">Nombre Tareas</a>
      </li>
    <li class="breadcrumb-item active">Formulario</li>
  </ol>
  <div class="container-fluid">        
    <div class="animated fadeIn card border-danger text-danger mb-3">
      <?php echo $formu; ?>
      <div class="card-body">
        <div class="btn-group btn-group-sm">
          <button id ="bt_agregar" type="button" class="btn btn-sm btn-outline-theme" onclick="IngresarFormularioUs();"><i class="fa fa-save" id="incMar" ></i><br>Guardar Formulario</button>
          <button class="btn btn-sm btn-outline-theme" data-toggle="modal" onclick="mapaUsuario()" data-target=".bs-example-modal-tooltip" id="bt_abrirmapa"><i class="fa fa-map-marker"></i><br>Confirmar Ubicación</button>
          <div id="loader" style="display: none;"></div>
        </div>
      </div>
      
    </div>  
  </div>
  <div class='modal modal-theme bs-example-modal-tooltip ' id='modal-warningS'>
  	<div class='modal-dialog'>
  		<div class='modal-content'>
  			<div class='modal-header'>
          <h4 class='modal-title'>Confirmar Ubicación</h4>
  				<button type='button'  class='close pull-right' data-dismiss='modal' aria-label='Close' id="button-map">
  					<span aria-hidden='true'>&times;</span>
  				</button>
      
     </div>
      <div class='modal-body' id='modalmapa'></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Confirmar</button>
      </div>
    </div>       
   </div>
  </div>
</main>
<script src="<?php echo  site_url(); ?>assets/libs/sweetalert/sweetalert.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/dropify/dist/js/dropify.min.js"></script>

<script src="<?php echo  site_url(); ?>assets/js/jsFormulario.js"></script>
<script type="text/javascript">

  $( document ).ready(
    function findMe(){            
     //Obtenemos latitud y longitud actual
      function localizacion(posicion){
        var latitude = posicion.coords.latitude;
        var longitude = posicion.coords.longitude;
        $("#f_latitud").val(latitude.toFixed(8));
        $("#f_longitud").val(longitude.toFixed(8));                                        
        if($("#f_latitud").val()!="" && $("#f_longitud").val()!=""){
          document.getElementById("bt_abrirmapa").style.display = "none";
        }else{        
          document.getElementById("bt_abrirmapa").style.display = "inline";
        }    
      }
      navigator.geolocation.getCurrentPosition(localizacion);
    }); 

	
	function mapaUsuario(){
    $.ajax({
      url: "<?php echo site_url(); ?>App_ModuloFormularios/ConfirmarUbicacion",
      type: "POST",
      data:  $("#Formulario").serialize(),
      success: function(data) {
        $("#modalmapa").html('');
        $("#mapita").html('');
        $("#modalmapa").html(data);
        if($("#f_latitud").val()!="" && $("#f_longitud").val()!=""){
          document.getElementById("bt_abrirmapa").style.display = "none";
        }else{        
          document.getElementById("bt_abrirmapa").style.display = "inline";
        }    
      }
    });
  }

 function limpiar() {
   $("#modalmapa").html('');
 }

</script>