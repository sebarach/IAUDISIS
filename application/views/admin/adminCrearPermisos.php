<main class="main">
        <!-- Breadcrumb -->
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
        <a href="<?php echo site_url(); ?>Adm_ModuloPermisos/creacionPermisos">Crear Permisos</a>
        </li>
    </ol>
    <div class="container">
            <div class="animated fadeIn">
                 <h3>Creación de Permisos</h3>
                <small>Módulo de Administrador para crear Permisos</small>
                <br><br/>
                <div class="row">
                      <div class="col-sm-12">

                        <div class="card">
                            <div class="card-header text-theme">
                                <strong>Crear Permiso</strong>
                                
                            </div>
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <form id="FrmCreaPermiso" method="POST" > 
                                        <div class="form-group">
                                            <label for="company">Nombre Permiso</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="mdi mdi-account-key"></i>
                                                </span>

                                                <input type="text" class="form-control" id="txtNombrePermiso" name="txtNombrePermiso" placeholder="Nombre del Permiso" >
                                                
                                            </div><br><div id="errorNombrePermiso" style="color: red; display: none;"  >
                                                        Debe escribir el Nombre del Permiso...
                                                    </div>
                                                    <div id="errorNombrePermisoML" style="color: red; display: none;"  >
                                                        El nombre del Permiso tiene un maximo de 150 caracteres
                                                    </div>

                                            
                                        </div>

                                        <div class="form-group">
                                            <label for="company">Seleccione Tipo de Permiso</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="mdi mdi-book-open"></i>
                                                </span>
                                                 <select id="sltTipoPermiso" name="sltTipoPermiso" class="form-control form-control-sm">
                                                 	<option value="">Seleccione</option>
                                                    <option value="Licencia Medica LM">Licencia Médica LM</option>
													<option value="No es Permiso">No es Permiso</option>
                                                    <option value="Permisos con goce de sueldo PCS">Permisos con goce de sueldo PCS </option>
                                                    <option value="Permisos sin goce de sueldo PSS">Permisos sin goce de sueldo PSS</option>
                                                </select>
                                                 <br>
                                            
                                            </div>
                                                <div id="errorsltTipo" style="color: red; display: none;"  >
                                                        Debe selecionar el Tipo de permiso...
                                                </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="company">Seleccione Remuneración</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-dollar"></i>
                                                </span>
                                                 <select id="sltRemuneracion" name="sltRemuneracion" class="form-control form-control-sm">
                                                 	<option value="">Seleccione</option>
                                                    <option value="1">Remunerado</option>
													<option value="0">No Remunerado</option>
                                                </select>
                                                 <br>
                                            
                                            </div>
                                            <div id="errorsltRem" style="color: red; display: none;"  >
                                                       Debe selecionar si es un permiso remunerado...
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="company">Código Permiso</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="mdi mdi-barcode"></i>
                                                </span>

                                                <input type="text" class="form-control" id="txtCodigoPermiso" name="txtCodigoPermiso" placeholder="Código del Permiso" >
                                                
                                            </div><br><div id="errorCodigoPermiso" style="color: red; display: none;"  >
                                                        Debe escribir el Código del Permiso...
                                                    </div>
                                                    <div id="errorCodigoPermisoML" style="color: red; display: none;"  >
                                                        El Código del Permiso tiene un máximo de 150 caracteres
                                                    </div>

                                            
                                        </div>

                                        <div class="form-group form-actions">
                                            <button type="button" class="btn btn-sm btn-danger" onclick="return validarCrearPermiso();" ><i id="idCreaPermiso" class=""></i>Crear Permiso</button>
                                        </div>

                                        
                                        </form>
                                    </div>
                                     
                                    

                                </div>

                            </div>
                            </div>
                                        
                            </div>
                           
                        </div><!-- end fin-fluid -->
                    
                    </div>
                </div>
           
        <!-- end container-fluid -->

    </main>


    <script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>


	<script type="text/javascript">

		function validarCrearPermiso(){
    if(validarIngresarPermiso()==false){
        alertify.error("Existen Campos Vacios");
        return false;
    }else{
        if(validarlargoCaracterPermiso()==false){
        alertify.error("Maximo de caracteres Exedido ");
        return false;
        }else{
            $("#idCreaPermiso").attr("class","fa fa-spin fa-circle-o-notch");
            $.ajax({                        
               type: "POST",                 
               url:"http://checkroom.cl/audisis/Adm_ModuloPermisos/CrearPermiso",                     
               data: $("#FrmCreaPermiso").serialize(), 
               success: function(data)             
               {            
                 if (data==1) {
                 $("#idCreaPermiso").attr("class","");
                 alertify.error("El Permiso ya existe");
                 $("#txtNombrePermiso").attr('class', 'form-control is-invalid');
                 $('#errorNombrePermisoML').show(); 

                 }else if(data==0){
                    $("#idCreaPermiso").attr("class","");
                 alertify.success("Permiso Ingresado");
                 $("#sltRemuneracion").val('');
                 $("#sltTipoPermiso").val('');
                 $("#txtNombrePermiso").val('');
                 setTimeout(function(){window.location.reload();}, 1000);
                 }
                }         
            });
            }
        }
    };

     function validarIngresarPermiso(){
    var vacios=0;
    var valido=true;
    if($("#sltRemuneracion").val()==''){  
        $("#sltRemuneracion").attr('class', 'form-control is-invalid');
        $('#errorsltRem').show(); 
        vacios+=1;
    } else { 
        $("#sltRemuneracion").attr('class', 'form-control is-valid');  
        $('#errorsltRem').hide(); 
    }

    if($("#txtNombrePermiso").val()==''){  
        $("#txtNombrePermiso").attr('class', 'form-control is-invalid');
        $('#errorNombrePermiso').show(); 
        vacios+=1;
    } else { 
        $("#txtNombrePermiso").attr('class', 'form-control is-valid');  
        $('#errorNombrePermiso').hide();
        $('#errorNombrePermisoML').hide();  
    }

    if($("#sltTipoPermiso").val()==''){  
        $("#sltTipoPermiso").attr('class', 'form-control is-invalid');
        $('#errorsltTipo').show(); 
        vacios+=1;
    } else { 
        $("#sltTipoPermiso").attr('class', 'form-control is-valid');  
        $('#errorsltTipo').hide();
        
    }

    if($("#txtCodigoPermiso").val()==''){  
        $("#txtCodigoPermiso").attr('class', 'form-control is-invalid');
        $('#errorCodigoPermiso').show(); 
        vacios+=1;
    } else { 
        $("#txtCodigoPermiso").attr('class', 'form-control is-valid');  
        $('#errorCodigoPermiso').hide();
        
    }
    
    if(vacios>0){ valido=false; }
    return valido;
    }

    function validarlargoCaracterPermiso(){
    var vacios=0;
    var valido=true;
    var NombrePermiso = $("#txtNombrePermiso").val();

    if(NombrePermiso.length>150){  
        $("#txtNombrePermiso").attr('class', 'form-control is-invalid');
        $('#errorNombrePermisoML').show(); 
        vacios+=1;
    } else { 
        $("#txtNombrePermiso").attr('class', 'form-control is-valid');  
        $('#errorNombrePermiso').hide();
        $('#errorNombrePermisoML').hide(); 
    }
    if(vacios>0){ valido=false; }
    return valido;
  }

        



    </script>
    <!-- end main -->