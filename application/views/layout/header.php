
<body class="app sidebar-fixed aside-menu-off-canvas aside-menu-hidden header-fixed  ">
    <header class="app-header navbar">
        <div class="hamburger hamburger--arrowalt-r navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto">
            <div class="hamburger-box">
                <div class="hamburger-inner"></div>
            </div>
        </div>
        <a class="navbar-brand" style="padding:0.6rem;" href="<?php echo base_url("menu");?>">
            <img alt="user" src="<?php echo  site_url(); ?>/PNG/logo-iaudisis.png">
        </a>

        <div class="hamburger hamburger--arrowalt-r navbar-toggler sidebar-toggler d-md-down-none mr-auto">
            <div class="hamburger-box">
                <div class="hamburger-inner"></div>
            </div>
        </div>
        <ul class="nav navbar-nav ">

            <?php 
                if($Perfil==1){ 
                    if(isset($Cliente)){
                        echo '<li class="nav-item dropdown">
                            <a class="nav-link " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-factory"></i><strong> '; echo $NombreCliente; echo'</strong>
                                
                            </a>
                            <div class="dropdown-menu dropdown-menu-right notification-list animated flipInY nicescroll-box">
                                <div class="dropdown-header">
                                    <strong>Cambiar Cliente</strong>
                                </div>
                                <div class="wrap" style="width: 200px; height: 500px; overflow-y: scroll;">';                            
                                    foreach ($Clientes as $c) {                           
                                        echo '<a href="'.site_url().'menu/elegirCliente?txcit='.base64_encode($c["ID_Cliente"]).'&txdnbt='.base64_encode($c["NombreBD"]).'&txnclt='.base64_encode($c["NombreCliente"]).'" class="dropdown-item">
                                            <div class="message-box">
                                                <div class="u-img">';                                                    
                                                    echo '<img alt="user" src="'.site_url();
                                                    if(isset($c['logo'])){
                                                            echo  $c['logo'];
                                                        }else{
                                                            echo 'archivos/foto_trabajador/default.png';
                                                        }
                                                    echo '">';
                                            
                                            echo'</div>
                                                <div class="u-text">
                                                    <div class="u-name">
                                                        <strong>
                                                        '.$c["NombreCliente"].'
                                                        <span class="badge badge-pill badge-theme pull-right">elegir</span> </strong>
                                                    </div>
                                                    <small>';
                                                    if($c["ID_Cliente"]==$Cliente){
                                                        echo 'Activo';        
                                                    }                                            
                                                    echo '</small>
                                                </div>
                                            </div>
                                        </a>';
                                    }
                                echo '</div>
                            </div>
                        </li>'; 
                    }
                }
            ?>            

           


            <li class="nav-item ">
                <!-- dropdown-menu -->
            </li>
            <!-- end navitem -->

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
                                <img src="https://via.placeholder.com/100x100" alt="user" />
                            </div>
                            <div class="u-text">
                                <h5><?php echo $Nombre;?></h5>
                                <p class="text-muted"> Cargo: <?php echo $Cargo;?> </p>
                                <a href="<?php echo base_url("login/inicio");?>" class="btn btn-round btn-theme btn-sm">Salir</a>
                            </div>
                        </div>
                        
                    </div>
                    <!-- end wrap -->
                </div>
                <!-- end dropdown-menu -->
            </li>
            <!-- end nav-item -->


        </ul>

       
    </header>
</body>
    <!-- end header -->
<style type="text/css">
    /*.header-fixed .app-header {
        z-index: 0 !important;

    }*/

    .app-footer {
         z-index: -1 !important;
    }

    .sidebar-fixed .sidebar {
         z-index:0 !important;
    }


</style>