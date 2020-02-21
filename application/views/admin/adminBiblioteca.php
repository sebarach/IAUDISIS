
<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="<?php echo site_url(); ?>Adm_ModuloBiblioteca/adminDocumentos">Biblioteca</a>
        </li>
    </ol>



    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <form method="POST" action="asignarCarpetas">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                        <h4 class="text-theme">Asignar Carpetas a Usuarios</h4>
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-danger btn-sm" title="Asignar" id="botonAsignar" name="botonAsignar" onclick="return validarCampos();"><i class="mdi mdi-account-plus"></i>&nbsp;&nbsp;&nbsp;Asignar Carpetas</button>   
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="control-demo-1" class="col-sm-6">Carpetas <label style="color:red">* &nbsp;</label></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="mdi mdi-folder-multiple"></i></span>
                                            <select name="lb_carpeta_asignacion" id="lb_carpeta_asignacion" class="form-control form-control-sm">
                                                    <option value="0">Seleccione Carpeta</option>
                                                    <?php
                                                        foreach ($Carpetas as $c) {
                                                                echo "<option value='".$c['ID_Carpeta']."'>".$c['Nombre_Carpeta']."</option>";                                                           
                                                        }
                                                    ?>
                                                </select> 
                                        </div> 
                                        <div  id="val_nombre_carpeta_asignacion" style="color:red; display: none;">
                                            Debe elegir una carpeta...
                                        </div>    
                                    </div>
                                </div>

                                <div class="col-md-4" style="padding-top: 10px;">
                                    <div class="form-group">
                                        <label for="control-demo-1" class="col-sm-6">Usuarios </label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <select id="msltUser" class="form-control select2" data-plugin="select2" multiple  id="txt_asignacionUser[]" name="txt_asignacionUser[]">
                                                <?php
                                                    foreach ($UsuariosMovil as $u) {
                                                            echo "<option value='".$u['ID_Usuario']."'>".$u['Nombres']."</option>";                                                           
                                                    }
                                                ?>
                                            </select> 
                                        </div> 

                                        <div  id="val_msltUser" style="color:red; display: none;">
                                            Debe elegir un o unos usuarios...
                                        </div>  

                                    </div>
                                </div>

                                

                                <div class="col-md-4">
                                    <div class="form-group" >                                     
                                        <label for="control-demo-1">
                                            <div class="checkbox abc-checkbox-danger abc-checkbox">
                                                <input type="checkbox" id="cb-5">
                                                <label for="cb-5">Grupo Usuarios</label>
                                            </div> 
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <select id="msltUserGrupo" class="form-control select2" data-plugin="select2" multiple  id="txt_asignacionUserGrupo[]" name="txt_asignacionUserGrupo[]" disabled>
                                                <?php
                                                    foreach ($GrupoU as $g) {
                                                            echo "<option value='".$g['ID_GrupoUsuario']."'>".$g['NombreGrupoUsuario']."</option>";                                                           
                                                    }
                                                ?>
                                            </select> 
                                        </div> 

                                        <div  id="val_msltUserG" style="color:red; display: none;">
                                            Debe elegir un o unos grupos de usuarios...
                                        </div>   
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                 <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <form action="subirDocumento" class="form-horizontal" id="FormBiblioteca" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h4 class="text-theme">Biblioteca de Documentos</h4>
                                        <p>Se pueden subir documentos en distintos formatos.</p>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label for="control-demo-1" class="col-sm-6">Nombre Documento <label style="color:red">* &nbsp;</label></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-file-word-o"></i></span>
                                            <input type="text" id="txt_nombre_doc" name="txt_nombre_doc" class="form-control">
                                        </div>
                                        <div  id="val_nombre_doc" style="color:red; display: none;">
                                            Debe ingresar un nombre para el documento...
                                        </div>                                 
                                    </div>

                                    <div class="form-group">
                                        <label for="control-demo-1" class="col-sm-6">Descripción (Opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-navicon"></i></span>
                                            <input type="text" id="txt_desc_doc" name="txt_desc_doc" class="form-control">
                                        </div>                              
                                    </div>

                                <div class="row">
                                    <div class="form-group col-md-10">
                                        <label for="control-demo-1" class="col-sm-6">Carpeta <label style="color:red">* &nbsp;</label></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="mdi mdi-folder"></i></span>
                                                <select name="lb_carpeta" id="lb_carpeta" class="form-control form-control-sm">
                                                    <option value="0">Seleccione Carpeta</option>
                                                    <?php
                                                        foreach ($Carpetas as $c) {
                                                                echo "<option value='".$c['ID_Carpeta']."'>".$c['Nombre_Carpeta']."</option>";                                                           
                                                        }
                                                    ?>
                                                </select> 
                                            </div>  
                                    </div>

                                    <div class="form-group col-md-2" style="padding-top: 20px;">
                                        <button type="button" class="btn btn-danger btn-sm" title="Agregar" id="botonCarpeta"><i class="mdi mdi-folder-multiple"></i>&nbsp;&nbsp;&nbsp;Crear Carpeta</button> 
                                    </div>
                                </div>

                                    <div class="form-group" style="display: none;" id="div_carpeta">
                                        <label for="control-demo-1" class="col-sm-6">Nombre Carpeta <label style="color:red">* &nbsp;</label></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="mdi mdi-plus"></i></span>
                                            <input type="text" id="txt_nombre_carpeta" name="txt_nombre_carpeta" class="form-control">
                                        </div>
                                        <div  id="val_nombre_carpeta" style="color:red; display: none;">
                                            Debe ingresar un nombre para la carpeta...
                                        </div>                                 
                                    </div>


                                    <div class="form-group">
                                        <label for="control-demo-1" class="col-sm-6">Tipo de Documento <label style="color:red">* &nbsp;</label></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="mdi mdi-file-document"></i></span>
                                                <select name="lb_formato" id="lb_formato" class="form-control form-control-sm">
                                                    <option value="0">Seleccione Formato</option>
                                                    <option value="1">Subir Documento/Video</option>
                                                    <option value="2">Subir Enlace Externo</option>
                                                </select> 
                                            </div>  
                                    </div>

                                    <div class="form-group" style="display: none;" id="div_link">
                                        <label for="control-demo-1" class="col-sm-6">Enlace Externo</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="mdi mdi-link-variant"></i></span>
                                            <input type="txt_link" id="txt_desc" name="txt_link" class="form-control" placeholder="Ejemplo www.youtube.com">
                                        </div>  
                                        <button type="submit" class="btn btn-danger btn-sm" title="Agregar" onclick="return validarCrearBiblioteca();"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Agregar Enlace Externo</button>                            
                                    </div>

                                    <div class="form-group" style="display: none;" id="div_doc">
                                        <label for="control-demo-1" class="col-sm-6">Enlace Interno</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="mdi mdi-upload"></i></span>
                                            <input type="file" id="txt_doc" name="txt_doc" class="btn btn-danger btn-sm">
                                        </div>
                                        <button type="submit" class="btn btn-danger btn-sm" title="Agregar" onclick="return validarCrearBiblioteca();"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Subir Documento</button>                               
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card card-accent-theme">
                <div class="card-body">
                    <h4 class="text-theme">Carpetas de la Biblioteca</h4>
                    <div class="row">
                        <?php foreach ($Carpetas as $c) { ?>
                            <div class="col-md-3">
                                <div class="card card-accent-theme">
                                    <div class="card-body">
                                        <form method="POST" action="documentosCarpeta">
                                            <h5 class="text-theme"><?php echo $c["Nombre_Carpeta"] ?></h5>
                                            <input type="hidden" value="<?php echo $c["ID_Carpeta"]?>" name="txt_carpeta" id="txt_carpeta">
                                            <input type="hidden" value="<?php echo $c["Nombre_Carpeta"]?>" name="txt_carpeta_name" id="txt_carpeta_name">
                                            <hr>
                                            <button class="btn" style="background-color: white;"><i class="mdi mdi-folder-account" style="font-size:140px;color:#F03434;margin-left:20px;"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade bs-example-modal-Asignar" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="MAsignarCarpetas">
        <div class="modal-dialog ">
            <div class="modal-content" id="MAsignarCarpeta">
             
            </div>
        </div>
    </div>



</main>


<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
<script type="text/javascript">



        $('#lb_formato').on('change', function() {
      if(this.value == "1") {
        $('#div_link').hide();
        $('#div_doc').show();
      }
      if (this.value == "2") {
        $('#div_link').show();
        $('#div_doc').hide();
      }
      if (this.value == "0") {
        $('#div_doc').hide();
        $('#div_link').hide();
      }
    });

    function validarCampos(){
        if ($("#lb_carpeta_asignacion").val()==0) {
            $('#lb_carpeta_asignacion').attr('class', 'form-control is-invalid');
            $('#val_nombre_carpeta_asignacion').show();  
            alertify.error('Debe elegir una carpeta');
            return false
        }
        if ($('#msltUser').val()=='' && $('#msltUserGrupo').val()=='') {
            $('#val_msltUser').show();  
            $('#val_msltUserG').show(); 
            alertify.error('Debe elegir usuarios o grupos de usuarios');
            return false
        }   
    }

    function validarCrearBiblioteca(){
        if ($('#txt_nombre_doc').val()=='') {
            $('#txt_nombre_doc').attr('class', 'form-control is-invalid');
            $('#val_nombre_doc').show();  
            alertify.error('El nombre del Documento no puede quedar vacío');
            return false;        
        }
        if ($("#lb_carpeta").val()==0 && $("#txt_nombre_carpeta").val()=="") {
            $('#lb_carpeta').attr('class', 'form-control is-invalid');
            $('#val_nombre_carpeta').show();  
            alertify.error('El nombre de la carpeta no puede quedar vacío');
            return false
        }       
    }

    $(document).ready(
    function(){
        $("#botonCarpeta").click(function (e) {
            e.preventDefault();
            $('#lb_carpeta').prop('disabled', function(i, v) { return !v; });
            $("#div_carpeta").slideToggle("slow");
        });

    });

    $('#msltCarpeta').select2({});

    $('#msltUser').select2({});

    $('#msltUserGrupo').select2({});

    $('#cb-5').click( function(){
        if($(this).is(':checked')){
            $('#msltUserGrupo').removeAttr("disabled");
            $('#msltUser').attr("disabled", "disabled");
        }
        else {
            $('#msltUserGrupo').attr("disabled", "disabled");
            $('#msltUser').removeAttr("disabled");
        };
    });

    

</script>