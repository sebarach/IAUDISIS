<style type="text/css">
    a.mytooltip {
    font-weight: 500;
    color: #F03434;
}

.tooltip-content2 {
    background: #F03434;
}
</style>
<link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/css/switch-especial.css">
<main class="main" style="height: 100%;">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
             <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Editar Trivias</a>
        </li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <h3 class="text-theme">Editar Trivia</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body" id="quizT">
                            <button type="button"  class="btn btn-round btn-outline-danger" onclick="agregarModulo();"><i class="mdi mdi-plus-circle-outline"></i>Agregar Módulo</button>
                            <button type="button" class="btn btn-round btn-outline-danger float-right" onclick="quitarModulo();"><i class="mdi mdi-minus-circle-outline"></i>Quitar Módulo</button>
                            <br>
                            <br>
                        	<div class="animated fadeIn" id="quiz">
						       <?php echo $quiz; ?> 
						    </div>
                            
                            <button type="button" class="btn btn-round btn-outline-danger" onclick="editarQuiz();"><i class="fa fa-edit (alias)"></i>Modificar Trivia</button>
                        </div>
                        <div class="card-body" id='cargandoQ' style="display: none;">
                            <p class="text-center" style="font-size:50px;">Actualizando Trivia, por favor espere... <i   class='fa fa-spin mdi mdi-human-handsup'></i></p>
                        </div>  
                    </div>
                </div>            
            </div>         
        </div>
    </div>

    <div class="modal fade" id="modal-subirArchivo" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Cargar Archivo</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sa-icon sa-danger animate"></div>
                    <div id="subirArchivo"></div>
                    <div id='cargando' style="display: none;">
                        <p>Cargando, por favor espere... <i class='fa fa-spin fa-spinner'></i></p>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="validarArchivo();">Subir Archivo</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div> 

    <script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
    <script type="text/javascript">

        function agregarModulo(){
            var contModulo = parseInt($("#txt_contador_modulo").val())+1;
            $("#frmEditarQuizStatic").append('<div class="col-md-12" id="div_modulo_n'+contModulo+'"><input type="hidden" id="txt_IDModulo'+contModulo+'" name="txt_IDModulo'+contModulo+'" value="'+contModulo+'"><div class="card border-danger text-danger"><div class="card-header">Módulo '+contModulo+'<div class="row">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="form-control col-md-4" id="nombreModulo'+contModulo+'" name="nombreModulo'+contModulo+'" placeholder="Título Módulo '+contModulo+'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="number" class="form-control col-md-1" id="porcentaje'+contModulo+'" name="porcentaje'+contModulo+'" placeholder="Porcentaje Módulo '+contModulo+'"><div class="col-md-2 input-group"><p class="margin"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;<p>Módulo con Descuento</p></p><span class=""><label class="switch"><input type="checkbox" id="vigDescuento'+contModulo+'" name="vigDescuento'+contModulo+'" '+contModulo+' onclick="vigenciaDescuento('+contModulo+');" value="0"><span class="slider round"></span></label></span></div><div class="col-md-2 input-group"><p class="margin"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p>Fotografía</p></p>&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" id="vigFotoMod'+contModulo+'" name="vigFotoMod'+contModulo+'" value="0" onclick="vigenciaFotoMod('+contModulo+');"><span class="slider round"></span></label></span></div><div class="col-md-2 input-group"><p class="margin"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p>Observación</p></p>&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" id="vigObservacion'+contModulo+'" name="vigObservacion'+contModulo+'" value="0" onclick="vigenciaObservacion('+contModulo+');"><span class="slider round"></span></label></span></div></div></div><div class="card-body" id="div_modulo'+contModulo+'" tabindex="1"><div class="form__box"><button type="button" class="btn btn-theme btn-sm" onclick="agregarPregunta('+contModulo+')"><i class="mdi mdi-plus-circle-outline"></i> Agregar Pregunta</button><button type="button" class="btn btn-theme btn-sm" onclick="quitarPregunta('+contModulo+')"><i class="mdi mdi-minus-circle-outline"></i> Quitar Pregunta</button></div><br><input type="hidden" id="txt_IDPreg'+contModulo+'" value="0"><input type="hidden" id="txt_IDOpcion'+contModulo+'" value="0"></div></div></div>');
            alertify.log("Módulo "+contModulo+" agregado!");
            $("#txt_contador_modulo").val(contModulo);
        }

        function quitarModulo(){
            var contModulo = parseInt($("#txt_contador_modulo").val());
            var contModuloOrigen = parseInt($("#txt_contador_modulo_origen").val())-1;
            if(contModulo>1)
            {
                $("#div_modulo_n"+contModulo).remove();
                alertify.log("Módulo "+contModulo+" eliminado!");
                var contModulo = parseInt($("#txt_contador_modulo").val())-1;
                $("#txt_contador_modulo").val(contModulo);
            } 
            else
            {
                alertify.error("No se pueden eliminar todos los modulos");
            }
            if (contModulo==0) {
                $("#quiz").hide();
            }
        }

        function agregarPregunta(contModulo){
            var contPregunta = parseInt($("#txt_IDPreg"+contModulo).val())+1;
            if(parseInt($("#cuentaOpciones"+contModulo+'_'+contPregunta).val())>0){
                parseInt($("#txt_IDOpcion"+contModulo+'_'+contPregunta).val(0));
                parseInt($("#cuentaOpciones"+contModulo+'_'+contPregunta).val(0));
            }
            $("#div_modulo"+contModulo).append('<div id="pregunta'+contModulo+'-'+contPregunta+'"><input type="hidden" name="cuentaPreg'+contModulo+'" value="'+contPregunta+'"><input type="hidden" id="txt_IDPreg'+contModulo+'-'+contPregunta+'" value="'+contPregunta+'"><div class="card border-warning text-warning"><div class="card-header">'+contPregunta+'.-<div class="row"><div class="col-md-8"><input type="text" class="form-control" id="nombrePregunta'+contModulo+'-'+contPregunta+'" name="nombrePregunta'+contModulo+'-'+contPregunta+'" placeholder="Pregunta '+contPregunta+'"></div><div class="col-md-2 input-group"><p class="margin"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p>Opción No Aplica</p></p>&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" id="vigNoAplica'+contModulo+'-'+contPregunta+'" name="vigNoAplica'+contModulo+'-'+contPregunta+'" value="0" onclick="vigenciaNoAplica('+contModulo+','+contPregunta+');"><span class="slider round"></span></label></span></div></div></div><div class="card-body"><p class="margin"><i class="fa fa-dot-circle-o"></i> Opciones</p><div class="col-md-12" id="div_elementos'+contModulo+'-'+contPregunta+'"><div class="input-group"><div class="col-md-12" id="div_elementos'+contModulo+'_'+contPregunta+'"></div></div><hr><div class="input-group col-md-6"><span class="input-group-addon"><i class="mdi mdi-checkbox-marked-circle-outline"></i></span><input type="number" class="form-control" name="txt_resp'+contModulo+'-'+contPregunta+'" id="txt_resp'+contModulo+'-'+contPregunta+'" placeholder="Ingresar el número de la Respuesta Correcta"></div><br><br><div class="form__box"><button type="button" class="btn btn-warning btn-sm" onclick="agregarOpcion('+contModulo+','+contPregunta+')"><i class="mdi mdi-plus-circle-outline"></i> Agregar Opción</button><button type="button" class="btn btn-warning btn-sm" onclick="quitarOpcion('+contModulo+','+contPregunta+')"><i class="mdi mdi-minus-circle-outline"></i> Quitar Opción</button></div></div></div></div></div><input type="hidden" name="cuentaOpciones'+contModulo+'_'+contPregunta+'" id="cuentaOpciones'+contModulo+'_'+contPregunta+'" value="0">');
            alertify.log("Pregunta "+contPregunta+" del módulo "+contModulo+" creada!");
            $("#txt_IDPreg"+contModulo).val(contPregunta);
        }

        function quitarPregunta(contModulo){
            var contPregunta = parseInt($("#txt_IDPreg"+contModulo).val()); 
            if(contPregunta>1){
                $("#pregunta"+contModulo+'-'+contPregunta).remove();
                alertify.log("Pregunta "+contPregunta+" del Módulo "+contModulo+" eliminada!");
                var contPregunta = parseInt($("#txt_IDPreg"+contModulo).val())-1;
                $("#txt_IDPreg"+contModulo).val(contPregunta);
            }
            else
            {
                alertify.error("No se pueden eliminar todos las preguntas");
            }

         
        }

        function agregarOpcion(contModulo,contPregunta){
            var contOp = parseInt($("#cuentaOpciones"+contModulo+'_'+contPregunta).val())+1; 
            $("#div_elementos"+contModulo+"_"+contPregunta).append('<div id="opcion'+contModulo+'-'+contOp+'"><div class="input-group"><span class="input-group-addon">'+contOp+'.-</span><input type="text" class="form-control col-md-12" name="txt_Opcion'+contModulo+'-'+contPregunta+'-'+contOp+'" id="txt_Opcion'+contModulo+'-'+contPregunta+'-'+contOp+'" placeholder="Ingresar Opción"><input type="hidden" id="txt_IDOpcion'+contModulo+'_'+contPregunta+'" name="txt_IDOpcion'+contModulo+'_'+contPregunta+'" value="'+contOp+'"></div><br></div>');
            alertify.log("Opción "+contOp+" de la pregunta "+contPregunta+" del módulo "+contModulo+" creada!");
            $("#cuentaOpciones"+contModulo+'_'+contPregunta).val(contOp);
        }

        function quitarOpcion(contModulo,contPregunta){
            var contOp = parseInt($("#cuentaOpciones"+contModulo+'_'+contPregunta).val());
            $("#opcion"+contModulo+"-"+contOp).remove();
            if(contOp>0){
                alertify.log("Opción "+contOp+" de la pregunta "+contPregunta+" del módulo "+contModulo+" eliminada!");
                var contOp = parseInt($("#cuentaOpciones"+contModulo+'_'+contPregunta).val())-1;
                $("#cuentaOpciones"+contModulo+'_'+contPregunta).val(contOp);
            }

        }

        function vigencia(mod,preg,opcion){ 
            if ($("#vigModulo"+mod+"-"+preg+"-"+opcion).val()==1) {
                $("#vigModulo"+mod+"-"+preg+"-"+opcion).val(0);
                // $("#txt_Opcion"+opcion+"-"+preg).prop('disabled', true);
            }else{
                $("#vigModulo"+mod+"-"+preg+"-"+opcion).val(1);
                // $("#txt_Opcion"+opcion+"-"+preg).prop('disabled', false);  
            }
        }

        function vigenciaFoto(){
            if ($("#vigFotoGeneral").val()==1) {
                $("#vigFotoGeneral").val(0);
            }else{
                $("#vigFotoGeneral").val(1);
            }
        }

        function vigenciaDescuento(contMod){
            if ($("#vigDescuento"+contMod).val()==1) {
                $("#vigDescuento"+contMod).val(0);
            }else{
                $("#vigDescuento"+contMod).val(1);
            }
        }

        function vigenciaFotoMod(contMod){
            if ($("#vigFotoMod"+contMod).val()==1) {
                $("#vigFotoMod"+contMod).val(0);
            }else{
                $("#vigFotoMod"+contMod).val(1);
            }
        }

        function vigenciaObservacion(contMod){
            if ($("#vigObservacion"+contMod).val()==1) {
                $("#vigObservacion"+contMod).val(0);
            }else{
                $("#vigObservacion"+contMod).val(1);
            }
        }

        function vigenciaNoAplica(contMod,contPreg){
            if ($("#vigNoAplica"+contMod+"-"+contPreg).val()==1) {
                $("#vigNoAplica"+contMod+"-"+contPreg).val(0);
            }else{
                $("#vigNoAplica"+contMod+"-"+contPreg).val(1);
            }
        }

        function vigenciaFotoOp(mod,preg,opcion){ 
            if ($("#vigFotoOp"+mod+"-"+preg+"-"+opcion).val()==1) {
                $("#vigFotoOp"+mod+"-"+preg+"-"+opcion).val(0);
            }else{
                $("#vigFotoOp"+mod+"-"+preg+"-"+opcion).val(1);
            }
        }
        
        function editarQuiz() {
            var val = 0;
            var formData = new FormData(document.getElementById("frmEditarQuizStatic"));
            var titulo_trivia = $("#txt_titulo_trivia").val();
            var total = new Array();
            var totals = 0;
            var contadorValPor = 1;
            var nModulos = $("#txt_contador_modulo").val();
            var contadorModulo = 1;
            var contadorPregunta = 1;
            var contadorOpcion = 1;

            if (titulo_trivia=='') {
                alertify.error("El nombre de la trivia no puede quedar vacío.");
                $("#txt_titulo_trivia").focus();
                val=1;
            }

            for (var i = 0; i < nModulos; i++) {
                total[i] = $("#porcentaje"+contadorValPor).val();      
                contadorValPor++;
            } 

            for (var i = 0; i < total.length; i++) {
                totals = parseFloat(totals) +  parseFloat(total[i]);
            }

            if (totals!=100) {
                alertify.error("Los valores deben sumar 100%");
                val=1;
            }

            for (var i = 0; i < nModulos; i++) {
                if ($("#porcentaje"+contadorModulo).val()>100) {
                    alertify.error("El porcentaje del módulo "+contadorModulo+" no puede ser mayor a 100%");
                    $("#porcentaje"+contadorModulo).focus();
                    val=1;
                    break;
                }
                if ($("#porcentaje"+contadorModulo).val()<0) {
                    alertify.error("El porcentaje del módulo "+contadorModulo+" no puede ser menor a 0%");
                    $("#porcentaje"+contadorModulo).focus();
                    val=1;
                    break;
                }
                if ($("#nombreModulo"+contadorModulo).val()=='') {
                    alertify.error("El nombre del módulo "+contadorModulo+" no puede quedar vacío.");
                    $("#nombreModulo"+contadorModulo).focus();
                    val=1;
                    break;
                }
                if ($("#porcentaje"+contadorModulo).val()=='') {
                    alertify.error("El porcentaje del módulo "+contadorModulo+" no puede quedar vacío.");
                    $("#porcentaje"+contadorModulo).focus();
                    val=1;
                    break;
                }
                if ($("#txt_IDPreg"+contadorModulo).val()==0) {
                    alertify.error("El módulo "+contadorModulo+" no contiene preguntas.");
                    $("#div_modulo"+contadorModulo).focus();
                    val=1;
                    break;
                }
                for (var j = 0; j < $("#txt_IDPreg"+contadorModulo).val(); j++) {
                    if($("#nombrePregunta"+contadorModulo+"-"+contadorPregunta).val()==''){
                        alertify.error("La pregunta "+contadorPregunta+" del módulo "+contadorModulo+" no puede quedar vacía");
                        $("#nombrePregunta"+contadorModulo+"-"+contadorPregunta).focus();
                        val=1;
                        break;
                    }
                    if($("#cuentaOpciones"+contadorModulo+"_"+contadorPregunta).val()==0){
                        alertify.error("La pregunta "+contadorPregunta+" del módulo "+contadorModulo+" no contiene opciones");
                        val=1;
                        break;
                    }
                    if($("#cuentaOpciones"+contadorModulo+"_"+contadorPregunta).val()==1){
                        alertify.error("La pregunta "+contadorPregunta+" del módulo "+contadorModulo+" debe tener a lo menos dos opciones");
                        val=1;
                        break;
                    }
                    if($("#txt_resp"+contadorModulo+"-"+contadorPregunta).val()==''){
                        alertify.error("La respuesta correcta de la pregunta "+contadorPregunta+" del módulo "+contadorModulo+" no puede quedar vacía");
                        $("#txt_resp"+contadorModulo+"-"+contadorPregunta).focus();
                        val=1;
                        break;
                    }
                    if($("#txt_resp"+contadorModulo+"-"+contadorPregunta).val()<1){
                        alertify.error("La respuesta correcta de la pregunta "+contadorPregunta+" del módulo "+contadorModulo+" no puede ser menor a 1");
                        $("#txt_resp"+contadorModulo+"-"+contadorPregunta).focus();
                        val=1;
                        break;
                    }
                    if($("#txt_resp"+contadorModulo+"-"+contadorPregunta).val()>$("#cuentaOpciones"+contadorModulo+"_"+contadorPregunta).val()){
                        alertify.error("La respuesta correcta de la pregunta "+contadorPregunta+" del módulo "+contadorModulo+" no puede ser mayor al total de opciones");
                        $("#txt_resp"+contadorModulo+"-"+contadorPregunta).focus();
                        val=1;
                        break;      
                    }
                    for (var k = 0; k < $("#cuentaOpciones"+contadorModulo+"_"+contadorPregunta).val(); k++) {
                        if ($("#txt_Opcion"+contadorModulo+"-"+contadorPregunta+"-"+contadorOpcion).val()==''){
                            alertify.error("La opción "+contadorOpcion+" de la pregunta "+contadorPregunta+" del módulo "+contadorModulo+" no puede quedar vacía.");
                            $("#txt_Opcion"+contadorModulo+"-"+contadorPregunta+"-"+contadorOpcion).focus();
                            val=1;
                            break; 
                        }
                        if($("#vigModulo"+contadorModulo+'-'+contadorPregunta+'-'+contadorOpcion).val()==0 && $("#txt_resp"+contadorModulo+'-'+contadorPregunta).val()==contadorOpcion){
                            alertify.error("La opción "+contadorOpcion+" de la pregunta "+contadorPregunta+" del módulo "+contadorModulo+" no puede ser desactivada ya que coincide con la respuesta correcta");
                            $("#txt_Opcion"+contadorModulo+"-"+contadorPregunta+"-"+contadorOpcion).focus();
                            val=1;
                            break;
                        }
                            contadorOpcion++;
                    }
                    contadorOpcion=1;
                    contadorPregunta++;
                }
                contadorPregunta=1;
                contadorModulo++;
            }

            if (val==0) { 
                $("#quizT").hide("slow");
                $("#cargandoQ").show("slow");             
                $.ajax({
                    url: "EditarTriviaF",
                    type: "POST",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        alertify.success("Trivia "+titulo_trivia+" editada!");
                            setTimeout(function(){
                            window.location = "adminTrivia";
                        }, 1000); 
                    }
                });
            }
        }

        function subirArchivo(pregunta){
            $.ajax({
                url: "subirArchivo",
                type: "POST",
                data: "pregunta="+pregunta,
                success: function(data){
                    $("#subirArchivo").html("");
                    $("#subirArchivo").html(data);
                    $("#modal-subirArchivo").modal('show');
                }
            });
        }

    </script>