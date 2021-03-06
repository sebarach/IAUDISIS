<link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/css/switch-especial.css">
<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo site_url(); ?>Adm_ModuloFormulario/adminFormulario">Administración de Formularios</a>
        </li>
        <li class="breadcrumb-item active">Editar Formularios</li>
    </ol>
    <div class="container-fluid">        
         <div class="animated fadeIn">
            <h4 class="text-theme">Editar Formularios</h4>            
            <br>
            <form class="form-horizontal" id="FormNuevoFormulario">
                <div class="row">                
                    <div class="col-sm-12">
                        <div class="card">
                            <br>
                            <?php echo $Formulario; ?>
                            <div id="agregaModulos"></div>
                            <div class="form-group">
                                <button type="button" class="btn btn-theme btn-sm" name="agre_modulo" onclick="addModulo();">Agregar Módulo</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="button" class="btn btn-theme btn-sm" name="agre_formu" onclick="EditarFormulario();">Modificar Formulario</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script type="text/javascript">

function addModulo(){
    if ($('#nombre_formu').val() != ""){
      var contModulo = parseInt($("#cuentaModulos").val()) + 1;
      $("#agregaModulos").append('<div id="numeroModulo'+contModulo+'" class="border-modulo"><span class="pull-right" style="padding-bottom: 1.5%;" ><button type="button" class="btn btn-theme btn-sm"><i class="fa fa-eye-slash"></i></button></span><p class="margin"><input id="ordenM-'+contModulo+'" min="1" max="'+contModulo+'" type="number" value="'+contModulo+'" onchange="ordenarM();" style="width: 2.5%;" name="ordenM-'+contModulo+'"> Módulo </p><input type="text" class="form-control" id="nombreModulo'+contModulo+'" name="nombreModulo'+contModulo+'" placeholder="Nombre del modulo"><input type="hidden" id="txt_IDModulo'+contModulo+'" name="txt_IDModulo'+contModulo+'" value="000"><br><div class="input-group"><p class="margin"><i class="fa fa-dot-circle-o"></i> Activo</p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" onclick="vigenciaModulo('+contModulo+');" id="vigModulo'+contModulo+'" name="vigModulo'+contModulo+'" value="1" checked><span class="slider round"></span></label></span></div><br><div id="agregaPreguntas'+contModulo+'"></div><input id="cuentaPreguntas'+contModulo+'" name="cuentaPreguntas'+contModulo+'" type="hidden" value="0"><div class="form__box"><button onclick="addPregunta('+contModulo+');" type="button" class="btn btn-theme btn-sm"><i class="fa fa-plus"></i> Agregar Pregunta</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></div><br id="brModulo'+contModulo+'">');
      $("#cuentaModulos").val(contModulo);
    }else{
      alertify.error("Falta ingresar un nombre al Formulario");
    }
}

function vigenciaModulo(contModulo){
    if ($('#vigModulo'+contModulo).val()==0){
        $('#vigModulo'+contModulo).val(1);
    }else{
        $('#vigModulo'+contModulo).val(0);
    }
}

function addPregunta(contModulo){
    var cont = parseInt($("#cuentaPreguntas"+contModulo).val()) + 1;
    $("#agregaPreguntas"+contModulo).append('<div id="numeroPregunta'+contModulo+'_'+cont+'" class="border-pregunta"><p class="margin"><input id="ordenP-'+contModulo+'_'+cont+'" min="1" max="'+cont+'" type="number" value="'+cont+'" style="width: 3.5%;" name="ordenP-'+contModulo+'_'+cont+'"> Pregunta</p><input type="text" class="form-control" id="nombrePregunta'+contModulo+'_'+cont+'" name="nombrePregunta'+contModulo+'_'+cont+'" placeholder="Texto de la pregunta"><input type="hidden" id="txt_IDPregunta'+contModulo+'_'+cont+'" name="txt_IDPregunta'+contModulo+'_'+cont+'"value="000"><br><p class="margin"><i class="fa fa-dot-circle-o"></i> Tipo de respuesta esperada</p><div class="input-group"><span class="input-group-addon"><i class="fa fa-toggle-right"></i></span><select id="typePregunta'+contModulo+'_'+cont+'" name="typePregunta'+contModulo+'_'+cont+'" class="form-control" onchange="elegirPregunta('+contModulo+','+cont+');"><option value="">Seleccione tipo de respuesta</option><?php foreach($TiposPreguntas as $type){ echo "<option value=".$type["ID_FormularioTipoPregunta"].">".$type["Nombre"]."</option>";} ?></select></div><br><input type="hidden" name="cuentaOpciones'+contModulo+'_'+cont+'" id="cuentaOpciones'+contModulo+'_'+cont+'" value="0"><div id="div_eleccion'+contModulo+'_'+cont+'"></div><div class="input-group"><p class="margin"><i class="fa fa-dot-circle-o"></i> Activo</p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" onclick="vigenciaPregunta('+contModulo+','+cont+');" id="vigPregunta'+contModulo+'_'+cont+'" name="vigPregunta'+contModulo+'_'+cont+'" value="1" checked><span class="slider round"></span></label></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p class="margin"><i class="fa fa-dot-circle-o"></i> Obligatorio</p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=""><label class="switch"><input type="checkbox" onclick="obligatorioPregunta('+contModulo+','+cont+');" id="oblPregunta'+contModulo+'_'+cont+'" name="oblPregunta'+contModulo+'_'+cont+'" value="1" checked><span class="slider round"></span></label></span></div></div><br id="brPregunta'+contModulo+'_'+cont+'">');
    $("#cuentaPreguntas"+contModulo).val(cont);
}

