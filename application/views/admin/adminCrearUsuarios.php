<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo site_url(); ?>Adm_ModuloUsuario/listarModuloUsuario">Administración de Usuarios</a>
        </li>
        <li class="breadcrumb-item active">Creación de Usuario</li>
    </ol>
    <div class="container-fluid">
        <h4 class="text-theme">Inserción Masiva de Usuarios</h4>
        <div class="row">
            <div class="col-md-6">
                    <div class="car">
                        <div class="card-header">
                            <i class="mdi mdi-arrow-right-drop-circle"></i> Paso 1 
                        </div>
                        <div class="card-body" style="height:300px;">
                            <h5 class="card-title">Plantilla de carga masiva de Usuarios</h5>
                            <p class="card-text">Para poder ingresar usuarios de manera masiva a través de un Excel. Paro ello debemos tener la plantilla con las columnas bien definidas para que la plataforma valide e ingrese sin problemas.</p>
                            <br>                    
                        <a href="<?php echo  site_url(); ?>doc/plantilla/PlantillaUsuariosEjemplo.xlsx" class="btn btn-theme" title='Descargar Plantilla'><i class="mdi mdi-file-excel"></i> Descargar Plantilla</a>
                    </div>
                    <div class="card-footer text-muted">
                       
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="car">
                        <div class="card-header">
                            <i class="mdi mdi-arrow-right-drop-circle"></i> Paso 2 
                        </div>
                        <div class="card-body" style="height:300px;">
                            <h5 class="card-title">Ingresar Excel</h5>
                            <p class="card-text">Antes de ingresar la plantilla con los usuarios, debemos saber cómo son las columnas y/o campos requeridos. Si usted no tiene conocimiento al respecto, descargue la plantilla. Si hay algún rut existente, los datos no se ingresaran.</p>             
                        <div class="btn btn-theme"><i class="mdi mdi-alarm-plus"></i> Seleccione Excel para Ingresar <i id="ingresarExcelSpin" class=""></i> <form action="IngExcel" method='POST' id="IngresarExcel" name="IngresarExcel" enctype="multipart/form-data" >                    
                                      <input type='file' class="btn btn-xs btn-dark" id="excelv" name="excelv" onchange="formatoValIngreso('#excelv');">
                                </form></div>
                    </div>
                    <div class="card-footer text-muted">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <?php 
                if(isset($datosUsuario["ID_Usuario"])){
                    echo '<h4 class="text-theme">Editar Usuario</h4>';
                }else{
                    echo '<h4 class="text-theme">Crear Usuario</h4>';
                }            
                if(isset($datosUsuario)){
                    if($datosUsuario['Perfil']==2){
                        $estilo="style='display:none;'";
                    }else{
                        $estilo="";
                    }
                }else{
                    $estilo="";
                }
            ?>
            <p>Ingresar un nuevo usuario al sistema, todos los campos con <code>*</code> son obligatorios.</p>
            <br>
            <form action="#" class="form-horizontal" id="FormNuevoUsuario">
                <div class="row">                
                    <div class="col-sm-6">
                        <div class="card">
                             <div class="card-header text-theme">
                                <strong>Información Personal</strong>                                            
                            </div>
                            <br>
                            <?php if($Perfil!=1){ ?>
                                <div class="form-group">
                                    <label for="control-demo-1" class="col-sm-6">Perfil</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                        <label>Usuario Movil</label>
                                    </div>  
                                    <input type="hidden" name="lb_perfil" id="lb_perfil" value="3">
                                </div>
                            <?php }else{ ?>
                                <div class="form-group">
                                    <label for="control-demo-1" class="col-sm-6">Perfil <label style="color:red">* &nbsp;</label></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                        <select name="lb_perfil" id="lb_perfil" class="form-control form-control-sm" onchange="cambiarPerfil();" required>
                                            <option value="">Elija un Perfil</option>
                                            <?php
                                                foreach ($Perfiles as $p) {
                                                    if(isset($datosUsuario['Perfil'])){
                                                        echo "<option value='".$p['ID_Perfil']."'";
                                                        if($datosUsuario['Perfil']==$p["ID_Perfil"]){ 
                                                            echo " selected ";
                                                        }
                                                        echo ">".$p['NombrePerfil']."</option>";
                                                    }else{
                                                        echo "<option value='".$p['ID_Perfil']."'>".$p['NombrePerfil']."</option>";
                                                    }                                                    
                                                }
                                            ?>
                                        </select> 
                                    </div>
                                    <div  id="val_perfil" style="color:red;"></div>    
                                </div>  
                            <?php }?>                          
                            <div class="form-group" id="div_rut" <?php echo $estilo; ?> >
                                <label for="control-demo-1" class="col-sm-6">Rut <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user-o"></i></span>
                                    <input type="text" id="txt_rut" name="txt_rut" class="form-control" value="<?php if(isset($datosUsuario['RUT'])){ echo $datosUsuario['RUT']; } ?>" placeholder='12.345.678-9' <?php if(isset($datosUsuario["ID_Usuario"])){echo "readonly";}?> onchange="colocarDatosUsuario();"required>
                                </div>
                                <div  id="val_rut" style="color:red;"></div>                                 
                            </div>  
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Nombres <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" id="txt_nombres" name="txt_nombres" class="form-control" value="<?php if(isset($datosUsuario['Nombres'])){ echo $datosUsuario['Nombres']; } ?>" placeholder='Nombres del Usuario' required>
                                </div>
                                <div  id="val_nombres" style="color:red;"></div>                                 
                            </div>                            
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Apellido Paterno <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user-circle"></i></span>
                                    <input type="text" id="txt_appaterno" name="txt_appaterno" class="form-control" value="<?php if(isset($datosUsuario['ApellidoP'])){ echo $datosUsuario['ApellidoP']; } ?>" placeholder='Apellido Paterno del Usuario' required>
                                </div>                                                                        
                                <div  id="val_appaterno" style="color:red;"></div>                              
                            </div>                            
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Apellido Materno</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user-circle-o"></i></span>
                                    <input type="text" id="txt_apmaterno" name="txt_apmaterno" value="<?php if(isset($datosUsuario['ApellidoM'])){ echo $datosUsuario['ApellidoM']; } ?>" class="form-control" placeholder='Apellido Materno del Usuario'>
                                </div>     
                                <div  id="val_apmaterno" style="color:red;"></div>                                  
                            </div>
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Género <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">
                                    &nbsp;&nbsp;&nbsp;<label class="custom-control custom-radio">
                                        <input id="rb_masculino" name="rb_genero" type="radio" class="custom-control-input" value="1" <?php if(isset($datosUsuario['Genero'])){ if($datosUsuario['Genero']==1){ echo "checked";}}else{ echo "checked"; } ?> required>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Masculino</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="rb_femenino" name="rb_genero" type="radio" class="custom-control-input" value="2" <?php if(isset($datosUsuario['Genero'])){ if($datosUsuario['Genero']==2){ echo "checked";}} ?> required>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Femenino</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Numero Teléfono <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="mdi mdi-cellphone-iphone"></i></span>
                                    <input type="text" id="txt_telefono" name="txt_telefono" class="form-control" onkeypress="return SoloNumeros(event)" value="<?php if(isset($datosUsuario['Telefono'])){ echo $datosUsuario['Telefono']; } ?>" placeholder='901020304' required>
                                </div>  
                                <div  id="val_telefono" style="color:red;"></div>          
                            </div>
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Email <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="mdi mdi-email-outline"></i></span>
                                    <input type="email" id="txt_email" name="txt_email" class="form-control" value="<?php if(isset($datosUsuario['Email'])){ echo $datosUsuario['Email']; } ?>" placeholder='correo@dominio.com' required>
                                </div>  
                                <div  id="val_email" style="color:red;"></div>   
                            </div>
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Dirección</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="mdi mdi-home"></i></span>
                                    <input type="text" id="txt_direccion" name="txt_direccion" class="form-control" value="<?php if(isset($datosUsuario['Direccion'])){ echo $datosUsuario['Direccion']; } ?>" placeholder='Dirección del Usuario'>
                                </div>  
                                <div  id="val_direccion" style="color:red;"></div>  
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                             <div class="card-header text-theme">
                                <strong>Información Empresa</strong>                                            
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Cargo</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-vcard-o"></i></span>
                                    <input type="text" id="txt_cargo" name="txt_cargo" class="form-control"  value="<?php if(isset($datosUsuario['Cargo'])){ echo $datosUsuario['Cargo']; } ?>" placeholder='Nombres del Cargo del Usuario' required>
                                </div>       
                                <div  id="val_cargo" style="color:red;"></div>                               
                            </div>
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Grupos</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <select id="select1" class="form-control select2" data-plugin="select2" multiple  id='txt_grupos[]' name='txt_grupos[]' style="width: 100%;">
                                        <?php 
                                            foreach ($Grupos as $G) {
                                                if(isset($GruposActivos)){
                                                    echo "<option value='".$G["ID_GrupoUsuario"]."' ";
                                                    foreach ($GruposActivos as $g) {
                                                        if($g["ID_Grupo"]==$G["ID_GrupoUsuario"]){
                                                            echo " selected ";
                                                        }
                                                    }
                                                    echo ">".$G["NombreGrupoUsuario"]."</option>";    
                                                }else{                                                    
                                                    echo "<option value='".$G["ID_GrupoUsuario"]."''>".$G["NombreGrupoUsuario"]."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>                            
                            </div>    
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Usuario <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-badge"></i></span>
                                    <input type="text" id="txt_usuario" name="txt_usuario" class="form-control"  value="<?php if(isset($datosUsuario['Usuario'])){ echo $datosUsuario['Usuario']; } ?>" placeholder='Usuario del Usuario' readonly required>
                                </div>    
                                <div  id="val_usuario" style="color:red;"></div>                                    
                            </div>
                            <div class="form-group">
                                <label for="control-demo-1" class="col-sm-6">Clave <label style="color:red">* &nbsp;</label></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="text" id="txt_clave" name="txt_clave" class="form-control"  value="<?php if(isset($datosUsuario['Clave'])){ echo $datosUsuario['Clave']; } ?>" placeholder='Clave del Usuario' readonly required>
                                </div> 
                                <div  id="val_clave" style="color:red;"></div>                                          
                            </div>
                            <div class="form-group">
                            </div>
                            <div class="form-group">
                                <?php 
                                    if(isset($datosUsuario["ID_Usuario"])){
                                        echo '<button type="submit" class="btn btn-theme btn-sm" onclick="return ValidarCreacionUsuario();"><i class="mdi mdi-account-check"  id="botonAgregar"></i> Editar Usuario</button>';
                                    }else{
                                        echo '<button type="submit" class="btn btn-theme btn-sm" onclick="return ValidarCreacionUsuario();"><i class="mdi mdi-account-check"  id="botonAgregar"></i> Agregar Usuario</button>';
                                    }            
                                ?>                                    
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="txt_editar" id="txt_editar" value="<?php if(isset($datosUsuario['ID_Usuario'])){ echo $datosUsuario['ID_Usuario']; }else{ echo 0;} ?>">
                <input type="hidden" name="txt_nombreCli" id="txt_nombreCli" value="<?php echo $NombreCliente; ?>">
            </form>            
        </div>
    </div>
</main>

<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript">
    //select multiple 1
    $('#select1').select2({});
    //formato al rut
    $('#txt_rut').keyup(function(event){
        $(this).val(function(index, value) {
            return value
                .replace(/\-/g, "")
                .replace(/([0-9])([a-zA-Z0-9]{1})$/, '$1-$2')  
            });
        });

    




</script>