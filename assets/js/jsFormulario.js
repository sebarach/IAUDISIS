function dependeciasFormulariosP(form){
    $.ajax({
        url: "DependeciaFormularioPadre",
        type: "POST",
        data: "form="+form,
        success: function(data) {
           $("#modal-dependenciaP").html(""); 
           $("#modal-dependenciaP").html(data);
           $("#modal-depenP").modal("show");
        }
    });
}

function dependeciasFormulariosH(form,preg){
    $.ajax({
        url: "DependeciaFormularioHijo",
        type: "POST",
        data: "form="+form+"&preg="+preg,
        success: function(data) {
           $("#modal-dependenciaP").html(""); 
           setTimeout (function () {$("#modal-depenP").modal('hide')}, 10) 
           $("#modal-dependenciaH").html(""); 
           $("#modal-dependenciaH").html(data);
           setTimeout (function () { $("#modal-depenH").modal('show')} , 400) 
        }
    });
}

// function Fpadre(pregunta){
//     $("#txt_part1").val(pregunta);
//     document.getElementById("parteUno").style.display = 'none';
//     document.getElementById("parteDos").style.display = 'inline';
//     document.getElementById("estado"+pregunta).style.display = 'none';
// }

function cambiarDependencia(id){
    if($("#"+id).val()==1){
        $("#"+id).val(0);
        $("#r"+id).val("");
        document.getElementById("div_"+id).style.display = 'none';
    }else{
        $("#"+id).val(1);
        document.getElementById("div_"+id).style.display = 'inline';
    }

}

//Estado Formulario
function cambiarEstadoFormulario(Formulario,Estado){
    $.ajax({
        url: "cambiarEstadoFormulario",
        type: "POST",
        data: "Formulario="+Formulario+"&Estado="+Estado,
        success: function(data) {                
            if(Estado==1){
                $("#estadoFormulario1").html("");
                $("#estadoFormulario1").html(data);
                $("#modal-activar-formulario").modal('hide');
                $("#modal-desactivar-formulario").modal('show');
            }else{
                $("#estadoFormulario2").html("");
                $("#estadoFormulario2").html(data);
                $("#modal-desactivar-formulario").modal('hide');
                $("#modal-activar-formulario").modal('show');
            }                
        }
    });
}

function configFormulario(form){
    $.ajax({
        url: "ConfigFormulario",
        type: "POST",
        data: "form="+form,
        success: function(data) {
           $("#modal-configuracion").html(""); 
           $("#modal-configuracion").html(data);
           $("#modal-config").modal("show");
        }
    });
}

function cambiarCantidadFormulario(opcion){
    if(opcion==1){
        document.getElementById("div_cant").style.display = 'inline';
    }else{
        document.getElementById("div_cant").style.display = 'none';
        $("#txt_cantidad").val("0");
    }
}