function vigenciaPregunta(contModulo,cont){
    if ($('#vigPregunta'+contModulo+'_'+cont).val()==0){
      $('#vigPregunta'+contModulo+'_'+cont).val(1);
    }else{
      $('#vigPregunta'+contModulo+'_'+cont).val(0);
    }
}

function obligatorioPregunta(contModulo,cont){    
    if ($('#oblPregunta'+contModulo+'_'+cont).val()==0){
      $('#oblPregunta'+contModulo+'_'+cont).val(1);
    }else{
      $('#oblPregunta'+contModulo+'_'+cont).val(0);
    }
}

function elegirPregunta(contModulo,cont){
    $("#div_eleccion"+contModulo+"_"+cont).html("");  
    $("#typePregunta"+contModulo+"_"+cont).val();  
    var opcion = $("#typePregunta"+contModulo+"_"+cont).val();
    if(opcion==5 || opcion==6){
        var contOp = parseInt($("#cuentaOpciones"+contModulo+'_'+cont).val()) + 1; 
        $("#div_eleccion"+contModulo+"_"+cont).append('<div class="input-group"><span class="input-group-addon"><i class="fa fa-circle"></i></span><input type="text" class="form-control" name="txt_elemento'+contModulo+'_'+cont+'_'+contOp+'" id="txt_elemento'+contModulo+'_'+cont+'_'+contOp+'" placeholder="Ingresar Nombre Elección"></div><input type="hidden" id="txt_IDOpcion'+contModulo+'_'+cont+'_'+contOp+'" name="txt_IDOpcion'+contModulo+'_'+cont+'_'+contOp+'" value="000"><div id="div_elementos'+contModulo+'_'+cont+'"></div><div class="form__box"><button type="button" class="btn btn-theme btn-sm" onclick="addElemento('+contModulo+','+cont+')"><i class="fa fa-plus"></i> Agregar Opción</button></div><br>');
        $("#cuentaOpciones"+contModulo+'_'+cont).val(contOp);
    }else if(opcion==7 ||opcion==14){
        $("#div_eleccion"+contModulo+"_"+cont).html("");
        $("#div_eleccion"+contModulo+"_"+cont).append('<div class="input-group"><span class="input-group-addon"><i class="fa fa-list-alt"></i></span><select class="form-control" name="txt_maestra'+contModulo+'_'+cont+'" id="txt_maestra'+contModulo+'_'+cont+'"><option value="">Elija una Maestra</option><?php foreach ($ListaMaestra as $l): ?><option value="<?php echo  $l["ID_Cluster"] ?>"><?php echo  $l["NombreCluster"] ?></option><?php endforeach; ?></select></div><input type="hidden" id="txt_IDElementos'+contModulo+'_'+cont+'" name="txt_IDElementos'+contModulo+'_'+cont+'" value="000"><br>');
    }else if(opcion==15 ){
        $("#div_eleccion"+contModulo+"_"+cont).html("");
        $("#div_eleccion"+contModulo+"_"+cont).append('<div class="input-group"><span class="input-group-addon"><i class="fa fa-list-alt"></i></span><select class="form-control" name="txt_maestra'+contModulo+'_'+cont+'" id="txt_maestra'+contModulo+'_'+cont+'"><option value="">Elija una Maestra</option><?php foreach ($ListaMaestraLocales as $l): ?><option value="<?php echo  $l["ID_Cluster"] ?>"><?php echo  $l["Nombre"] ?></option><?php endforeach; ?></select></div><input type="hidden" id="txt_IDElementos'+contModulo+'_'+cont+'" name="txt_IDElementos'+contModulo+'_'+cont+'" value="000"><br>');
    }
}

