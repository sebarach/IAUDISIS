<!DOCTYPE html>
<html lang="es">
</head>

<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Admin, Dashboard, Bootstrap" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>I-Audisis</title>

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo  site_url(); ?>/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo  site_url(); ?>/PNG/icono.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo  site_url(); ?>/PNG/icono.png">
    <link rel="manifest" href="<?php echo  site_url(); ?>/assets/img/favicon/manifest.json">
    <link rel="mask-icon" href="<?php echo  site_url(); ?>/assets/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

    <!-- fonts -->
    <link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/fonts/md-fonts/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/fonts/themify-icons/themify-icons.css">
    <!-- animate css -->
    <link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/libs/animate.css/animate.min.css">
    <!-- jquery-loading -->
    <link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/libs/jquery-loading/dist/jquery.loading.min.css">
    <!-- octadmin main style -->
    <link id="pageStyle" rel="stylesheet" href="<?php echo  site_url(); ?>/assets/css/style-red.css">
        <!-- Alertify -->

    <!-- Funciones Javascript -->
    
    <script src="<?php echo base_url("assets/js/jsFunciones.js"); ?>"></script>
    <script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>


    <!-- daatables! -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.dataTables.min.css">
     <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
</head>
<body class="app sidebar-fixed aside-menu-off-canvas aside-menu-hidden header-fixed pace-done sidebar-hidden">
    <header class="app-header navbar">
        <div class="hamburger hamburger--arrowalt-r navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto">
            <div class="hamburger-box">
                <div class="hamburger-inner"></div>
            </div>
        </div>
        <a class="navbar-brand" href="http://checkroom.cl/audisis/menu">
            <strong>I-Audisis</strong>
        </a>
         <a class="navbar-brand" style="margin-right: 150px !important;"></a>

        <ul class="nav navbar-nav ">
            <li class="nav-item dropdown">
                <a class="btn btn-round btn-theme btn-sm" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">

                    <span class=""><?php echo $Nombre;?>
                        <i class="fa fa-arrow-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right user-menu animated flipInY ">
                    <div class="wrap">
                        <div class="dw-user-box">
                            <div class="u-img">
                                <img src="http://via.placeholder.com/100x100" alt="user" />
                            </div>
                            <div class="u-text">
                                <h5><?php echo $Nombre;?></h5>
                                <p class="text-muted"> Cargo: <?php echo $Cargo;?> </p>
                                <a href="<?php echo base_url("login/inicio");?>" class="btn btn-round btn-theme btn-sm">Salir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

    </header>
<div class="app-body">
    <div class="sidebar" id="sidebar"></div>
        <main class="main">
            <br>
            <div class="container">
                <div class="animated fadeIn">
                <br><br>
                                    
                    <div class="container-fluid">
                        <div class="animated fadeIn">
                             <div class="row">               
                            <div class="col-md-12">
                                <div class="card card-accent-theme ">
                                    <div class="todo-widget">
                                        <h1>  Lista de Clientes </h1>
                                       <table class="table table-hover">
                                        <?php 
                                    foreach ($Clientes as $cl) {     
                                            echo'<tr>
                                            <form method="POST" action="menu/elegirCliente">
                                                <td class="doc-img ">
                                                <div class="dw-user-box"><div class="u-img">';
                                                     echo '<img class="u-img" src="'.site_url();
                                                    if(isset($cl['logo'])){
                                                            echo  $cl['logo'];
                                                        }else{
                                                            echo 'archivos/foto_trabajador/default.png';
                                                        }
                                                    echo '">';
                                               echo'</div></div> </td>
                                                <td class="document">
                                                    
                                                        <div class=" h4 heading">'.$cl['NombreCliente'].'</div>
                                                        <small>'.$cl['NombreEmpresa'].'</small>
                                                    
                                                </td>
                                                

                                                <td class="action">
                                                    <i class="mdi mdi-account-check" title="Cantidad Grupos Usuarios Activos"> '.$cl["CantidadUsuarioActivos"].'</i><br><br>
                                                    <i class="mdi mdi-account-remove" title="Cantidad Grupos Usuarios Activos"> '.$cl["CantidadUsuarioInactivos"].'</i>    
                                                </td>
                                                <td class="date"></td>
                                                <td class="user">

                                                    <div class="heading">Fecha de Registro</div>
                                                    <br/>
                                                    <small>'.$cl['fecha'].'</small>

                                                </td>

                                                <td class="action">
                                                    <button class="btn btn-theme "><i class="mdi mdi-check"></i> Elegir Cliente</button>
                                                </td>';
                                                 echo '<input type="hidden" name="txt_nombreBD" value="'; 
                                                    echo $cl["NombreBD"]; 
                                                    echo '">';
                                                    echo '<input type="hidden" name="txtidCliente" value="'; 
                                                    echo $cl["ID_Cliente"]; 
                                                    echo '">';
                                                    echo '<input type="hidden" name="txt_nombreCliente" value="'; 
                                                    echo $cl["NombreCliente"]; 
                                                    echo '">';
                                                
                                        echo '</form>

                                            </tr>';
                                        } ?>
                                        </table>
                                </div>
                                <div class="card-footer text-center "></div>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer class="app-footer">
        <a href="#" class="text-theme">I-Audisis</a> &copy; 2018 Progestion.
    </footer>


    <!-- Bootstrap and necessary plugins -->
    <script src="http://checkroom.cl/audisis//assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="http://checkroom.cl/audisis//assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="http://checkroom.cl/audisis//assets/libs/bootstrap/bootstrap.min.js"></script>
    <script src="http://checkroom.cl/audisis//assets/libs/PACE/pace.min.js"></script>
    <script src="http://checkroom.cl/audisis//assets/libs/chart.js/dist/Chart.min.js"></script>
    <script src="http://checkroom.cl/audisis//assets/libs/nicescroll/jquery.nicescroll.min.js"></script>



    <!--bootbox -->
    <script src="http://checkroom.cl/audisis//assets/libs/bootbox/bootbox.min.js"></script>
    <!--sweetalert -->
    <script src="http://checkroom.cl/audisis//assets/libs/sweetalert/sweetalert.js"></script>
    <!-- jquery-loading -->
    <script src="http://checkroom.cl/audisis//assets/libs/jquery-loading/dist/jquery.loading.min.js"></script>
    <!-- octadmin Main Script -->
    <script src="http://checkroom.cl/audisis/assets/libs/tables-datatables/dist/datatables.min.js"></script>
    <script src="http://checkroom.cl/audisis//assets/js/app.js"></script>
    
   



</body>

</html>