function IngresarFormularioUs(){
    var validar=0;
    var validarlocal=0;
    var contador=$("#txt_contador").val();    
    for (var i = 0; i < contador; i++) {
        var pregunta = $("#pr"+i).val();
        var obligatorio = $("#O"+i).val();
        if(obligatorio=="1"){
            if($("#m"+pregunta).css('display') != 'none'){
                if($("#tp"+pregunta).val()=="15"){ 
                    if($("#txt_local").val()=="" ||  $("#txt_local").val()=="0"){
                        validarlocal++;                    
                    }
                } else if($("#tp"+pregunta).val()=="9"){
                    if($("#"+pregunta+"0").is(':checked') || $("#"+pregunta+"1").is(':checked')){
                        
                    }else{
                        validar++;                    
                    }    
                } else if($("#tp"+pregunta).val()=="8"){
                    if($("#idfoto"+pregunta).val()==""){
                        if($("#i"+pregunta).val()==""){
                            validar++;
                        }
                    }   
                } else if($("#tp"+pregunta).val()=="14"){
                    if($("#i"+pregunta).val()==""){
                        validar++;
                    } else {
                        $("#CheckML-"+pregunta).find("input[type=checkbox]").each(function(){
                            if(!$(this).is(":checked")){
                                validar++;
                            }
                        });
                    }
                } else{
                    if($("#i"+pregunta).val()==""){
                        validar++;
                    }else{
                        
                    }    
                }       
            }
        }
        if($("#tp"+pregunta).val()=="14" || $("#tp"+pregunta).val()=="6"){
            var cantOp=$("#cantOpcion_"+i).val();
            var depOb=$("#cantPreg_"+i).val();      
            if(cantOp>0 && depOb>0){
                for (var CO = 1; CO < cantOp; CO++) {  
                    if($("#depResp-"+CO+i).val()=="1"){
                        for (var CP = 1; CP < depOb; CP++) {
                            if($("#depOb"+i+"-"+CO+"-"+CP).val()=="1"){
                                var DepPreg=$("#depreg"+i+"-"+CO+"-"+CP).val();                            
                                if($("#deptipo"+i+"-"+CO+"-"+CP).val()=="1"){ 
                                    if($("input[name=p"+i+"-"+CO+"-"+CP+"]").val()==""){
                                        validar++; 
                                    }
                                }else if($("#deptipo"+i+"-"+CO+"-"+CP).val()=="3"){
                                    if($("input[name=p"+i+"-"+CO+"-"+CP+"]").val()==""){
                                        validar++; 
                                    }
                                }else if($("#deptipo"+i+"-"+CO+"-"+CP).val()=="5"){
                                    if($("select[name=p"+i+"-"+CO+"-"+CP+"]").val()==""){
                                        validar++; 
                                    }
                                }else if($("#deptipo"+i+"-"+CO+"-"+CP).val()=="8"){
                                    if($("input[name=p"+i+"-"+CO+"-"+CP+"]").val()==""){
                                        validar++; 
                                    }
                                }
                            }
                        }
                    }                    
                }
            }
        }
    }
    if(validarlocal==0){
        if(validar==0){
            if ($("#f_latitud").val()!='' && $("#f_longitud").val()!='') {
                $("#bt_agregar").attr("disabled","");
                $("#incMar").attr("class","fa fa-spin fa-circle-o-notch");
                $("#loader").removeAttr("style","table-loading-overlay");
                var formData = new FormData(document.getElementById("Formulario"));
                $.ajax({
                    url: "IngresarFormularioUsuario",
                    type: "POST",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#bt_agregar").removeAttr("disabled","");
                        $("#incMar").removeAttr("class","fa fa-spin fa-circle-o-notch");
                        // $("#loader").Attr("style","display: none;");
                        swal("Formulario Registrado", "Se ha guardado su formulario con exito.", "success");
                        setTimeout(function(){window.location = "/audisis/App_ModuloTareas/elegirTareasAsignadas";}, 2500);
                    }
                });
            }else{
                swal({
                title: "Error",
                text: " Tienes que confirmar tu ubicación para guardar el formulario.",
                type: "error",
                showCancelButton: false,
                      confirmButtonClass: 'btn-danger',
                      confirmButtonText: 'Aceptar'
              }); 
            }
        }else{
            swal({
                title: "Alerta",
                text: " Faltan "+validar+" por responder.",
                type: "error",
                showCancelButton: false,
                      confirmButtonClass: 'btn-danger',
                      confirmButtonText: 'Aceptar'
              }); 
        }   
    }else{
        swal({
            title: "Alerta",
            text: " Tiene que escoger el Local",
            type: "error",
            showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
          }); 
    } 
}

     // Translated
    $('.dropify').dropify({
        messages: {
            default: 'Subir Imagen',
            replace: 'Nueva Fotografía',
            remove:  'Eliminar',
            error:   '-vacio-'
        },

        defaultFile: '',
        maxFileSize: 0,
        minWidth: 0,
        maxWidth: 0,
        minHeight: 0,
        maxHeight: 0,
        showRemove: true,
        showLoader: true,
        showErrors: true,
        errorTimeout: 3000,
        errorsPosition: 'overlay',
        imgFileExtensions: ['png', 'jpg', 'jpeg'],
        maxFileSizePreview: "10M",
        allowedFormats: ['portrait', 'square', 'landscape'],
        allowedFileExtensions: ['png', 'jpg', 'jpeg'],
         error: {
            'fileSize': 'The file size is too big ({{ value }} max).',
            'minWidth': 'The image width is too small ({{ value }}}px min).',
            'maxWidth': 'The image width is too big ({{ value }}}px max).',
            'minHeight': 'The image height is too small ({{ value }}}px min).',
            'maxHeight': 'The image height is too big ({{ value }}px max).',
            'imageFormat': 'The image format is not allowed ({{ value }} only).',
            'fileExtension': 'Formato Incorrecto, ingresar fotos con formato ({{ value }}).'
        },
        tpl: {
            wrap:            '<div class="dropify-wrapper"></div>',
            loader:          '<div class="dropify-loader"></div>',
            message:         '<div class="dropify-message" style="padding-top: 0px; padding-bottom: 50px;"><span class="file-icon" />{{ default }}</div>',
            preview:         '<div class="dropify-preview" style="width: 200px; height:100px" ><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-infos-message">{{ replace }}</p></div></div></div>',
            filename:        '<p class="dropify-filename"><span class="dropify-filename-inner"></span></p>',
            clearButton:     '<button type="button" class="dropify-clear">{{ remove }}</button>',
            errorLine:       '<p class="dropify-error">{{ error }}</p>',
            errorsContainer: '<div class="dropify-errors-container"><ul></ul></div>'
        }
    });

    Dropify.prototype.isImage = function()
    {
      if (this.settings.imgFileExtensions.indexOf(this.getFileType()) != "-1") {
          return true;
      }
      return false;
    };


    //Estado Formulario Especial
