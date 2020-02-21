<link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/css/switch-especial.css">
<main class="main" style="height: 100%;">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
             <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Trivia</a>
        </li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">  
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-theme">Crear Trivia</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="animated fadeIn">      
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="btn btn-round btn-outline-danger" onclick="agregarModulo();"><i class="mdi mdi-plus-circle-outline"></i>Agregar Módulo</button>
                            <button type="button" class="btn btn-round btn-outline-danger float-right" onclick="quitarModulo();"><i class="mdi mdi-minus-circle-outline"></i>Quitar Módulo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="container-fluid" style="display: none;" id="preguntas">
        <form method="POST" id="frmQuiz">
            <div class="animated fadeIn">  
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-theme">   
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-1">
                                        Fotografía<span class="" style="margin-top:0.7%;"><label class="switch"><input type="checkbox" id="checkTrivia" name="checkTrivia"><span class="slider round"></span></label></span>
                                    </div>
                                    <div class="col-md-1">
                                        Cargar Clúster<span class="" style="margin-top:0.7%;"><label class="switch"><input type="checkbox" id="checkCluster" name="checkCluster" onchange="desplegarLista();" value="0"><span class="slider round"></span></label></span>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="text" id="txt_trivia" name="txt_trivia" class="form-control" placeholder="Título Trivia">
                                            <span class="input-group-btn">
                                                <button id="btnGuardar" type="button" class="btn btn-theme" onclick="guardarTrivia();"><i class="fa fa-save" id="icGuardar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="input-group" style="display: none;" id="select_maestra">
                                        <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                        <select name="lb_lista_maestra" id="lb_lista_maestra" class="form-control form-control-sm">
                                            <option value="">Elija una Lista Maestra</option>
                                            <?php 
                                                foreach ($ListaMaestraLocales as $lt) {
                                                    echo "<option value='".$lt['ID_Cluster']."'>".$lt['Nombre']."</option>";
                                                }
                                            ?>
                                        </select> 
                                    </div>
                                </div>
                                <ul id="sortable" class="list-group">
                                    <input type="hidden" id="txt_IDModulo" name="txt_IDModulo" value="0">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </form>  
    </div>  
    
