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
    <div class="animated fadeIn" id="quiz">
      <?php echo $quiz; ?>
    </div>
    <div class="animated fadeIn" id="resp" style="display: none;">

    </div>
    <div class="btn-group" id="btnTrivia" style='margin-left:30px;'>
      <button id ="bt_agregar" type="button" class="btn btn-outline-theme" onclick="IngresarQuizUs();"><i class="" id="incMar"></i>Guardar Trivia</button>
    </div>
    <div id="loader" style="display: none;"></div>  
  </div>
  <div class='modal modal-theme bs-example-modal-tooltip ' id='modal-warningS'>
  	<div class='modal-dialog'>
  		<div class='modal-content'>
  			<div class='modal-header'>
          <h4 class='modal-title'>Confirmar Ubicación</h4>
  				<button type='button'  class='close pull-right' data-dismiss='modal' aria-label='Close' >
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
<script type="text/javascript">

     function IngresarQuizUs(){

        var nPreguntas = parseInt($("#txt_contador").val());
        var contador = 1;
        var val = 0;
        for (var i = 1; i < nPreguntas; i++) {
            if($('input[name="radioInline'+contador+'"]:checked').length === 0) {
                swal("Pregunta sin Responder", "Debe responder la pregunta N° "+contador, "error");
                val = 1;
                break;
            }
            contador++;
        }
        if (val==0) {
        $("#btnTrivia").hide("slow");
          $("#quiz").hide("slow");
          $("#loader").show("slow");
          var formData = new FormData(document.getElementById("frmQuiz"));
            $.ajax({
                url: "IngresarTriviaUsuario",
                type: "POST",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#loader").hide("slow");
                    swal("Trivia Registrada", "Se ha guardado su trivia con éxito.", "success");
                    $("#resp").html(data);
                    $("#resp").show("slow");
                }
            });
        }
    }

</script>