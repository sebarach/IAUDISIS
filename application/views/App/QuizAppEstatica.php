<style>
* {
  box-sizing: border-box;
}

.zoom:hover {
  -ms-transform: scale(1.5); /* IE 9 */
  -webkit-transform: scale(1.5); /* Safari 3-8 */
  transform: scale(1.5); 
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
    <div class="animated fadeIn" id="wait" style="display: none;">
        <i style="font-size:20px;" class="fa fa-spin mdi mdi-asterisk"></i> Subiendo respuestas, por favor, espere... 
    </div>
    <div class="btn-group col-md-2" id="btnTrivia">
      <button id ="bt_agregar" type="button" class="btn btn-outline-theme" onclick="IngresarQuizUsStatic();"><i class="" id="incMar"></i>Guardar Trivia</button>
    </div>
    <div id="loader" style="display: none;"></div>  
  </div>
</main>
<script src="<?php echo  site_url(); ?>assets/libs/dropify/dist/js/dropify.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
  
    function IngresarQuizUsStatic(){
        var nModulos = parseInt($("#txt_contador_mod").val());       
        var contador = 1;
        var contadorPreg = 1;
        var val = 0;
        if($("#validador_maestra").val()==1){
            if ($("#lb_region").val()==-1 || $("#lb_ciudad").val()==-1 || $("#lb_comuna").val()==-1 || $("#lb_local").val()==-1) {
                val = 1;
                swal("Opciones sin elegir", "Debe escoger las opciones","error");
            }         
        }
        for (var i = 0; i < nModulos; i++) {
            for (var j = 0; j < parseInt($("#txt_contador_preg"+contador).val()); j++) {
               if($('input[name="radioInline'+contador+'-'+contadorPreg+'"]:checked').length === 0) {
                    swal("Pregunta sin Responder", "Debe responder la pregunta N° "+contadorPreg+" del módulo "+contador, "error");
                    val = 1;
                    break;
                }
              contadorPreg++;
            }
            contadorPreg=1;
            contador++;          
        }
        if (val==0) {
            $("#btnTrivia").hide("slow");
            $("#quiz").hide("slow");
            $("#wait").show("slow");
            $("#loader").show("slow");
            var formData = new FormData(document.getElementById("frmQuizStatic"));
            $.ajax({
                url: "IngresarTriviaUsuarioEstatica",
                type: "POST",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                  $("#wait").hide();
                    $("#loader").hide("slow");
                    swal("Trivia Registrada", "Se ha guardado su trivia con éxito.", "success");
                    $("#resp").html(data);
                    $("#resp").show("slow");
                }
            });
        }
    }

</script>