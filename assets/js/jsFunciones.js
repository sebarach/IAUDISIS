 //Solo deja ingresar numeros
function SoloNumeros(e){
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8){
        return true;
    }
    patron =/[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

//Ingresar datos usuario y clave al crear usuario
function colocarDatosUsuario(){
  if($("#txt_rut").val()!=''){
    var user = $("#txt_rut").val();
    var cliente = $("#txt_nombreCli").val();
    var datosUser = user.replace('.','').replace('.','').split("-");
    var mitadCli = cliente.substring(0, 3);
    var mitadUser = datosUser[0].substring(datosUser[0].length - 5);    
    $("#txt_usuario").val(datosUser[0]);
    $("#txt_clave").val(mitadCli+mitadUser);       
  }
}

//elegir perfil Usuario
function cambiarPerfil(){
    if($("#lb_perfil").val()==2){
        document.getElementById("div_rut").style.display = 'none';
        document.getElementById("txt_usuario").readOnly = false;
        document.getElementById("txt_clave").readOnly = false;
    }else{
        document.getElementById("div_rut").style.display = 'inline';
        document.getElementById("txt_usuario").readOnly = true;
        document.getElementById("txt_clave").readOnly = true;
    }
}

//Listar marcacion usuario
function elegirMarcacion(){
    var fechas = $("#txt_libro").val();
    if($("#txt_libro").val()!=''){   
        // document.getElementById("div_filtros").style.display = 'inline';
        $.ajax({
        url: "mostrarLibroMarcacion",
        type: "POST",
        data: "fechas="+fechas,
        success: function(data){
                $("#div_libro").html("");
                $("#div_libro").html(data);
            }
        }); 
    }else{
        // document.getElementById("div_filtros").style.display = 'none';
        $("#div_libro").html("");        
    }
}

//elegir pfd o excel reporte
function elegirTipoDescarga(valor){
    var eleccion = document.getElementById("txt_eleccion");
    eleccion.value= valor;
}

function validarFechaLibroAsistencia(){
    if($("#txt_eleccion").val()==1){
        if($("#txt_libro").val()!='' && $("#txt_rango30").val()!=''){
            document.getElementById("dv_descargar").style.display = 'inline';
        }else{
            document.getElementById("dv_descargar").style.display = 'none';
        }
    }else if($("#txt_eleccion").val()==2){
        if($("#txt_libro").val()!=''){
            document.getElementById("dv_descargar").style.display = 'inline';
        }else{
            document.getElementById("dv_descargar").style.display = 'none';
        }
    }else if($("#txt_eleccion").val()==3){
        if($("#txt_libro").val()!=''){
            document.getElementById("dv_descargar").style.display = 'inline';
        }else{
            document.getElementById("dv_descargar").style.display = 'none';
        }
    }else if($("#txt_eleccion").val()==4){
        if($("#txt_libro").val()!=''){
            document.getElementById("dv_descargar").style.display = 'inline';
        }else{
            document.getElementById("dv_descargar").style.display = 'none';
        }
    }else if($("#txt_eleccion").val()==5){
        if($("#txt_libro").val()!=''){
            document.getElementById("dv_descargar").style.display = 'inline';
        }else{
            document.getElementById("dv_descargar").style.display = 'none';
        }
    }else if($("#txt_eleccion").val()==6 || $("#txt_eleccion").val()==7){
        if($("#txt_libro").val()!=''){
            document.getElementById("dv_descargarpdf").style.display = 'inline';
            document.getElementById("dv_descargarexcel").style.display = 'inline';
        }else{
            document.getElementById("dv_descargarpdf").style.display = 'none';
            document.getElementById("dv_descargarexcel").style.display = 'none';
        }
    } else {
        document.getElementById("dv_descargar").style.display = 'none';
        document.getElementById("dv_descargarpdf").style.display = 'none';
        document.getElementById("dv_descargarexcel").style.display = 'none';
    }
}

//Escoger Libro Asistencia
function elegirLibro(valor){
    $("#txt_eleccion").val(valor);
    if(valor==1){
        document.getElementById("div_libroAsis").style.display = 'inline';
        document.getElementById("div_rangoMulti").style.display = 'none'; 
        document.getElementById("dv_descargar").style.display = 'none';
        document.getElementById("div_rango30").style.display = 'inline';   
        $("#txt_libro").val("");    
        $("#txt_rango30").val("");   
    } else if(valor==2){   
        document.getElementById("div_libroAsis").style.display = 'inline';
        document.getElementById("div_rangoMulti").style.display = 'none'; 
        document.getElementById("dv_descargar").style.display = 'none';  
        document.getElementById("div_rango30").style.display = 'none';   
        $("#txt_libro").val("");    
    } else if(valor==3){
        document.getElementById("div_libroAsis").style.display = 'inline';
        document.getElementById("div_rangoMulti").style.display = 'none'; 
        document.getElementById("dv_descargar").style.display = 'none';
        document.getElementById("div_rango30").style.display = 'none';   
        $("#txt_libro").val("");    
    } else if(valor==4){
        document.getElementById("div_libroAsis").style.display = 'inline';
        document.getElementById("div_rangoMulti").style.display = 'none'; 
        document.getElementById("dv_descargar").style.display = 'none';
        document.getElementById("div_rango30").style.display = 'none';   
        $("#txt_libro").val("");    
    } else if(valor==5){
        document.getElementById("div_libroAsis").style.display = 'inline';
        document.getElementById("div_rangoMulti").style.display = 'none'; 
        document.getElementById("dv_descargar").style.display = 'none';
        document.getElementById("div_rango30").style.display = 'none';   
        $("#txt_libro").val("");    
    }else{
        document.getElementById("div_libroAsis").style.display = 'none';
        $("#txt_libro").val("");    
    }
}

//Validar Formato Email
function validarEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

//Validar Formato Numeros
function validarNumeros(valor){
    var regex = /^([0-9])*$/;
    return regex.test(valor);
}

//Validar Coordendas
function validarCoordenadas(valor){
    var regex = /^([0-9.-])*$/;
    return regex.test(valor);
}

//Mostrar Locales por el cadena
function ElegirLocalPorCadena(){
    var cadena = $("#lb_cadena").val();
    $.ajax({
        url: "elegirCadena",
        type: "POST",
        data: "cad="+cadena,
        success: function(data) {
            if(data==0){
                $("#lb_local").html('');
                $("#lb_local").html("<option value='-1'>Escoger un Local</option>");  
            }else{
                $("#lb_local").html('');
                $("#lb_local").html("<option value='-1'>Escoger un Local</option>");  
                $("#lb_local").append(data);
            }
        }
    });
}

//Mostrar Comunas por la region
function Region(region){
    var region = $("#lb_region").val();
    $.ajax({
        url: "elegirRegion",
        type: "POST",
        data: "reg="+region,
        success: function(data) {
            if(data==0){
                $("#lb_comuna").html('');
                $("#lb_comuna").html("<option value=''>Elija una Comuna</option>");  
            }else{
                $("#lb_comuna").html('');
                $("#lb_comuna").html("<option value=''>Elija una Comuna</option>");  
                $("#lb_comuna").append(data);
            }
        }
    });
}

function RegionCiudad(region){
    var region = $("#lb_region").val();
    $.ajax({
        url: "elegirCiudad",
        type: "POST",
        data: "reg="+region,
        success: function(data) {
            if(data==0){
                $("#lb_ciudad").html('');
                $("#lb_ciudad").html("<option value=''>Elija una Ciudad</option>");  
            }else{
                $("#lb_ciudad").html('');
                $("#lb_ciudad").html("<option value=''>Elija una Ciudad</option>");  
                $("#lb_ciudad").append(data);
            }
        }
    });
}

function CiudadComuna(){
    var ciudad = $("#lb_ciudad").val();
    $.ajax({
        url: "elegirComunaCiudad",
        type: "POST",
        data: "ciudad="+ciudad,
        success: function(data) {
            if(data==0){
                $("#lb_comuna").html('');
                $("#lb_comuna").html("<option value=''>Elija una Comuna</option>");  
            }else{
                $("#lb_comuna").html('');
                $("#lb_comuna").html("<option value=''>Elija una Comuna</option>");  
                $("#lb_comuna").append(data);
            }
        }
    });
}

//Estado Usuario
function cambiarEstadoUsuario(Usuario,Estado){
    $.ajax({
        url: "cambiarEstadoUsuario",
        type: "POST",
        data: "usuario="+Usuario+"&estado="+Estado,
        success: function(data) {                
            if(Estado==1){
                $("#estado1").html("");
                $("#estado1").html(data);
                $("#modal-activar").modal('hide');
                $("#modal-desactivar").modal('show');
            }else{
                $("#estado2").html("");
                $("#estado2").html(data);
                $("#modal-desactivar").modal('hide');
                $("#modal-activar").modal('show');
            }                
        }
    });
}

//Estado GrupoUsuario
function cambiarEstadoGrupoUsuario(GrupoU,Estado){
    $.ajax({
        url: "cambiarEstadoGrupoUsuario",
        type: "POST",
        data: "GrupoU="+GrupoU+"&estado="+Estado,
        success: function(data) {                
            if(Estado==1){
                $("#estadoGrupoU1").html("");
                $("#estadoGrupoU1").html(data);
                $("#modal-activar-grupoU").modal('hide');
                $("#modal-desactivar-grupoU").modal('show');
            }else{
                $("#estadoGrupoU2").html("");
                $("#estadoGrupoU2").html(data);
                $("#modal-desactivar-grupoU").modal('hide');
                $("#modal-activar-grupoU").modal('show');
            }                
        }
    });
}

//Estado Cadena
function cambiarEstadoCadena(Cadena,Estado){
    $.ajax({
        url: "cambiarEstadoCadena",
        type: "POST",
        data: "cadena="+Cadena+"&estado="+Estado,
        success: function(data) {                
            if(Estado==1){
                $("#estadoCadena1").html("");
                $("#estadoCadena1").html(data);
                $("#modal-activar-cadena").modal('hide');
                $("#modal-desactivar-cadena").modal('show');
            }else{
                $("#estadoCadena2").html("");
                $("#estadoCadena2").html(data);
                $("#modal-desactivar-activar").modal('hide');
                $("#modal-activar-cadena").modal('show');
            }                
        }
    });
}

//Estado Local
function cambiarEstadoLocal(Local,Estado){
    $.ajax({
        url: "cambiarEstadoLocal",
        type: "POST",
        data: "local="+Local+"&estado="+Estado,
        success: function(data) {                
            if(Estado==1){
                $("#estadoLocal1").html("");
                $("#estadoLocal1").html(data);
                $("#modal-activar-local").modal('hide');
                $("#modal-desactivar-local").modal('show');
            }else{
                $("#estadoLocal2").html("");
                $("#estadoLocal2").html(data);
                $("#modal-desactivar-local").modal('hide');
                $("#modal-activar-local").modal('show');
            }                
        }
    });
}

//Estado GrupoLocal
function cambiarEstadoGrupoLocal(GrupoL,Estado){
    $.ajax({
        url: "cambiarEstadoGrupoLocal",
        type: "POST",
        data: "GrupoL="+GrupoL+"&estado="+Estado,
        success: function(data) {                
            if(Estado==1){
                $("#estadoGrupoL1").html("");
                $("#estadoGrupoL1").html(data);
                $("#modal-activar-grupoL").modal('hide');
                $("#modal-desactivar-grupoL").modal('show');
            }else{
                $("#estadoGrupoL2").html("");
                $("#estadoGrupoL2").html(data);
                $("#modal-desactivar-grupoL").modal('hide');
                $("#modal-activar-grupoL").modal('show');
            }                
        }
    });
}

//Estado Feriado
function cambiarEstadoFeriado(Feriado,Estado){
    $.ajax({
        url: "cambiarEstadoFeriado",
        type: "POST",
        data: "Feriado="+Feriado+"&estado="+Estado,
        success: function(data) {                
            if(Estado==1){
                $("#estadoFeriado1").html("");
                $("#estadoFeriado1").html(data);
                $("#modal-activar-Feriado").modal('hide');
                $("#modal-desactivar-Feriado").modal('show');
            }else{
                $("#estadoFeriado2").html("");
                $("#estadoFeriado2").html(data);
                $("#modal-desactivar-activar").modal('hide');
                $("#modal-activar-Feriado").modal('show');
            }                
        }
    });
}

//Editar Grupo Usuario
function EditarGrupoUsuario(NombreGrupo,Opcion){
    $.ajax({
        url: "editarGrupoU",
        type: "POST",
        data: "NombreGrupo="+NombreGrupo+"&Opcion="+Opcion,
        success: function(data) {                
            $("#editarGrupoU").html("");
            $("#editarGrupoU").html(data);
            $("#editGrupoU").modal('show');          
        }
    });
}

//Editar Cadena
function EditarCadena(Cadena){
    $.ajax({
        url: "editarCadena",
        type: "POST",
        data: "cadena="+Cadena,
        success: function(data) {                
            $("#editarCadena").html("");
            $("#editarCadena").html(data);
            $("#editCadena").modal('show');
        }
    });
}

//Editar Local
function EditarLocal(Local){
    $.ajax({
        url: "editarLocal",
        type: "POST",
        data: "local="+Local,
        success: function(data) {                
            $("#editarLocal").html("");
            $("#editarLocal").html(data);
            $("#editLocal").modal('show');          
        }
    });
}

//Editar GrupoLocales
function EditarGrupoLocales(NombreGrupo,Opcion){
    $.ajax({
        url: "editarGrupoL",
        type: "POST",
        data: "NombreGrupo="+NombreGrupo+"&Opcion="+Opcion,
        success: function(data) {                
            $("#editarGrupoL").html("");
            $("#editarGrupoL").html(data);
            $("#editGrupoL").modal('show');          
        }
    });
}

//Editar Feriado
function EditarFeriado(Feriado){
    $.ajax({
        url: "editarFeriado",
        type: "POST",
        data: "Feriado="+Feriado,
        success: function(data) {                
            $("#editarFeriado").html("");
            $("#editarFeriado").html(data);
            $("#editFeriado").modal('show');
        }
    });
}

//Mapa Local
function mapaLocal(Latitud,Longitud){      
    $.ajax({
            url: "mostrarMapaLocal",
            type: "POST",
            data: "latitud="+Latitud+"&longitud="+Longitud,
            success: function(data) {
              $("#modalmapa").html('');
              $("#modalmapa").html(data);
              $("#modalmapa").modal('show');       
            }
    });
}

//validar creacion usuario
function ValidarCreacionUsuario(){
    // Primer Validador
    $("#botonAgregar").attr("class","fa fa-spin fa-circle-o-notch");
    var vacios=0;
    if($("#txt_nombres").val()==''){  
        $("#txt_nombres").attr('class','form-control is-invalid');
        $("#val_nombres").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Nombre Vacio');
        vacios+=1;
    } else if ($("#txt_nombres").val().length>100){
        $("#txt_nombres").attr('class','form-control is-invalid');
        $("#val_nombres").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Nombre debe tener menos de 100 caracteres');
        vacios+=1;
    } else { 
        $("#txt_nombres").attr('class','form-control is-valid');
        $("#val_nombres").html('');
    }

    if($("#txt_appaterno").val()==''){  
        $("#txt_appaterno").attr('class','form-control is-invalid');
        $("#val_appaterno").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Apellido Paterno Vacio');
        vacios+=1;
    } else if ($("#txt_appaterno").val().length>100){
        $("#txt_appaterno").attr('class','form-control is-invalid');
        $("#val_appaterno").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Apellido Paterno debe tener menos de 100 caracteres');
        vacios+=1;
    } else { 
        $("#txt_appaterno").attr('class','form-control is-valid');
        $("#val_appaterno").html('');
    }

    if ($("#txt_apmaterno").val().length>100){
        $("#txt_apmaterno").attr('class','form-control is-invalid');
        $("#val_apmaterno").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Apellido Materno debe tener menos de 100 caracteres');
        vacios+=1;
    } else { 
        $("#txt_apmaterno").attr('class','form-control is-valid');
        $("#val_apmaterno").html('');
    }

    if($("#txt_telefono").val()==''){  
        $("#txt_telefono").attr('class','form-control is-invalid');
        $("#val_telefono").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Télefono Vacio');
        vacios+=1;
    } else if ($("#txt_telefono").val().length!==9){
        $("#txt_telefono").attr('class','form-control is-invalid');
        $("#val_telefono").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Numero debe tener 9 dígitos');
        vacios+=1;
    } else if (!validarNumeros($("#txt_telefono").val())){
        $("#txt_telefono").attr('class','form-control is-invalid');
        $("#val_telefono").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Formato Incorrecto del Telefono');
        vacios+=1;
    } else { 
        $("#txt_telefono").attr('class','form-control is-valid');
        $("#val_telefono").html('');
    }

    if($("#txt_email").val()==''){  
        $("#txt_email").attr('class','form-control is-invalid');
        $("#val_email").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Email Vacio');
        vacios+=1;
    } else if ($("#txt_email").val().length>200){
        $("#txt_email").attr('class','form-control is-invalid');
        $("#val_email").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Email debe tener menos de 200 caracteres');
        vacios+=1;
    } else if (!validarEmail($("#txt_email").val())){
        $("#txt_email").attr('class','form-control is-invalid');
        $("#val_email").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Formato Incorrecto del correo');
        vacios+=1;
    } else { 
        $("#txt_email").attr('class','form-control is-valid');
        $("#val_email").html('');
    }

    if ($("#txt_direccion").val().length>200){
        $("#txt_direccion").attr('class','form-control is-invalid');
        $("#val_direccion").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; La dirección debe tener menos de 200 caracteres');
        vacios+=1;
    } else { 
        $("#txt_direccion").attr('class','form-control is-valid');
        $("#val_direccion").html('');
    }

    if($("#lb_perfil").val()==''){  
        $("#lb_perfil").attr('class','form-control is-invalid');
        $("#val_perfil").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Perfil Vacio');
        vacios+=1;
    } else { 
        $("#lb_perfil").attr('class','form-control is-valid');
        $("#val_perfil").html('');
        if($("#txt_editar").val()=='0'){
            if($("#lb_perfil").val()==3){
                if($("#txt_rut").val()==''){  
                    $("#txt_rut").attr('class','form-control is-invalid');
                    $("#val_rut").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Rut Vacio');
                    vacios+=1;
                } else if ($("#txt_rut").val().length>12){
                    $("#txt_rut").attr('class','form-control is-invalid');
                    $("#val_rut").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Rut debe tener menos de 12 caracteres');
                    vacios+=1;
                } else { 
                    $("#txt_rut").attr('class','form-control is-valid');
                    $("#val_rut").html('');
                }
            }
        }
    }

    if($("#txt_usuario").val()==''){  
        $("#txt_usuario").attr('class','form-control is-invalid');
        $("#val_usuario").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Usuario Vacio');
        vacios+=1;
    } else if ($("#txt_usuario").val().length>100){
        $("#txt_usuario").attr('class','form-control is-invalid');
        $("#val_usuario").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Usuario debe tener menos de 100 caracteres');
        vacios+=1;
    } else { 
        $("#txt_usuario").attr('class','form-control is-valid');
        $("#val_usuario").html('');
    }

    if($("#txt_clave").val()==''){  
        $("#txt_clave").attr('class','form-control is-invalid');
        $("#val_clave").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Clave Vacio');
        vacios+=1;
    } else if ($("#txt_clave").val().length>150){
        $("#txt_clave").attr('class','form-control is-invalid');
        $("#val_clave").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; La Clave debe tener menos de 150 caracteres');
        vacios+=1;
    } else { 
        $("#txt_clave").attr('class','form-control is-valid');
        $("#val_clave").html('');
    }

    //Segundo Validador e Insertar
    if(vacios==0){
        $.ajax({
            url: "validarCreacionUsuario",
            method: "POST",
            data: $("#FormNuevoUsuario").serialize(), 
            success: function(data) {
                if(data.match("OP1")){
                    var resp = data.replace("OP1", "");
                    alertify.success("Se han ingresado "+resp+" registro");
                    setTimeout(function(){
                        window.location = "creacionUsuario";
                    }, 1000); 
                }
                if(data.match("OP6")){
                    var resp = data.replace("OP6", "");
                    alertify.success("Se han Actualizado "+resp+" registro");
                    setTimeout(function(){
                        window.location = "listarModuloUsuario";
                    }, 1000); 
                }
                if(data.match("OP2")){
                    $("#txt_rut").attr('class','form-control is-invalid');
                    $("#val_rut").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El rut no es Valido');
                    alertify.error("No se Ingresaron los Datos");
                }else if(data.match("OP3")){
                    var respR = data.replace("OP3", "");
                    var respR2 = respR.replace("OP4", "");
                    $("#txt_rut").attr('class','form-control is-invalid');
                    $("#val_rut").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Usuario ya se encuentra Registrado en el Cliente '+respR2);
                    alertify.error("No se Ingresaron los Datos");
                }else{
                    $("#txt_rut").attr('class','form-control is-valid');
                    $("#val_rut").html('');
                }

                if(data.match("OP4")){
                    var resR = data.replace("OP3", "");
                    var resR2 = respR.replace("OP4", "");
                    $("#txt_usuario").attr('class','form-control is-invalid');
                    $("#val_usuario").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Usuario ya se encuentra Registrado en el Cliente '+resR2);
                    alertify.error("No se Ingresaron los Datos");
                }else{
                    $("#txt_usuario").attr('class','form-control is-valid');
                    $("#val_usuario").html('');
                }

                if(data.match("OP5")){
                    alertify.error("No se Ingresaron los Datos");
                }
            }
        });
         $("#botonAgregar").attr("class","mdi mdi-account-check");
         return false;
    }else{
        $("#botonAgregar").attr("class","mdi mdi-account-check");
        alertify.error("No se Ingresaron los Datos");
        return false;
    }   
}

//validar creacion grupo usuario
function ValidarCreacionGrupoUsuario(){    
    $("#botonAgregarGrupoU").attr("class","fa fa-spin fa-circle-o-notch");
    var vacios=0;
    if($("#txt_grupoUsuario").val()==''){  
        $("#txt_grupoUsuario").attr('class','form-control is-invalid');
        $("#val_grupoUsuario").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Nombre de Nombre Vacio');
        vacios+=1;
    } else if ($("#txt_grupoUsuario").val().length>100){
        $("#txt_grupoUsuario").attr('class','form-control is-invalid');
        $("#val_grupoUsuario").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Nombre debe tener menos de 100 caracteres');
        vacios+=1;
    } else { 
        $("#txt_grupoUsuario").attr('class','form-control is-valid');
        $("#val_grupoUsuario").html('');
    }

    //Segundo Validador e Insertar
    if(vacios==0){
         $.ajax({
            url: "ValidarCreacionGrupoUsuario",
            method: "POST",
            data: $("#FormNuevoGrupoU").serialize(), 
            success: function(data) {
                if(data.match("OP1")){
                    var resp = data.replace("OP1", "");
                    alertify.success("Se han ingresado "+resp+" registro");
                    setTimeout(function(){
                        window.location = "listarGrupoUsuarios";
                    }, 1000);
                }

                if(data.match("OP3")){
                    var resp = data.replace("OP3", "");
                    alertify.success("Se han Editado "+resp+" registro");
                    setTimeout(function(){
                        window.location = "listarGrupoUsuarios";
                    }, 1000);
                }

                if(data.match("OP4")){
                    var resp = data.replace("OP4", "");
                    alertify.success("Se han Ingresado "+resp+" usuarios al grupo");
                    setTimeout(function(){
                        window.location = "listarGrupoUsuarios";
                    }, 1000);
                }

                if(data.match("OP5")){
                    var resp = data.replace("OP5", "");
                    alertify.success("Usuarios Activos en el grupo: "+resp);
                    setTimeout(function(){
                        window.location = "listarGrupoUsuarios";
                    }, 1000);
                }

                if(data.match("OP2")){
                    alertify.error("No se Ingresaron los Datos");
                }
            }
        });
         $("#botonAgregarGrupoU").attr("class","fa fa-check-square-o");
         return false;
    }else{
        alertify.error("No se Ingresaron los Datos");
        $("#botonAgregarGrupoU").attr("class","fa fa-check-square-o");
        return false;
    }   
}


function ValidarCreacionCadena(){    
    $("#botonAgregarCadena").attr("class","fa fa-spin fa-circle-o-notch");
    var vacios=0;
    if($("#txt_cadena").val()==''){  
        $("#txt_cadena").attr('class','form-control is-invalid');
        $("#val_cadena").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Nombre de Cadena Vacio');
        vacios+=1;
    } else if ($("#txt_cadena").val().length>100){
        $("#txt_cadena").attr('class','form-control is-invalid');
        $("#val_cadena").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Nombre debe tener menos de 100 caracteres');
        vacios+=1;
    } else { 
        $("#txt_cadena").attr('class','form-control is-valid');
        $("#val_cadena").html('');
    }

    //Segundo Validador e Insertar
    if(vacios==0){
         $.ajax({
            url: "validarCreacionCadena",
            method: "POST",
            data: $("#FormNuevoCadena").serialize(), 
            success: function(data) {
                if(data.match("OP1")){
                    var resp = data.replace("OP1", "");
                    alertify.success("Se han ingresado "+resp+" registro");
                    setTimeout(function(){
                        window.location = "listarCadenas";
                    }, 1000);
                }

                if(data.match("OP3")){
                    var resp = data.replace("OP3", "");
                    alertify.success("Se han Editado "+resp+" registro");
                    setTimeout(function(){
                        window.location = "listarCadenas";
                    }, 1000);
                }

                if(data.match("OP5")){
                    $("#txt_cadena").attr('class','form-control is-invalid');
                    $("#val_cadena").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Nombre de la Cadena ya esta registrado en el sistema');
                    alertify.error("No se Ingresaron los Datos");
                }   

                if(data.match("OP2")){
                    alertify.error("No se Ingresaron los Datos");
                }
            }
        });
         $("#botonAgregarCadena").attr("class","fa fa-check-square-o");
         return false;
    }else{
        alertify.error("No se Ingresaron los Datos");
        $("#botonAgregarCadena").attr("class","fa fa-check-square-o");
        return false;
    }   
}

//validar creacion local
function ValidarCreacionLocal(){
    // Primer Validador    
    $("#botonLocal").attr("class","fa fa-spin fa-circle-o-notch");
    var vacios=0;
    if($("#txt_local").val()==''){  
        $("#txt_local").attr('class','form-control is-invalid');
        $("#val_local").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Nombre de Local Vacio');
        vacios+=1;
    } else if ($("#txt_local").val().length>100){
        $("#txt_local").attr('class','form-control is-invalid');
        $("#val_local").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Nombre debe tener menos de 100 caracteres');
        vacios+=1;
    } else { 
        $("#txt_local").attr('class','form-control is-valid');
        $("#val_local").html('');
    }

    // if($("#txt_direccion").val()==''){  
    //     $("#txt_direccion").attr('class','form-control is-invalid');
    //     $("#val_direccion").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Dirección Vacio');
    //     vacios+=1;
    // } else if ($("#txt_direccion").val().length>250){
    //     $("#txt_direccion").attr('class','form-control is-invalid');
    //     $("#val_direccion").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; La Dirección debe tener menos de 250 caracteres');
    //     vacios+=1;
    // } else { 
    //     $("#txt_direccion").attr('class','form-control is-valid');
    //     $("#val_direccion").html('');
    // }

    if($("#lb_cadena").val()==''){  
        $("#lb_cadena").attr('class','form-control is-invalid');
        $("#val_eleCadena").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Cadena Vacio');
        vacios+=1;
    } else { 
        $("#lb_cadena").attr('class','form-control is-valid');
        $("#val_eleCadena").html('');
    }

    if($("#txt_latitud").val()==''){  
        $("#txt_latitud").attr('class','form-control is-invalid');
        $("#val_latitud").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Latitud Vacio');
        vacios+=1;
    } else if (!validarCoordenadas($("#txt_latitud").val())){
        $("#txt_latitud").attr('class','form-control is-invalid');
        $("#val_latitud").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Formato Incorrecto de la Latitud');
        vacios+=1;
    } else { 
        $("#txt_latitud").attr('class','form-control is-valid');
        $("#val_latitud").html('');
    }

    if($("#txt_longitud").val()==''){  
        $("#txt_longitud").attr('class','form-control is-invalid');
        $("#val_longitud").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Longitud Vacio');
        vacios+=1;
    } else if (!validarCoordenadas($("#txt_longitud").val())){
        $("#txt_longitud").attr('class','form-control is-invalid');
        $("#val_longitud").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Formato Incorrecto de la Longitud');
        vacios+=1;
    } else { 
        $("#txt_longitud").attr('class','form-control is-valid');
        $("#val_longitud").html('');
    }

    if($("#txt_rango").val()==''){  
        $("#txt_rango").attr('class','form-control is-invalid');
        $("#val_rango").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Rango Vacio');
        vacios+=1;
    } else if (!validarNumeros($("#txt_rango").val())){
        $("#txt_rango").attr('class','form-control is-invalid');
        $("#val_rango").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Formato Incorrecto del Rango');
        vacios+=1;
    } else { 
        $("#txt_rango").attr('class','form-control is-valid');
        $("#val_rango").html('');
    }

    //Segundo Validador e Insertar
    if(vacios==0){
         $.ajax({
            url: "validarCreacionLocal",
            method: "POST",
            data: $("#FormNuevoLocal").serialize(), 
            success: function(data) {
                if(data.match("OP1")){
                    var resp = data.replace("OP1", "");
                     alertify.success("Se han ingresado "+resp+" registro");
                     setTimeout(function(){
                        window.location = "creacionPuntosVentas";
                    }, 1000);
                }

                if(data.match("OP3")){
                    var resp = data.replace("OP3", "");
                     alertify.success("Se han Actualizado "+resp+" registro");
                     setTimeout(function(){
                        window.location = "listarLocales";
                    }, 1000);
                }

                if(data.match("OP2")){
                    alertify.error("No se Ingresaron los Datos");
                }

                if(data.match("OP5")){
                    $("#txt_local").attr('class','form-control is-invalid');
                    $("#val_local").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Nombre del Local ya esta registrado en el sistema');
                    alertify.error("No se Ingresaron los Datos");
                }
            }
        });
         $("#botonLocal").attr("class","fa fa-check-square-o");
         return false;
    }else{
        alertify.error("No se Ingresaron los Datos");
        $("#botonLocal").attr("class","fa fa-check-square-o");
        return false;
    }   
}

//validar creacion grupo locales
function ValidarCreacionGrupoLocal(){    
    $("#botonAgregarGrupoL").attr("class","fa fa-spin fa-circle-o-notch");
    var vacios=0;
    if($("#txt_grupoLocal").val()==''){  
        $("#txt_grupoLocal").attr('class','form-control is-invalid');
        $("#val_grupoLocal").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Nombre de Nombre Vacio');
        vacios+=1;
    } else if ($("#txt_grupoLocal").val().length>100){
        $("#txt_grupoLocal").attr('class','form-control is-invalid');
        $("#val_grupoLocal").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Nombre debe tener menos de 100 caracteres');
        vacios+=1;
    } else { 
        $("#txt_grupoLocal").attr('class','form-control is-valid');
        $("#val_grupoLocal").html('');
    }

    //Segundo Validador e Insertar
    if(vacios==0){
         $.ajax({
            url: "ValidarCreacionGrupoLocal",
            method: "POST",
            data: $("#FormNuevoGrupoL").serialize(), 
            success: function(data) {
                if(data.match("OP1")){
                    var resp = data.replace("OP1", "");
                    alertify.success("Se han ingresado "+resp+" registro");
                    setTimeout(function(){
                        window.location = "listarGrupoLocales";
                    }, 1000);
                }

                if(data.match("OP3")){
                    var resp = data.replace("OP3", "");
                    alertify.success("Se han Editado "+resp+" registro");
                    setTimeout(function(){
                        window.location = "listarGrupoLocales";
                    }, 1000);
                }

                if(data.match("OP4")){
                    var resp = data.replace("OP4", "");
                    alertify.success("Se han Ingresado "+resp+" locales al grupo");
                    setTimeout(function(){
                        window.location = "listarGrupoLocales";
                    }, 1000);
                }

                if(data.match("OP5")){
                    var resp = data.replace("OP5", "");
                    alertify.success("Locales Activos en el grupo: "+resp);
                    setTimeout(function(){
                        window.location = "listarGrupoLocales";
                    }, 1000);
                }

                if(data.match("OP2")){
                    alertify.error("No se Ingresaron los Datos");
                }
            }
        });
         $("#botonAgregarGrupoL").attr("class","fa fa-check-square-o");
         return false;
    }else{
        alertify.error("No se Ingresaron los Datos");
        $("#botonAgregarGrupoL").attr("class","fa fa-check-square-o");
        return false;
    }   
}

//validar creacion Feriados
function ValidarCreacionFeriado(){    
    $("#botonAgregarFeriado").attr("class","fa fa-spin fa-circle-o-notch");
    var vacios=0;
    if($("#txt_Nombre").val()==''){  
        $("#txt_Nombre").attr('class','form-control is-invalid');
        $("#val_Nombre").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Vacio');
        vacios+=1;
    } else { 
        $("#txt_Nombre").attr('class','form-control is-valid');
        $("#val_Nombre").html('');
    }

    if($("#txt_Fecha").val()==''){  
        $("#txt_Fecha").attr('class','form-control is-invalid');
        $("#val_Fecha").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Vacio');
        vacios+=1;
    } else {
        var fechaTermporal = $("#txt_Fecha").val();
        var fecha = fechaTermporal.split("-");
        var cont=0;
        for (var i = 0; i < fecha.length; i++) {
            if(isNaN(fecha[i])){
                cont+=1;
            }
        }
        if(cont>0){
            $("#txt_Fecha").attr('class','form-control is-invalid');
            $("#val_Fecha").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Formato Incorrecto');
            vacios+=1;
        }else{
            $("#txt_Fecha").attr('class','form-control is-valid');
            $("#val_Fecha").html('');
        }
    }

    //Segundo Validador e Insertar
    if(vacios==0){
         $.ajax({
            url: "validarCreacionFeriado",
            method: "POST",
            data: $("#FormNuevoFeriado").serialize(), 
            success: function(data) {
                if(data.match("OP1")){
                    var resp = data.replace("OP1", "");
                    alertify.success("Se han ingresado "+resp+" registro");
                    setTimeout(function(){
                        window.location = "adminFeriados";
                    }, 1000);
                }

                if(data.match("OP3")){
                    var resp = data.replace("OP3", "");
                    alertify.success("Se han Editado "+resp+" registro");
                    setTimeout(function(){
                        window.location = "adminFeriados";
                    }, 1000);
                }

                if(data.match("OP2")){
                    alertify.error("No se Ingresaron los Datos");
                }
            }
        });
         $("#botonAgregarFeriado").attr("class","fa fa-check-square-o");
         return false;
    }else{
        alertify.error("No se Ingresaron los Datos");
        $("#botonAgregarFeriado").attr("class","fa fa-check-square-o");
        return false;
    }   
}

//   //validar creacion libro Asistencia
// function ValidarLibroAsistencia(){    
//     $("#listAsistencia").attr("class","fa fa-spin fa-circle-o-notch");
//     var vacios=0;
//     if($("#txt_libro").val()==''){  
//         $("#txt_libro").attr('class','form-control is-invalid');
//         $("#val_libro").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ingresar Fechas');
//         vacios+=1;
//     } else {         
//         $("#txt_libro").attr('class','form-control is-valid');
//         $("#val_libro").html('');
//     }

//     if($("#txt_rango").val()==''){  
//         $("#txt_rango").attr('class','form-control is-invalid');
//         $("#val_rango").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Escoger un Rango');
//         vacios+=1;
//     } else {         
//         $("#txt_rango").attr('class','form-control is-valid');
//         $("#val_rango").html('');
//     }

//     if(vacios>0){
//         $("#listAsistencia").attr("class","mdi mdi-file-excel");
//         return false;
//     }else{
//         $("#listAsistencia").attr("class","mdi mdi-file-excel");
//         return true;
//     }
// }

function formatoValIngreso(excelv){
      if($(excelv).val()!=''){
          var f=($(excelv).val().substring($(excelv).val().lastIndexOf("."))).toLowerCase();
          var validar=true;
          if(f==".xls" || f==".xlsx"){ validar=true;} else {validar=false;}
          if(validar==false){
              alertify.error("El Formato del archivo es invalido");
              document.getElementById("excelv").value="";
          }else if(validar==true){
            $("#ingresarExcelSpin").attr("class","fa fa-spin fa-circle-o-notch");
            var form = $(this);
            var file = document.getElementById("IngresarExcel").submit();
            // var ValidarExcel = file.files[0];
            // var promise = formatoVal();
            $.ajax({
                url:"Adm_ModuloUsuario/IngExcel",                     
                type : form.attr('method'),
                data : new FormData(form[0]), // <-- usamos `FormData`
                dataType : 'json',
                processData: false,  // <-- le indicamos a jQuery que no procese el `data`
                contentType: false,
                success:function(data){
                    alertify.error("El Formato del archivo es invalido");
                    console.log("success");
                    $("#ingresarExcelSpin").attr("class","");
                    $("#excelv").val('');
                    
                       
                    
                }
            });
          }
      }
  }

  function formatoValIngresoPDO(excelv){
    if($(excelv).val()!=''){
          var f=($(excelv).val().substring($(excelv).val().lastIndexOf("."))).toLowerCase();
          var validar=true;
          if(f==".xls" || f==".xlsx"){ validar=true;} else {validar=false;}
          if(validar==false){
              alertify.error("El Formato del archivo es invalido");
              document.getElementById("excelv").value="";
          }else if(validar==true){
            $("#ingresarExcelSpin").attr("class","fa fa-spin fa-circle-o-notch");
            var form = $(this);
            document.getElementById("IngresarExcel").submit();
          }
      }
  }

  function formatoValIngresoGrupo(excelvg){
    if($(excelvg).val()!=''){
          var f=($(excelvg).val().substring($(excelvg).val().lastIndexOf("."))).toLowerCase();
          var validar=true;
          if(f==".xls" || f==".xlsx"){ validar=true;} else {validar=false;}
          if(validar==false){
              alertify.error("El Formato del archivo es invalido");
              document.getElementById("excelvg").value="";
          }else if(validar==true){
            $("#ingresarExcelSping").attr("class","fa fa-spin fa-circle-o-notch");
            var form = $(this);
            var file = document.getElementById("IngresarExcelg").submit();
          }
      }
  }


 function formatoValIngresoLocales(excelvg){
        if($(excelvg).val()!=''){
              var f=($(excelvg).val().substring($(excelvg).val().lastIndexOf("."))).toLowerCase();
              var validar=true;
              if(f==".xls" || f==".xlsx"){ validar=true;} else {validar=false;}
              if(validar==false){
                  alertify.error("El Formato del archivo es invalido");
                  document.getElementById("excelvg").value="";
              }else if(validar==true){
                $("#ingresarExcelSping").attr("class","fa fa-spin fa-circle-o-notch");
                var form = $(this);
                var file = document.getElementById("IngresarExcelg").submit();
            }
        }
    }


  function cargarmetas(){
    var allowedExtensions = /(.xls|.xlsx)$/i;
    if(document.getElementById("ex_metas").value!=""){
        if(allowedExtensions.exec(document.getElementById("ex_metas").value)){     
            $("#ingresarExcelSpin").attr("class","fa fa-spin fa-circle-o-notch");
            $("#div_metas").attr("class","card-header bg-info mb-3 text-white");            
            document.getElementById("formmetas").submit();
       //      var formData = new FormData(document.getElementById("formmetas"));
       //      $.ajax({
       //          url:$("#formmetas").attr('action'),
       //          type:$("#formmetas").attr('method'),
       //          dataType: "html",
       //          data: formData,
       //          cache: false,
       //          processData:false,
       //          contentType: false,
       //          success: function(data){
       //              if(data.match("OP61")){
       //              }else if(data.match("OP63")){
       //                  document.getElementById("ex_metas").value="";
       //                  alertify.error("La extensión del archivo cargado no es correcta. Por favor, intente nuevamente");
       //              }else if(data.match("OP66")){
       //              }else if(data.match("OP67")){
       //              }else if(data.match("OP68")){
       //              }else if(data.match("OP69")){
       //              }else{

       //              }
       //          }
       //      });
        } else {
            document.getElementById("ex_metas").value="";
            alertify.error("La extensión del archivo cargado no es correcta. Por favor, intente nuevamente");
        } 
    } else {
        document.getElementById("ex_metas").value="";
        alertify.error("El campo para cargar metas no puede quedar vacío");
    }

  }

   