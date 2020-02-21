<main class='main'>
  <hr>
  <ol class='breadcrumb bc-colored bg-theme' id='breadcrumb'>
    <li class='breadcrumb-item '>
        <a href="<?php echo base_url("menu");?>">Menú</a>
    </li>
    <li class="breadcrumb-item active"> Formularios Asignados</li>
  </ol>
  <div class='container'>
    <div class='animated fadeIn'>
      <div class='row'>
        <div class='col-md-12'>
          <?php 
          if(isset($formularios)){   
          foreach ($formularios as $f) {
            echo " <a href='".site_url()."App_ModuloFormularios/Formulario?f=".base64_encode($f['ID_Formulario'])."'>
                <div class='card card-property-single'>
                    <div class='card-body'>
                      <div class='property-details'>
                        <div class='clearfix'>
                          <div class='card-body p-3 clearfix'>
                            <i class='mdi mdi-library-books bg-danger p-3 font-2xl mr-3 float-left text-white'></i>
                            <div class='h5 text-danger mb-0 mt-2'> ".$f['NombreFormulario']."</div>
                            <div class='text-muted text-uppercase font-weight-bold font-xs'>                              
                            </div>                         
                            <input type='hidden' name='tx_form' value='".$f['ID_Formulario']."'>                            
                          </div>     
                        </div>
                      </div>     
                    </div>                                                         
                  </div>
                  </a>
                  <br>";  
              }
            }else{
              echo "<div class='card card-property-single'>
                    <div class='card-body'>
                      <div class='property-details'>
                        <div class='clearfix'>
                          <div class='card-body p-3 clearfix'>
                            <i class='mdi mdi-alert-circle bg-danger p-3 font-2xl mr-3 float-left text-white'></i>
                            <div class='h5 text-danger mb-0 mt-2'>No tiene Formularios Asignados el dia de hoy</div>
                            <div class='text-muted text-uppercase font-weight-bold font-xs'>
                            </div>
                          </div>     
                        </div>
                      </div>     
                    </div>                                                         
                  </div>";
            }
          ?>
        </div>             
      </div>
    </div>
  </div>
</main>