function cambiarEstadoFormularioEspecial(Formulario,Estado){
    $.ajax({
        url: "cambiarEstadoFormularioEspecial",
        type: "POST",
        data: "Formulario="+Formulario+"&Estado="+Estado,
        success: function(data) {                
            if(Estado==1){
                $("#estadoFormulario1").html("");
                $("#estadoFormulario1").html(data);
                $("#modal-activar-formulario").modal('hide');
                $("#modal-desactivar-formulario").modal('show');
            }else{
                $("#estadoFormulario2").html("");
                $("#estadoFormulario2").html(data);
                $("#modal-desactivar-formulario").modal('hide');
                $("#modal-activar-formulario").modal('show');
            }                
        }
    });
}

    //Grupo Local Formulario Especial
function configFormularioEspecialGrupoLocal(Formulario){
    $("#txt_formu").val(Formulario);
    $("#modal-asignar").modal('show');    
}

    
function cambiarRegionFormEsp(){
    var region = $("#txt_idregion").val();
    var formulario = $("#txt_formulario").val();
    if(region!=""){
        $.ajax({
            url: "cambiarRegionFormEsp",
            type: "POST",
            data: "region="+region+"&formulario="+formulario,
            success: function(data) {                
                if(data!=""){
                    $("#txt_ciudad").html('');
                    $("#txt_ciudad").html("<option value=''>Elegir Provincia</option>");  
                    document.getElementById("div_ciudad").style.display = 'inline';
                    $("#txt_ciudad").append(data);
                    document.getElementById("div_comuna").style.display = 'none';
                    document.getElementById("div_local").style.display = 'none';
                    document.getElementById("div_direccion").style.display = 'none';
                    $("#txt_comuna").val();
                    $("#txt_local").val();
                    $("#txt_direccion").val("");
                }else{
                    document.getElementById("div_ciudad").style.display = 'none';
                    document.getElementById("div_comuna").style.display = 'none';
                    document.getElementById("div_local").style.display = 'none';
                    document.getElementById("div_direccion").style.display = 'none';
                    $("#txt_ciudad").val();
                    $("#txt_comuna").val();
                    $("#txt_local").val();
                    $("#txt_direccion").val("");
                }                
            }
        });   
    }else{
        document.getElementById("div_ciudad").style.display = 'none';
        document.getElementById("div_comuna").style.display = 'none';
        document.getElementById("div_local").style.display = 'none';
         document.getElementById("div_direccion").style.display = 'none';
        $("#txt_ciudad").val();
        $("#txt_comuna").val();
        $("#txt_local").val();
        $("#txt_direccion").val("");
    }
}

function cambiarCiudadFormEsp(){
    var ciudad = $("#txt_ciudad").val();
    var formulario = $("#txt_formulario").val();
    if(ciudad!=""){
        $.ajax({
            url: "cambiarCiudadFormEsp",
            type: "POST",
            data: "ciudad="+ciudad+"&formulario="+formulario,
            success: function(data) {                
                if(data!=""){
                    $("#txt_comuna").html('');
                    $("#txt_comuna").html("<option value=''>Elegir Distrito</option>");  
                    document.getElementById("div_comuna").style.display = 'inline';
                    $("#txt_comuna").append(data);
                    document.getElementById("div_local").style.display = 'none';
                    document.getElementById("div_direccion").style.display = 'none';
                    $("#txt_local").val();
                    $("#txt_direccion").val("");
                }else{
                    document.getElementById("div_comuna").style.display = 'none';
                    document.getElementById("div_local").style.display = 'none';
                    document.getElementById("div_direccion").style.display = 'none';
                    $("#txt_comuna").val();
                    $("#txt_local").val();
                    $("#txt_direccion").val("");
                }                
            }
        });   
    }else{
        document.getElementById("div_comuna").style.display = 'none';
        document.getElementById("div_local").style.display = 'none';
         document.getElementById("div_direccion").style.display = 'none';
        $("#txt_comuna").val();
        $("#txt_local").val();
        $("#txt_direccion").val("");
    }
}

