<body class="app sidebar-fixed aside-menu-off-canvas aside-menu-hidden header-fixed  ">
<div class="app-body">
        <div class="sidebar" id="sidebar">
            <nav class="sidebar-nav" id="sidebar-nav-scroller">
                <ul class="nav">
                    <?php if($Perfil==1){ ?>
                    <li class="nav-title">Menu Inicial</li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-account-card-details"></i> Usuarios
                        </a>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url();?>Adm_ModuloUsuario/creacionUsuario">Crear Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloUsuario/listarModuloUsuario">Administración Usuarios</a>
                            </li>
                            <li class="nav-item" >
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloUsuario/listarGrupoUsuarios">Grupo de Usuarios</a>
                            </li>
                            <li class="nav-item" >
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloUsuario/adminPermisos">Administración de Permisos</a>
                            </li>
                        </ul>

                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-factory"></i> Clientes</a>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url();?>Adm_ModuloCliente/Clientes"> Crear Cliente nuevo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url("Adm_ModuloCliente/AdministracionClientes");?>"> Administración Clientes</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-map-marker-multiple"></i> Puntos de Ventas</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloPuntosVentas/listarCadenas"> Adm Cadenas </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloPuntosVentas/creacionPuntosVentas"> Crear Locales </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloPuntosVentas/listarLocales"> Adm Locales </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloPuntosVentas/listarZona"> Adm de Zonas </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloPuntosVentas/listarGrupoLocales"> Grupo de Locales</a>
                            </li>       
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-file-chart"></i> Reportes</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloReportes/listarLibroAsistencia">Libro Asistencia </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-title">
                        Modulos
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-timetable"></i> Jornadas </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                            <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloJornadas/adminJornadas"> Crear Jornadas</a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloJornadas/adminHorario"> Administración Jornadas </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloJornadas/adminIncidencias"> Incidencias</a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloJornadas/adminFeriados"> Feriados</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>/Adm_ModuloPermisos/creacionPermisos"> Crear Permiso </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>/Adm_ModuloPermisos/AdministrarPermisos"> Permisos</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="<?php echo  site_url(); ?>/Adm_ModuloJornadas/adminHistoricoHorarios"> Historico Jornadas                                    
                                </a>
                            </li>
                            
                               
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-pencil-box-outline"></i> Formularios 
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloFormulario/crearFormulario"> Crear Formulario </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloFormulario/adminFormulario"> Administrar Fomularios</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloFormulario/adminFormularioEspeciales"> Administrar Fomularios Especiales</a>
                            </li>
                            <?php
                                if($Cliente==20){
                                    echo '<li class="nav-item">
                                        <a class="nav-link" href="'.site_url().'Adm_ModuloFormulario/galeriaform/'.str_replace('/','@@',openssl_encrypt($_SESSION["Cliente"],"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678")).'?view='.openssl_encrypt(2,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678").'">Galería Canal Mayorista
                                        </a>
                                    </li>';
                                    echo '<li class="nav-item">
                                        <a class="nav-link" href="'.site_url().'Adm_ModuloFormulario/galeriaform/'.str_replace('/','@@',openssl_encrypt($_SESSION["Cliente"],"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678")).'?view='.openssl_encrypt(1,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678").'" >Galería Canal Personas
                                        </a>
                                    </li>';
                                } else {
                                    echo '<li class="nav-item">
                                        <a class="nav-link" href="'.site_url().'Adm_ModuloFormulario/galeriaform/'.str_replace('/','@@',openssl_encrypt($_SESSION["Cliente"],"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678")).'">Galería Fotográfica
                                        </a>
                                    </li>';
                                }
                            ?>
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-comment-text-outline"></i> Encuestas 
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloTrivia/crearTriviaNormal"> Crear Encuesta</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloTrivia/adminTrivia"> Administración de Encuestas</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloTrivia/respEncuestas"> Respuestas de Encuestas</a>
                            </li> -->
                            <?php
                            if($Cliente==20){
                                echo '<li class="nav-item">
                                    <a class="nav-link" href="'.site_url().'Adm_ModuloTrivia/galeria/'.str_replace('/','@@',openssl_encrypt($_SESSION["Cliente"],"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678")).'?view='.openssl_encrypt(2,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678").'">Galería FE Mayorista</a>
                                    </li>';
                                echo '<li class="nav-item">
                                    <a class="nav-link" href="'.site_url().'Adm_ModuloTrivia/galeria/'.str_replace('/','@@',openssl_encrypt($_SESSION["Cliente"],"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678")).'?view='.openssl_encrypt(1,"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678").'" >Galería FE Personas</a>
                                    </li>';
                            } else {
                                echo '<li class="nav-item">
                                <a class="nav-link" href="'.site_url().'Adm_ModuloTrivia/galeria/'.str_replace('/','@@',openssl_encrypt($_SESSION["Cliente"],"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678")).'"> Galería Fotográfica</a>
                                </li>';
                            }
                            
                            ?>
                            <li class="nav-item nav-dropdown">
                                <a class="nav-link nav-dropdown-toggle" href="#"> Encuestas Aleatorias</a>
                                <ul class="nav-dropdown-items">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloTrivia/crearTrivia"> Crear Encuesta Aleatoria </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloTrivia/crearPregunta"> Crear Preguntas de Encuesta Aleatoria</a>
                                    </li>
                                </ul>
                            </li>   
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-briefcase"></i> Tareas 
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloTareas/crearTarea"> Crear Tarea </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloTareas/asignarTarea"> Asignar Tarea</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>/Adm_ModuloElementos/crearFamilia"> Asignación de Fomularios </a>
                            </li> -->
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-food-apple"></i> Clústeres                          
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloElementos/creacionElemento"> Crear Elementos </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloElementos/ListaElementos"> Lista de Elementos </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloElementos/administrarElementos"> Administrar Cluster Elementos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloElementos/administrarLocales"> Administrar Cluster Locales</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-cash-usd"></i> Metas y Ventas                          
                        </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloMetas/cargamasiva"> Carga Masiva Ventas y Metas </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Tabla Metas y Ventas </a>
                            </li>
                    <!--         <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloElementos/creacionElemento"> Histórico de Metas y Ventas </a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloMetas/reporteMetasVentas"> Reporte Metas y Ventas </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloElementos/administrarLocales"> Administrar Cluster Locales</a>
                            </li> -->
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-email"></i> Notificaciones</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloNotificaciones/crearNotificaciones">Crear Notificaciones</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa fa-book"></i> Biblioteca</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloBiblioteca/adminDocumentos">Administrar Documentos</a>
                            </li>
                        </ul>
                    </li>

                <?php } ?>


                <?php if($Perfil==4){ ?>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-food-apple"></i> Reportes </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloReportes/listarLibroAsistenciaFiscalizador"> Libro Asistencia </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?> 

                <?php if($Perfil==2){ ?>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-account-card-details"></i> Usuarios
                        </a>

                        <ul class="nav-dropdown-items">
                            <?php foreach ($Asignado as $a) { 
                                if($a["FK_ID_Modulo"]==3){ ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo  site_url();?>Adm_ModuloUsuario/creacionUsuario">Crear Usuarios</a>
                                        </li>
                                <?php  } 
                                if($a["FK_ID_Modulo"]==4){ ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloUsuario/listarModuloUsuario">Administración Usuarios</a>
                                        </li>
                                <?php  }
                                
                            } ?>
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-file-chart"></i> Reportes </a>
                        <ul class="nav-dropdown-items">
                            <?php foreach ($Asignado as $a) { 
                                if($a["FK_ID_Modulo"]==15){ ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloReportes/listarLibroAsistencia">Libro Asistencia </a>
                            </li>
                            <?php  } 

                            } ?>
                        </ul>
                    </li>

                    <li class="nav-title">
                        Administración de rutas
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-timetable"></i> Jornadas </a>
                        <ul class="nav-dropdown-items">
                            <?php foreach ($Asignado as $a) { 
                            if($a["FK_ID_Modulo"]==5){ ?>
                                <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloJornadas/adminJornadas"> Crear Jornadas</a>
                                </li>
                                <?php } 
                                if($a["FK_ID_Modulo"]==6){ ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloJornadas/adminHorario"> Administración Jornadas </a>
                                </li>
                                <?php } 
                                if($a["FK_ID_Modulo"]==7){ ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo  site_url(); ?>/Adm_ModuloPermisos/AdministrarPermisos"> Permisos </a>
                                </li>
                                <?php }
                                if($a["FK_ID_Modulo"]==8){ ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo  site_url(); ?>/Adm_ModuloJornadas/adminHistoricoHorarios"> Historico Jornadas                                    
                                </a>
                                </li> 
                                <?php } 
                                } 
                            ?>                          
                        </ul>
                    </li> 
                    <?php if($AsignadoNotificacion["Activo"]==1){ ?>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="mdi mdi-email"></i> Notificaciones</a>
                        <ul class="nav-dropdown-items">
                            <?php foreach ($Asignado as $a) { 
                            if($a["FK_ID_Modulo"]==9){ ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo  site_url(); ?>Adm_ModuloNotificaciones/crearNotificaciones">Crear Notificaciones</a>
                            </li>
                            <?php }
                        } 
                    }?>
                        </ul>
                    </li> 
                    <?php } ?>            
                </ul>
            </nav>

        </div>
    </div>
</body>
        <!-- end sidebar --> 