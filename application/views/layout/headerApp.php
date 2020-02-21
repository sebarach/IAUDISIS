<style type="text/css">
    
    .ajustar{
width: 250px;
float: left;
white-space: pre; /* CSS 2.0 */
white-space: pre-wrap; /* CSS 2.1 */
white-space: pre-line; /* CSS 3.0 */
white-space: -pre-wrap; /* Opera 4-6 */
white-space: -o-pre-wrap; /* Opera 7 */
white-space: -moz-pre-wrap; /* Mozilla */
white-space: -hp-pre-wrap; /* HP */
word-wrap: break-word; /* IE 5+ */
}

</style>
<body class="app sidebar-fixed sidebar-minimized aside-menu-off-canvas aside-menu-hidden header-fixed">
    <header class="app-header navbar">
        <a class="navbar-brand" href="<?php echo base_url("menu");?>">
            <strong>
                <img width="100%" src="<?php echo base_url("PNG/logo-iaudisis.png");?>">
            </strong>
        </a>
       
        <br><br><br><br>
        <ul class="nav navbar-nav " style="padding-top: 15px;">  

            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-pencil-box-outline"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right message-list animated flipInY nicescroll-box" style="width:100%;">
                    <div class="dropdown-header">
                        <strong>Tareas</strong>
                    </div>
                    <a class="dropdown-item" href="<?php echo base_url("App_ModuloTareas/elegirTareasAsignadas");?>">
                            <i class="mdi mdi-pencil-box-outline"></i> Ir A Tareas</a>
                    
                </div>
            </li> 

            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-folder-multiple"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right message-list animated flipInY nicescroll-box" style="width:100%;">
                    <div class="dropdown-header">
                        <strong>Ver Documentos</strong>
                    </div>
                    <a class="dropdown-item" href="<?php echo base_url("App_ModuloPerfilUsuario/verDocumentos");?>">
                            <i class="fa fa-book"></i> Biblioteca</a>
                    
                </div>
            </li>           

            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <?php 
                    if ($cantidadMsjNuevos==0) {
                    ?>
                        <i class="mdi mdi-forum"></i>
                    <?php
                    }else{
                    ?>
                    <i class="mdi mdi-forum"></i>
                    <span class="notification hertbit"></span>
                    <?php
                    }
                    ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right message-list animated flipInY nicescroll-box" style="width:100%">
                    <?php
                    if ($cantidadMsj==0 || $cantidadMsjNuevos==0) {
                    ?>
                        <div class="dropdown-header">
                        <strong>Notificaciones</strong>
                    </div>
                     <?php
                     }else{
                     ?>
                     <div class="dropdown-header">
                        <strong>Notificaciones</strong>
                        <span class="badge badge-pill badge-theme pull-right"> nuevos <?php echo $cantidadMsjNuevos ?></span>
                    </div>
                    <?php   
                     }
                     ?>

                    <?php 

                    if (empty($mensaje)) {
                        ?>
                        <div class="message-box">
                            <div class="u-text">
                                <div class="u-name">
                        <small>Usted no tiene nuevos mensajes nuevos</small>
                                </div>
                            </div>
                        </div>
                        <?php
                    }else{

                    foreach ($mensaje as $m) {
                            ?>
                    <div class="wrap">                        
                        <a href="#" class="dropdown-item">
                            <div class="message-box">
                                <?php
                                if ($m["Visto"]==1) {
                                ?>
                                    <i id="iCartaC" class="mdi mdi-email-outline"></i>
                                <?php
                                }else{
                                ?>
                                    <i id="iCartaCA" class="mdi mdi-email-open-outline"></i>
                                <?php
                                }
                                ?>    
                                <div class="u-text" onclick="MarcarLeido(<?php echo $m["ID_Mensaje"];?>);">
                                    <div class="u-name">
                                        <strong><?php echo $m["Cliente"]?></strong>
                                    </div>
                                    <?php 
                                    if ($m["Visto"]==1) {
                                    ?>   
                                    <strong id="msj" class="text-muted" style="width: 100;"><small class="ajustar"><?php echo $m["Mensaje"]?></small><br><i id="Imsj" class="mdi mdi-marker-check" style="padding-left: 8px;"> marcar como leído</i></strong>
                                    <?php
                                    }else{
                                    ?>
                                    <p class="text-muted ajustar"><?php echo $m["Mensaje"]?></p>
                                    <?php
                                    }
                                    ?>                                 
                                </div>
                            </div>
                        </a>
 
                    </div>
                <?php 
                    }
                }
                 ?>
                    <div class="dropdown-footer ">
                        <a href="">
                            <strong>Mensajes Totales (<?php echo $cantidadMsj ?>) </strong>
                        </a>
                    </div>
                </div>
            </li>          

            <li class="nav-item" style=" padding-left: 12px;">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-email"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right message-list animated flipInY nicescroll-box">

                    <div class="dropdown-header">
                        <strong>Contacto con Soporte</strong>
                    </div>

                    <div class="wrap">
                        <div class="message-box">
                            <div class="u-text">
                                <a href="#" class="dropdown-item" onclick="CorreoSoporte()" data-toggle="modal" data-target=".bs-example-modal-Correo-s">
                                <i class="mdi mdi-cube-send"></i>Enviar Correo a Soporte</a>
                            </div>
                        </div>
                    </div>
                    
                </div>

            </li>



            <li class="nav-item ">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-calendar-clock"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right task-list animated flipInY nicescroll-box">

                    <div class="dropdown-header">
                        <strong>Asistencia del Usuario </strong>
                    </div>
                    <div class="wrap">
                        <a class="dropdown-item" href="<?php echo base_url("App_ModuloPerfilUsuario/VerMarcacion");?>">
                            <i class="mdi mdi-calendar-multiple-check"></i> Ver Marcaciones 
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item ">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-account-card-details"></i>
                </a>
                         <div class="dropdown-menu dropdown-menu-right user-menu animated flipInY ">
                    <div class="wrap">
                        <div class="dw-user-box">
                            <div class="u-img">
                                <?php
                                    echo '<img alt="user" src="'.site_url();
                                    if(isset($info['FotoPerfil'])){
                                            echo  $info['FotoPerfil'];
                                        }else{
                                            echo 'archivos/foto_trabajador/default.png';
                                        }
                                    echo '">';
                                ?>
                            </div>
                            <div class="u-text">
                                <h5><?php echo $Nombre;?></h5> 
                                <p class="text-muted"> Cargo: <?php echo $Cargo;?> </p>
                                <a href="<?php echo base_url("login/inicio");?>" class="btn btn-round btn-theme btn-sm">Salir</a>
                            </div>
                        </div>

                        <a class="dropdown-item" href="<?php echo base_url("App_ModuloPerfilUsuario/ModificarPerfil");?>">
                            <i class="fa fa-wrench"></i> Perfil Usuario </a>

                        <div class="divider"></div>

                        
                    </div>
                </div>
            </li>
        </ul>

       
    </header>
    <br>

    <div class="modal fade bs-example-modal-Correo-s" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="CorreoSoportes">
        <div class="modal-dialog ">
            <div class="modal-content" id="CorreoSoporte">
             
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function CorreoSoporte(){
            $.ajax({
            url:"<?php echo base_url();?>Adm_ModuloAsistencia/CorreoSoporte",
            type: "POST",
            success: function(data) {
               $("#CorreoSoporte").html(data);
             }
        }); 
        }

        $('#msj').click( function(){
            $('#Imsj').remove();
            $(this).replaceWith( "<p class='text-muted'>" + $( this ).text() + "</p>" );
            $('#iCartaC').attr('class','mdi mdi-email-open-outline');
        });


        function MarcarLeido(idmsj){      
                $.ajax({
                url: "<?php echo base_url();?>Adm_ModuloNotificaciones/MarcarLeido",
                type: "POST",
                data: "idmsj="+idmsj,
                });
        }
    </script>