function cambiarComunaFormEsp(){
    var comuna = $("#txt_comuna").val();
    var formulario = $("#txt_formulario").val();
    if(comuna!=""){
        $.ajax({
            url: "cambiarComunaFormEsp",
            type: "POST",
            data: "comuna="+comuna+"&formulario="+formulario,
            success: function(data) {                
                if(data!=""){
                    $("#txt_local").html('');
                    $("#txt_local").html("<option value=''>Elegir Local</option>");  
                    document.getElementById("div_local").style.display = 'inline';
                    $("#txt_local").append(data);
                    document.getElementById("div_direccion").style.display = 'none';
                    $("#txt_direccion").val("");
                }else{
                    document.getElementById("div_local").style.display = 'none';
                    document.getElementById("div_direccion").style.display = 'none';
                    $("#txt_local").val();
                    $("#txt_direccion").val("");
                }                
            }
        });   
    }else{
        document.getElementById("div_local").style.display = 'none';
        document.getElementById("div_direccion").style.display = 'none';
        $("#txt_local").val();
        $("#txt_direccion").val("");
    }
}

function validarDireccionLocal(){
    var local = $("#txt_local").val();
    if(local!=""){
        $.ajax({
            url: "validarDireccionLocal",
            type: "POST",
            data: "local="+local,
            success: function(data) {   
                if(data!=""){
                    $("#txt_direccion").val(data); 
                    document.getElementById("div_direccion").style.display = 'none';                    
                }else{                    
                    document.getElementById("div_direccion").style.display = 'inline';                    
                    $("#txt_direccion").val("");
                }                
            }
        });   
    }else{        
        document.getElementById("div_direccion").style.display = 'none';        
        $("#txt_direccion").val("");
    }
}

function IngresarFormularioEspUs(){
    var validar=0;  
    if($("#txt_local").val()==""){
        validar++;  
    }
    if($("#txt_direccion").val()==""){
        validar++;  
    }    
    if(validar==0){
        if($("#f_latitud").val()!='' && $("#f_longitud").val()!='') {
            $("#bt_agregar").attr("disabled","");
            $("#incMar").attr("class","fa fa-spin fa-circle-o-notch");
            $("#loader").removeAttr("style","table-loading-overlay");
            var formData = new FormData(document.getElementById("FormularioEspecial1"));
            $.ajax({
                url: "IngresarFormularioEspecialUsuario",
                type: "POST",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#bt_agregar").removeAttr("disabled","");
                    $("#incMar").removeAttr("class","fa fa-spin fa-circle-o-notch");
                    // $("#loader").Attr("style","display: none;");
                    swal("Formulario Registrado", "Se ha guardado su formulario con exito.", "success");
                    setTimeout(function(){window.location = "/audisis/App_ModuloTareas/elegirTareasAsignadas";}, 2500);
                }
            });
        }else{
            swal({
            title: "Error",
            text: " Tienes que confirmar tu ubicación para guardar el formulario.",
            type: "error",
            showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
          }); 
        }
    }else{
        swal({
            title: "Alerta",
            text: " Faltan "+validar+" por responder.",
            type: "error",
            showCancelButton: false,
                  confirmButtonClass: 'btn-danger',
                  confirmButtonText: 'Aceptar'
          }); 
    } 
}

function elegirClienteDuplicar(){
    var cliente = $("#lb_cliente").val();
    if(cliente!=""){
        $.ajax({
            url: "buscarFormulariosDuplicar",
            type: "POST",
            data: "cliente="+cliente,
            success: function(data) {                
                if(data!=""){
                    $("#lb_formulario").html('');
                    $("#lb_formulario").html("<option value=''>Elegir Formulario</option>");  
                    $("#lb_formulario").append(data);
                    $("#div_formulario").show("slow");
                    $("#div_nombre").show("slow");
                    $("#bt_guardar").hide("slow");
                    $("#lb_formulario").val();
                    $("#txt_nuevonombre").val("");
                }else{
                    $("#div_formulario").hide("slow");
                    $("#div_nombre").hide("slow");
                    $("#bt_guardar").hide("slow");
                    $("#lb_formulario").val();
                    $("#txt_nuevonombre").val("");
                }                
            }
        });   
    }else{
        $("#div_formulario").hide("slow");
        $("#div_nombre").hide("slow");
        $("#bt_guardar").hide("slow");
        $("#lb_formulario").val();
        $("#txt_nuevonombre").val("");
    }
}

function validardatosDuplicar(){
    if($("#lb_formulario").val()!="" && $("#txt_nuevonombre").val()!=""){
        $("#bt_guardar").show("slow");
    }else{
        $("#bt_guardar").hide("slow");
    }
}