</main>
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script type="text/javascript">

    function desplegarLista(){
        if ($("#checkCluster").val()==0) {
            $("#select_maestra").show("slow");
            $("#checkCluster").val(1);
        }else{
            $("#select_maestra").hide("slow");
            $("#checkCluster").val(0);
        } 
    }
    $("#sortable").sortable();
    function agregarModulo(){
        $("#preguntas").show();
        var contModulo = parseInt($("#txt_IDModulo").val())+1;
        $("#sortable").append('<input type="hidden" id="txt_IDModulo'+contModulo+'" name="txt_IDModulo'+contModulo+'" value="'+contModulo+'"><li class="list-group-item" id="li'+contModulo+'"><div class="card border-danger text-danger"><div class="card-header">Módulo '+contModulo+'<div class="row input-group">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="form-control col-md-5" id="txtTituloModulo'+contModulo+'" name="txtTituloModulo'+contModulo+'" placeholder="Título Módulo '+contModulo+'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="number" class="form-control col-md-2" id="txtPorcentajeModulo'+contModulo+'" name="txtPorcentajeModulo'+contModulo+'" placeholder="Porcentaje Módulo '+contModulo+'">&nbsp;&nbsp;<p class="margin" style="margin-top:1%;"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p style="margin-top:1%;">Módulo con Descuento</p></p>&nbsp;&nbsp;<span class="" style="margin-top:0.7%;"><label class="switch"><input type="checkbox" id="checkDesc'+contModulo+'" name="checkDesc'+contModulo+'"><span class="slider round"></span></label></span>&nbsp;&nbsp;<p class="margin" style="margin-top:1%;">&nbsp;&nbsp;<p class="margin" style="margin-top:1%;"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p style="margin-top:1%;">Fotografía</p></p>&nbsp;&nbsp;<span class="" style="margin-top:0.7%;"><label class="switch"><input type="checkbox" id="checkFoto'+contModulo+'" name="checkFoto'+contModulo+'"><span class="slider round"></span></label></span>&nbsp;&nbsp;<p class="margin" style="margin-top:1%;"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p style="margin-top:1%;">Observación</p></p>&nbsp;&nbsp;<span class="" style="margin-top:0.7%;"><label class="switch"><input type="checkbox" id="checkObs'+contModulo+'" name="checkObs'+contModulo+'"><span class="slider round"></span></label></span></div></div><div class="card-body" id="div_modulo'+contModulo+'" tabindex="1"></div></div><div class="form__box"><button type="button" class="btn btn-theme btn-sm" onclick="agregarPregunta('+contModulo+')"><i class="mdi mdi-plus-circle-outline"></i> Agregar Pregunta</button><button type="button" class="btn btn-theme btn-sm" onclick="quitarPregunta('+contModulo+')"><i class="mdi mdi-minus-circle-outline"></i> Quitar Pregunta</button></div></li><input type="hidden" id="txt_IDPreg'+contModulo+'" value="0"><input type="hidden" id="txt_IDOpcion'+contModulo+'" value="0">');
        $("#txt_IDModulo").val(contModulo);
    }
    function quitarModulo(){
        var contModulo = parseInt($("#txt_IDModulo").val());
        if(contModulo>0){
            $("#li"+contModulo).remove();
            var contModulo = parseInt($("#txt_IDModulo").val())-1;
            $("#txt_IDModulo").val(contModulo);
        } 
        if (contModulo==0) {
            $("#preguntas").hide();
        }
    }
    function agregarPregunta(contModulo){
        var contPregunta = parseInt($("#txt_IDPreg"+contModulo).val())+1;
        $("#div_modulo"+contModulo).append('<div id="pregunta'+contModulo+'-'+contPregunta+'"><input type="hidden" id="txt_IDPreg'+contModulo+'-'+contPregunta+'" value="'+contPregunta+'"><div class="card border-warning text-warning"><div class="card-header">'+contPregunta+'.-<div class="row input-group">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="form-control col-md-10" id="txtTituloPregunta'+contModulo+'-'+contPregunta+'" name="txtTituloPregunta'+contModulo+'-'+contPregunta+'" placeholder="Pregunta '+contPregunta+'">&nbsp;&nbsp;&nbsp;&nbsp;<p class="margin" style="margin-top:1%;"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p style="margin-top:1%;">Opción No Aplica</p></p>&nbsp;&nbsp;<span class="" style="margin-top:0.7%;"><label class="switch"><input type="checkbox" id="checkNoApl'+contModulo+'_'+contPregunta+'" name="checkNoApl'+contModulo+'_'+contPregunta+'"><span class="slider round"></span></label></span></div></div><div class="card-body"><p class="margin"><i class="fa fa-dot-circle-o"></i> Opciones</p><div class="col-md-12" id="div_elementos'+contModulo+'-'+contPregunta+'"><div class="input-group"><div class="col-md-12" id="div_elementos'+contModulo+'_'+contPregunta+'"></div></div><hr><div class="input-group col-md-6"><span class="input-group-addon"><i class="mdi mdi-checkbox-marked-circle-outline"></i></span><input type="number" class="form-control" name="txt_resp'+contModulo+'-'+contPregunta+'" id="txt_resp'+contModulo+'-'+contPregunta+'" placeholder="Ingresar el número de la Respuesta Correcta"></div><br><br><div class="form__box"><button type="button" class="btn btn-warning btn-sm" onclick="agregarOpcion('+contModulo+','+contPregunta+')"><i class="mdi mdi-plus-circle-outline"></i> Agregar Opción</button><button type="button" class="btn btn-warning btn-sm" onclick="quitarOpcion('+contModulo+','+contPregunta+')"><i class="mdi mdi-minus-circle-outline"></i> Quitar Opción</button></div></div></div></div></div><input type="hidden" name="cuentaOpciones'+contModulo+'_'+contPregunta+'" id="cuentaOpciones'+contModulo+'_'+contPregunta+'" value="0"><input type="hidden" name="cuentaPreguntas'+contModulo+'" id="cuentaPreguntas'+contModulo+'" value="'+contPregunta+'">');
        $("#txt_IDPreg"+contModulo).val(contPregunta);
    }

    function agregarOpcion(contModulo,contPregunta){
        var contOp = parseInt($("#cuentaOpciones"+contModulo+'_'+contPregunta).val())+1; 
        $("#div_elementos"+contModulo+"_"+contPregunta).append('<div id="opcion'+contModulo+'-'+contOp+'"><div class="input-group"><span class="input-group-addon">'+contOp+'.-</span><input type="text" class="form-control col-md-10" name="txt_elemento'+contModulo+'_'+contPregunta+'_'+contOp+'" id="txt_elemento'+contModulo+'_'+contPregunta+'_'+contOp+'" placeholder="Ingresar Opción">&nbsp;&nbsp;&nbsp;&nbsp;<p class="margin" style="margin-top:1%;"><i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;<p style="margin-top:1%;">Fotografía</p></p>&nbsp;&nbsp;<span class="" style="margin-top:0.7%;"><label class="switch"><input type="checkbox" id="checkFotoOpcion'+contModulo+'_'+contPregunta+'_'+contOp+'" name="checkFotoOpcion'+contModulo+'_'+contPregunta+'_'+contOp+'"><span class="slider round"></span></label></span><input type="hidden" id="txt_IDOpcion'+contModulo+'_'+contPregunta+'" name="txt_IDOpcion'+contModulo+'_'+contPregunta+'" value="'+contOp+'"></div><br></div>');
        $("#cuentaOpciones"+contModulo+'_'+contPregunta).val(contOp);
    }

    function quitarOpcion(contModulo,contPregunta){
        var contOp = parseInt($("#cuentaOpciones"+contModulo+'_'+contPregunta).val()); 
        if (contOp>0) {
            $("#opcion"+contModulo+"-"+contOp).remove();
            var contOpci = parseInt($("#cuentaOpciones"+contModulo+'_'+contPregunta).val())-1;
            $("#cuentaOpciones"+contModulo+'_'+contPregunta).val(contOpci);
        }
    }

    function quitarPregunta(contModulo){
        var contPregunta = parseInt($("#txt_IDPreg"+contModulo).val());
        if(contPregunta>0){
            $("#pregunta"+contModulo+"-"+contPregunta).remove();
            var contPreg = parseInt($("#txt_IDPreg"+contModulo).val())-1;
            $("#txt_IDPreg"+contModulo).val(contPreg);
        }
    }

    function guardarTrivia(){
        var val=0;
        var contModulo=1;
        var contadorModulo=$("#txt_IDModulo").val();
        var contadorValPor=1;
        var total=new Array();
        var totals=0;
        var contadorModuloPregunta=1;
        var contadorModuloPreguntaOpcion=1;
        if ($("#txt_trivia").val()=='') {
            $("#txt_trivia").focus();
            alertify.error("Debe escribir el nombre de la trivia");
            val=1;
        }
        for (var i = 0; i < contadorModulo; i++) {
            total[i] = $("#txtPorcentajeModulo"+contadorValPor).val();      
            contadorValPor++;
        } 
        for (var i = 0; i < total.length; i++) 
        {
            totals = parseFloat(totals) +  parseFloat(total[i]);
        }
        if (totals!=100) {
            alertify.error("Los valores deben sumar 100%");
            val=1;
        }
        for (var i = 0; i < contadorModulo; i++) {
            if ($("#txt_IDPreg"+contModulo).val()==0) {
                alertify.error("El módulo "+contModulo+" debe tener a lo menos una pregunta");
                $("#div_modulo"+contModulo).focus();
                val=1;
                break;
            }
            if ($("#txtTituloModulo"+contModulo).val()=='') {
                alertify.error("Debe escribir el título del módulo "+contModulo);
                $("#txtTituloModulo"+contModulo).focus();
                val=1;
                break;
            }
            if ($("#txtPorcentajeModulo"+contModulo).val()=='') {
                alertify.error("Debe escribir el porcentaje del módulo "+contModulo);
                $("#txtPorcentajeModulo"+contModulo).focus();
                val=1;
                break;
            }
            if ($("#txtPorcentajeModulo"+contModulo).val()>100) {
                alertify.error("El porcentaje del módulo "+contModulo+" no puede ser mayor a 100%");
                $("#txtPorcentajeModulo"+contModulo).focus();
                val=1;
                break;
            }
            if ($("#txtPorcentajeModulo"+contModulo).val()<0) {
                alertify.error("El porcentaje del módulo "+contModulo+" no puede ser menor a 0%");
                $("#txtPorcentajeModulo"+contModulo).focus();
                val=1;
                break;
            }
            for (var j = 0; j < $("#txt_IDPreg"+contModulo).val(); j++) {
                if ($("#cuentaOpciones"+contModulo+"_"+contadorModuloPregunta).val()<2) {
                    alertify.error("La pregunta "+contadorModuloPregunta+" del módulo "+contModulo+" debe tener a lo menos dos opciones");
                    val=1;
                    break;
                }
                if ($("#txtTituloPregunta"+contModulo+"-"+contadorModuloPregunta).val()=='') {
                    alertify.error("Debe escribir el nombre de la pregunta "+contadorModuloPregunta+" en el módulo "+contModulo);
                    $("#txtTituloPregunta"+contModulo+"-"+contadorModuloPregunta).focus();
                    val=1;
                    break;
                }
                if ($("#txt_resp"+contModulo+"-"+contadorModuloPregunta).val()=='') {
                    alertify.error("Debe escribir el número de la respuesta correcta en el módulo "+contModulo);
                    $("#txt_resp"+contModulo+"-"+contadorModuloPregunta).focus();
                    val=1;
                    break;
                }
                if ($("#txt_resp"+contModulo+"-"+contadorModuloPregunta).val()<1) {
                    alertify.error("La respuesta correcta no puede ser menor a la cantidad mínima de opciones");
                    $("#txt_resp"+contModulo+"-"+contadorModuloPregunta).focus();
                    val=1;
                    break;
                }
                if ($("#txt_resp"+contModulo+"-"+contadorModuloPregunta).val()>$("#cuentaOpciones"+contModulo+"_"+contadorModuloPregunta).val()) {
                    alertify.error("La respuesta correcta no puede ser mayor a la cantidad máxima de opciones");
                    $("#txt_resp"+contModulo+"-"+contadorModuloPregunta).focus();
                    val=1;
                    break;
                }
                for (var o = 0; o <  $("#cuentaOpciones"+contModulo+"_"+contadorModuloPregunta).val(); o++) {
                    if ($("#txt_elemento"+contModulo+"_"+contadorModuloPregunta+"_"+contadorModuloPreguntaOpcion).val()=='') {
                        alertify.error("Debe escribir la opción en el módulo "+contModulo+", pregunta "+contadorModuloPregunta+" , opción "+contadorModuloPreguntaOpcion);
                        $("#txt_elemento"+contModulo+"_"+contadorModuloPregunta+"_"+contadorModuloPreguntaOpcion).focus();
                        val=1;
                        break;
                    }
                    contadorModuloPreguntaOpcion++;
                }
                contadorModuloPreguntaOpcion=1;
                contadorModuloPregunta++;
            }
            contadorModuloPregunta=1;
            contModulo++;
        }
        if (val==0) {
            $("#btnGuardar").attr("disabled", true);
            $('#icGuardar').attr("class","fa fa-spin fa-circle-o-notch");
            var formData = new FormData(document.getElementById("frmQuiz"));
            $.ajax({
                url: "IngresarTriviaPreguntas",
                type: "POST",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data==0) {
                        swal("Trivia Existente", "Ya se encuentra registrado el nombre de la trivia!", "error");
                        $("#txt_trivia").focus();
                        $("#btnGuardar").attr("disabled", false);
                        $('#icGuardar').attr("class","fa fa-save");
                    }else{
                        $("#preguntas").hide("slow");
                        swal("Trivia Guardada", "Trivia guardada con éxito!", "success");
                        setTimeout(function(){
                            window.location = "crearTriviaNormal";
                        }, 2000);
                    }
                    
                }
            });
        }
    }
</script>