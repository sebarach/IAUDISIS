<main class="main">
  <hr>
  <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
    <li class="breadcrumb-item active">
        <a href="<?php echo base_url("menu");?>">Menú</a>
    </li>
  </ol>
  <div class="container">
    <div class="animated fadeIn">
      <div class="row">
                        <div class="col-md-12">
                            <div class="card service-widget">
                                <div class="card-header text-theme">
                                    <div class="prefix header">
                                        <div class="float-left header-icon">
                                            <?php 
                                            echo'<div class="u-img">';                                                    
                                                    echo '<img alt="user" src="'.site_url();
                                                    if(isset($info['logo'])){
                                                            echo  $info['logo'];
                                                        }else{
                                                            echo 'archivos/foto_trabajador/default.png';
                                                        }
                                                    echo '">';
                                            
                                            echo'</div>';

                                             ?>
                                        </div>
                                        <div class="float-right">
                                            <div class="header-text  text-theme">
                                                <h4 class=" text-theme">Menú</h4>
                                                <h6 class=" text-theme"><small>Bienvenido a I-Audisis</small></h6>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end header -->
                                <div class="card-body">
                                    <div class="row">
                                      <a class="col-md-6 service-widget-items bg-theme text-center" href="<?php echo base_url("Adm_ModuloAsistencia/Asistencia ");?>" style="color: white;">                        
                                            <i class="mdi mdi-cellphone-iphone"></i>
                                            <div class="service-text">Asistencia</div>
                                        </a>
                                          <a class="col-md-6 service-widget-items bg-theme text-center" href="<?php echo base_url("App_ModuloTareas/elegirTareasAsignadas");?>" style="color: white;">
                                            <i class="mdi mdi-pencil-box-outline"></i>
                                            <div class="service-text">Tareas</div>
                                          </a>
                                    </div>
                                    <div class="row">
                                          <a class="col-md-6 service-widget-items bg-theme text-center" href="<?php echo base_url("App_ModuloMetas/metasUsuarioApp");?>" style="color: white;">
                                                <i class="mdi mdi-cash-usd"></i>
                                                <div class="service-text">Metas</div>
                                          </a>
                                          <a class="col-md-6 service-widget-items bg-theme text-center" href="<?php echo base_url("App_ModuloPerfilUsuario/verDocumentos");?>" style="color: white;">
                                            <i class="mdi mdi-book-multiple"></i>
                                            <div class="service-text">Biblioteca</div>
                                          </a>
                                          <?php if($TieneQuiebres=="1"){ ?>
                                             <a class="col-md-6 service-widget-items bg-theme text-center" href="<?php echo base_url("App_ModuloFunciones/QuiebresProductos");?>" style="color: white;">
                                              <i class="mdi mdi-poll-box"></i>
                                              <div class="service-text">Quiebres</div>
                                            </a>
                                          <?php }
                                          ?>
                                          <a class="col-md-6 service-widget-items bg-theme text-center" href="<?php echo base_url("App_ModuloPerfilUsuario/ModificarPerfil");?>" style="color: white;">
                                            <i class="mdi mdi-account"></i>
                                            <div class="service-text">Perfil</div>
                                           </a>                                      
                                          <!-- <a class="col-md-6 service-widget-items bg-theme text-center" href="<?php echo base_url("App_ModuloPerfilUsuario/Requerimiento");?>" style="color: white;">
                                            <i class="mdi mdi-timer-off"></i>
                                            <div class="service-text">Requerimiento Especial</div>
                                           </a> -->
                                        
                                    </div>
                                    
                                </div>

                            </div>
                            <!-- end card srvice-widget -->
                        </div>
                    </div>
    </div>
  </div>
</main>


<style type="text/css">
  .service-widget .service-widget-items i {
      font-size: 4rem !important;
  }

  .service-widget .service-widget-items .service-text {
    font-size: 2.2rem !important;
    margin-top: -20px;
}
</style>