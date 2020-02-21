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
    <?php if($formulario==1){ ?>
      <form class="form-horizontal" id="FormularioEspecial1" enctype="multipart/form-data">
        <div  class="app-body " style="margin-top:15px;">
          <div  class="container-fluid ">
            <div  class="animated-fadeIn ">
              <div  class="row">
                <div  class="col-md-12">
                  <?php 
                    echo'<a class="navbar-brand"><strong><img width="70%"    src="'.site_url();
                    if(isset($info['logo'])){
                      echo $info['logo'];
                    }else{
                      echo 'archivos/foto_trabajador/default.png';
                    }
                    echo '"></strong></a>';
                  ?>
                  <div  class="card-body">
                    <h4 class="tex-center text-theme">Georeferencia locales</h4>
                  </div>
                </div>
                <div class="card card-body card-accent-theme" >
                  <a data-toggle="collapse" style="text-decoration:none;color:#f13e46 " class="text-default" aria-expanded="true" aria-controls="collapseOne">
                    <h5 class="text-theme"></h5>
                  </a>
                  <div class="card card-body border-danger mb-3" style="text-align:center; border-bottom-right-radius: 10px 10px; border-bottom-left-radius: 10px 10px; text-align:center; border-top-left-radius: 10px 10px; border-top-right-radius: 10px 10px;" id="div_region">
                    <div class="form-group">
                      <h6 class="text-theme">Elegir Departamento</h6>
                      <div class="input-group">
                        <div class="col-md-12">
                          <select class="form-control" id="txt_idregion" style="width: 100%;" name="txt_idregion" onchange="cambiarRegionFormEsp();"> 
                            <option value=""> Elegir Departamento</option>
                            <?php
                            foreach ($Region as $r) {
                              echo '<option value="'.$r["ID_Region"].'">'.$r["Region"].'</option>';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card card-body border-danger mb-3" style="text-align:center; border-bottom-right-radius: 10px 10px; border-bottom-left-radius: 10px 10px; text-align:center; border-top-left-radius: 10px 10px; border-top-right-radius: 10px 10px; display: none;" id="div_ciudad">
                    <div class="form-group">
                      <h6 class="text-theme">Elegir Provincia</h6>
                      <div class="input-group">
                        <div class="col-md-12">
                          <select class="form-control" id="txt_ciudad" style="width: 100%;" name="txt_ciudad" onchange="cambiarCiudadFormEsp();"> 
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card card-body border-danger mb-3" style="text-align:center; border-bottom-right-radius: 10px 10px; border-bottom-left-radius: 10px 10px; text-align:center; border-top-left-radius: 10px 10px; border-top-right-radius: 10px 10px; display: none;" id="div_comuna">
                    <div class="form-group">
                      <h6 class="text-theme">Elegir Distrito</h6>
                      <div class="input-group">
                        <div class="col-md-12">
                          <select class="form-control" id="txt_comuna" style="width: 100%;" name="txt_comuna" onchange="cambiarComunaFormEsp();"> 
                          </select>
                        </div>
                      </div>
                    </div>
                  </div> 
                  <div class="card card-body border-danger mb-3" style="text-align:center; border-bottom-right-radius: 10px 10px; border-bottom-left-radius: 10px 10px; text-align:center; border-top-left-radius: 10px 10px; border-top-right-radius: 10px 10px; display: none;" id="div_local">
                    <div class="form-group">
                      <h6 class="text-theme">Elegir Local</h6>
                      <div class="input-group">
                        <div class="col-md-12">
                          <select class="form-control" id="txt_local" style="width: 100%;" name="txt_local" onchange="validarDireccionLocal();"> 
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>  
                  <div class="card card-body border-danger mb-3" style="text-align:center; border-bottom-right-radius: 10px 10px; border-bottom-left-radius: 10px 10px; text-align:center; border-top-left-radius: 10px 10px; border-top-right-radius: 10px 10px; display: none;" id="div_direccion">
                    <div class="form-group">
                      <h6 class="text-theme">Escribir Dirección Del Local</h6>
                      <div class="input-group">
                        <div class="col-md-12">
                          <input type="text" class="form-control" id="txt_direccion" name="txt_direccion" style="width: 100%;">
                        </div>
                      </div>
                    </div>
                  </div>         
                </div>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" name="txt_asignacion" value="<?php echo $asignacion; ?>">
        <input type="hidden" name="txt_usuario" value="<?php echo $usuario; ?>">
        <input type="hidden" name="txt_formulario" id="txt_formulario" value="<?php echo $formulario; ?>">
        <input type="hidden" name="f_latitud" id="f_latitud" value="">
        <input type="hidden" name="f_longitud" id="f_longitud" value="">
      </form>
    <?php } ?>    
      <div class="card-body">
        <div class="btn-group btn-group-sm">
          <button id ="bt_agregar" type="button" class="btn btn-sm btn-outline-theme" onclick="IngresarFormularioEspUs();"><i class="fa fa-save" id="incMar" ></i><br>Guardar Formulario</button>
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