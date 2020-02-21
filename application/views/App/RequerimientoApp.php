<main class="main">
	<hr>
	<ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
    <li class="breadcrumb-item ">
        <a href="<?php echo base_url("menu");?>">Menú</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="">Requerimiento</a>
    </li>
  	</ol>
	<div class="container-fluid">
		<div class="animated fadeIn">
			<div class="row">
				<div class="col-sm-6">
                    <div class="card">
                        <div class="card-header text-theme">
                            <strong>Enviar</strong>
                            <small>Requerimiento</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Requerimiento:</label>
                                        <textarea id="textarea-msg" name="textarea-msg" rows="9" class="form-control" placeholder="Escriba el requerimiento aquí..."></textarea>
                                    </div>
                                </div>
                            </div>
                           	<input type="hidden" name="f_latitud" id="f_latitud">
                           	<input type="hidden" name="f_longitud" id="f_longitud">
                            <div class="row">
                                <div class="text-center"> 
                                </div>
                                <button type="button" class="btn btn-theme btn-sm" onclick="return enviar();"><i class="mdi mdi-send"></i> Enviar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script type="text/javascript">

	$( document ).ready(
        function findMe(){            
          function localizacion(posicion){
            var latitude = posicion.coords.latitude;
            var longitude = posicion.coords.longitude;
            $("#f_latitud").val(latitude.toFixed(8));
            $("#f_longitud").val(longitude.toFixed(8));                                        
          }
          navigator.geolocation.getCurrentPosition(localizacion);
    }); 

	function enviar(){
		var mensaje=$("#textarea-msg").val();
		var latitud=$("#f_latitud").val();
		var longitud=$("#f_longitud").val();
		if (mensaje=='') {
			alertify.error("El requerimiento no puede quedar vacío");
			return;
		}else{
			$.ajax({
				url: "enviarReq",
            	type: "POST",
            	data: "mensaje="+mensaje+"&latitud="+latitud+"&longitud="+longitud,
            	success: function(data) { 
            		alertify.success("Requerimiento enviado con éxito"); 
            		setTimeout(function(){
                        window.location = "<?php echo site_url(); ?>menu";
                    }, 1000); 
            	}
			});
		}
	}

</script>