function addElemento(contModulo,cont){       
    var contOp = parseInt($("#cuentaOpciones"+contModulo+'_'+cont).val()) + 1;     
    $("#div_elementos"+contModulo+"_"+cont).append('<div class="input-group"><span class="input-group-addon"><i class="fa fa-circle"></i></span><input type="text" class="form-control" name="txt_elemento'+contModulo+'_'+cont+'_'+contOp+'" id="txt_elemento'+contModulo+'_'+cont+'_'+contOp+'" placeholder="Ingresar Nombre Elección"><input type="hidden" id="txt_IDOpcion'+contModulo+'_'+cont+'_'+contOp+'" name="txt_IDOpcion'+contModulo+'_'+cont+'_'+contOp+'" value="000"></div>');
    $("#cuentaOpciones"+contModulo+'_'+cont).val(contOp);
}

function EditarFormulario(){
    if ($('#nombre_formu').val()!=""){
        if(parseInt($("#cuentaModulos").val())>0){
            $("#nombre_formu").attr('class','form-control is-valid');
            var contModulo;
            var invalido=0;
            var total_modulos = parseInt($("#cuentaModulos").val());
            for (contModulo=1;contModulo<=total_modulos;contModulo++){
                var contPregunta;
                var total_preguntas = parseInt($("#cuentaPreguntas"+contModulo).val());
                if($("#nombreModulo"+contModulo).val()!=''){
                    $("#nombreModulo"+contModulo).attr('class','form-control is-valid');
                }else{
                    invalido+=1;
                    $("#nombreModulo"+contModulo).attr('class','form-control is-invalid');
                }
                for (contPregunta=1;contPregunta<=total_preguntas;contPregunta++){
                    var contOpciones;
                    var total_opciones = parseInt($("#cuentaOpciones"+contModulo+'_'+contPregunta).val());
                    if($("#nombrePregunta"+contModulo+'_'+contPregunta).val()!=''){
                        $("#nombrePregunta"+contModulo+'_'+contPregunta).attr('class','form-control is-valid');
                    }else{
                        invalido+=1;
                        $("#nombrePregunta"+contModulo+'_'+contPregunta).attr('class','form-control is-invalid');
                    }
                    if($("#typePregunta"+contModulo+'_'+contPregunta).val()!=''){
                        $("#typePregunta"+contModulo+'_'+contPregunta).attr('class','form-control is-valid');
                    }else{
                        invalido+=1;
                        $("#typePregunta"+contModulo+'_'+contPregunta).attr('class','form-control is-invalid');
                    }
                    for (contOpciones=1;contOpciones<=total_opciones;contOpciones++){
                        if($("#txt_elemento"+contModulo+'_'+contPregunta+'_'+contOpciones).val()!=''){
                            $("#txt_elemento"+contModulo+'_'+contPregunta+'_'+contOpciones).attr('class','form-control is-valid');
                        }else{
                            invalido+=1;
                            $("#txt_elemento"+contModulo+'_'+contPregunta+'_'+contOpciones).attr('class','form-control is-invalid');
                        }
                    }
                }
            }
            if (invalido > 0) {
                alertify.error("Hay "+invalido+" campos sin llenar en los modulos y/o preguntas");
            }else{
                $.ajax({
                    url: "<?php echo site_url(); ?>Adm_ModuloFormulario/nuevoFormulario",
                    method: "POST",
                    data: $("#FormNuevoFormulario").serialize(), 
                    success: function(data) {
                        if(data.match("OP1")){
                            alertify.success("Formulario Creado con éxito");
                            setTimeout(function(){
                                window.location = "adminFormulario";
                            }, 2000);
                        }else{
                            alertify.error("Error al crear el formulario");
                        }
                    }                    
                });
            }
        }else{
            alertify.error("No ha ingresado ningún módulo");
        }
    }else{
        $("#nombre_formu").attr('class','form-control is-invalid');
        alertify.error("Falta el Nombre del Formulario");
    }
  }

 
    function ordenarM(){
        // var cont = parseInt($("#cuentaPreguntas"+contModulo).val());
        var contModulo = parseInt($("#cuentaModulos").val()) + 1;
        


    } 

</script>