<main class="main" style="height: 100%;">
        <!-- Breadcrumb -->
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
        <a href="<?php echo site_url(); ?>Adm_ModuloNotificaciones/crearNotificaciones">Crear Notificaciones</a>
        </li>
    </ol>
    <div class="container">
            <div class="animated fadeIn">
                 <h3>Creación de Notificaciones</h3>
                <small>Módulo de Administrador para crear Notificaciones</small>
                <br><br/>
                <div class="row">
                      <div class="col-sm-12">

                        <div class="card">
                            <div class="card-header text-theme">
                                <strong>Crear Notificación</strong>
                                
                            </div>
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <form id="FrmCreaNotificacion" method="POST" action="enviarMensaje">
                                            <input type="hidden" name="txtCreador" id="txtCreador" value="<?php echo $_SESSION["Cliente"];?>">
                                            <!-- <input type="hidden" name="txtHoraMin" id="txtHoraMin" value="<?php echo $hoy["minutes"];?>"> -->
                                            <div class="form-group">
                                                        <label for="company">Usuarios</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                                <select id="msltUser" class="form-control select2" data-plugin="select2" multiple  id="txt_asignacion[]" name="txt_asignacion[]">
                                                                <?php
                                                    foreach ($UsuariosMovil as $u) {
                                                        echo "<option value='".$u['ID_Usuario']."'>".$u['Nombres']."</option>";
                                                                }?>
                                                                </select>
                                                            </div>                                  
                                            </div>  
                                            <div id='errormsltUsuario' style='color: red; display: none;'  >
                                                   Debe seleccionar al menos un usuario...
                                                    </div>                                           
                                    </div>

                                    <div class="col-sm-3">

                                    </div>

                                    <div class="col-sm-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-danger" onclick="return validarUser();">
                                                Enviar Notificación<i class="mdi mdi-arrow-right-bold-circle-outline" id="icNot"></i></button>
                                            </div>                                           
                                    </div>                                 
                                        <div class="col-sm-12">
                                     <textarea id="textarea-msg" name="textarea-msg" rows="9" class="form-control" placeholder="Escriba el mensaje aquí..."></textarea>
                                        </div>                                   
                                </div>
                                </form>
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
    <script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>

	<script type="text/javascript">

        $('#msltUser').select2({});

    function validarUser(){
       var vacios=0;
        var valido=true;
            
        if($('#msltUser').val()==''){  
            $('#msltUser').attr('class', 'form-control is-invalid');
            $('#errormsltUsuario').show(); 
            alertify.error('Existen Campos Vacios');
                vacios+=1;
            } else { 
            $('#msltUser').attr('class', 'form-control is-valid');  
            $('#errormsltUsuario').hide();   
            $('#msltUser').hide();
            alertify.success('Mensaje enviado con éxito');  
            }
                                    
            if(vacios>0){ valido=false; }
                 return valido;
    }
    

  
        
        
    </script>
    <!-- end main -->