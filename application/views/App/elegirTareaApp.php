<main class="main">
  <hr>
  <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
      <li class='breadcrumb-item '>
        <a href="<?php echo base_url("menu");?>">Menú</a>
    </li>
      <li class="breadcrumb-item active">
          Tareas
      </li>
  </ol>
  <div class="input-group" >
    <form id="lol" name="lol" method="post" action="<?php echo site_url();?>App_ModuloTareas/elegirTareasAsignadas">
      <label for='company'>&nbsp;&nbsp;&nbsp;&nbsp;Buscar por Local</label>
       <div class='input-group'> &nbsp;&nbsp;&nbsp;&nbsp;
        <span class='input-group-addon'><i class='fa fa-user'></i></span>
        <select class='form-control select2' id='local' name='local' onchange="document.getElementById('lol').submit();" style="width: 350px;" data-plugin='select2' >
                <option value=''>Selecione un Local</option>
          <?php 
              if(isset($locales)){
                foreach ($locales as $l) { 
                  echo "  <option value='".$l['FK_ID_Local']."'>".$l['NombreLocal']."</option>";  
                }
              }else{
                echo "  <option value=''>Sin Locales Disponibles</option>";  
              }                
        echo"</select>"; ?>
      </div>
    </form>
  </div>
  <hr>
<?php foreach ($listaTareas as $lt) { ?>
  <div class="row">
    <div class="col-md-12">
      <form method="POST" action="verTareas">
        <div class="col-md-12">
          <div class="card card-accent-danger ecom-widget-sales">
              <div class="card-body">                  
                    <input type="hidden" name="txt_id_tarea" id="txt_id_tarea" value="<?php echo $lt["ID_Tarea"]?>">
                    <input type="hidden" name="txt_id_asignacion" id="txt_id_asignacion" value="<?php echo $lt["ID_Asignacion"]?>">
                    <input type="hidden" name="txt_local" id="txt_local" value="<?php echo $lt["FK_ID_Local"]?>">
                    <input type="hidden" name="txt_Nombre_tarea" id="txt_Nombre_tarea" value="<?php echo $lt["NombreTarea"]?>">
                    <h5><?php echo $lt["NombreTarea"];?></h5>
                    <ul> 
                      <li>LOCAL <span><?php echo $lt["NombreLocal"];?></span></li>
                      <li>DIRECCI&Oacute;N <span><?php echo $lt["Direccion"];?></span></li>
                      <li>FECHA INICIO <span><?php echo date("d-m-Y",strtotime($lt["Fecha_Inicio"]));?></span></li>
                      <li>FECHA FIN <span><?php 
                      if(is_null($lt["Fecha_Fin"])){
                        echo "SIN FECHA";
                      } else {
                        echo date("d-m-Y",strtotime($lt["Fecha_Fin"]));
                      }?></span></li>                       
                    </ul> 
                    <div class="text-center btn-tool-bar">
                      <?php 
                        if($lt["EstadoCompletado"]=='0'){
                          // echo '<button type="submit" class="card ecom-sales-icon text-center text-theme" ><i class="mdi mdi-cursor-pointer"></i></button>';
                          echo '<button type="submit" class="btn btn-theme"><i class="fa fa-hand-o-up"></i>ABRIR</button>';
                        }else{
                          // echo '<button type="button" class="card ecom-sales-icon text-center text-success" ><i class="mdi mdi-checkbox-marked-circle-outline"></i></button>';
                          echo '<button class="btn btn-success" type="button" ><i class="fa fa-check-circle-o" >COMPLETADO</i></button>';
                        }
                      ?>
                    </div>          
              </div>
          </div>
        </div>
      </form>
    </div>
  </div> 
  <?php } ?>  
  <?php foreach ($listaTareasHorario as $lt) { ?>
  <div class="row">
    <div class="col-md-12">
      <form method="POST" action="verTareas">
        <div class="col-md-12">
          <div class="card card-accent-danger ecom-widget-sales">
              <div class="card-body">                  
                    <input type="hidden" name="txt_id_tarea" id="txt_id_tarea" value="<?php echo $lt["ID_Tarea"]?>">
                    <input type="hidden" name="txt_id_asignacion" id="txt_id_asignacion" value="<?php echo $lt["ID_Asignacion"]?>">
                    <input type="hidden" name="txt_local" id="txt_local" value="<?php echo $lt["ID_Local"]?>">
                    <input type="hidden" name="txt_Nombre_tarea" id="txt_Nombre_tarea" value="<?php echo $lt["NombreTarea"]?>">
                    <h5><?php echo $lt["NombreTarea"];?></h5>
                    <ul> 
                      <li>LOCAL <span><?php echo $lt["NombreLocal"];?></span></li>
                      <li>DIRECCI&Oacute;N <span><?php echo $lt["Direccion"];?></span></li>
                    </ul> 
                    <div class="text-center btn-tool-bar">
                      <?php 
                        if($lt["EstadoCompletado"]=='0'){
                          // echo '<button type="submit" class="card ecom-sales-icon text-center text-theme" ><i class="mdi mdi-cursor-pointer"></i></button>';
                          echo '<button type="submit" class="btn btn-theme"><i class="fa fa-hand-o-up"></i>ABRIR</button>';
                        }else{
                          // echo '<button type="button" class="card ecom-sales-icon text-center text-success" ><i class="mdi mdi-checkbox-marked-circle-outline"></i></button>';
                          echo '<button class="btn btn-success" type="button" ><i class="fa fa-check-circle-o" >COMPLETADO</i></button>';
                        }
                      ?>
                    </div>          
              </div>
          </div>
        </div>
      </form>
    </div>
  </div> 
  <?php } ?> 
</main>

<script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript">
  $('.select2').select2({});
</script>
<style type="text/css">
  .ecom-widget-sales ul li span{
    color:#F03434 !important;
    display:block;
      width:60%;
      word-wrap:break-word;
  }

  @media (max-width: 576px) { .ecom-widget-sales ul li span{  width:100%; } }
</style>