<main class="main">
  <hr>
  <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb"> 
    <li class="breadcrumb-item ">
      <a href="<?php echo base_url("menu/index");?>"><i class="mdi mdi-keyboard-backspace"></i></a>
    </li>     
    <li class="breadcrumb-item active">
      Metas y Ventas
    </li>
  </ol>  
<div class="row">
  <div class="col-md-12">
      <div class="card card-accent-theme">
          <div class="card-body">
          <h4 class="text-theme">Reporte Masiva Metas y Ventas</h4>     
        </div>
           <?php if(isset($Fechas) && !empty($Fechas)){ ?>
               <form action="ExportarLibroAsistenciaPorMes" method="POST" class="form-horizontal" id="libroMes" target="_blank" >
                  <div class="row">
                      &nbsp;&nbsp;&nbsp;
                      <div class='col-md-4' style="margin-top: 13px !important;">
                          <label for='company'>Escoger Fecha de Metas</label>
                          <div class='input-group'>
                              <span class='input-group-addon'>
                                  <i class='mdi mdi-timetable'></i>
                              </span>
                              <select class="form-control select2" id='txt_fechas' name='txt_fechas' style="width: 100%;" onchange="buscarLocalesMetasMovil();">
                                  <option value="">Elegir Fechas</option>
                                  <?php 
                                      foreach ($Fechas as $F) {
                                          echo "<option value='".$F["Mes"]."/".$F["Anio"]."'>".$F["Fecha"]."</option>";
                                      }
                                  ?>
                              </select>
                          </div>
                      </div>
                      <div class='col-md-1'>
                      </div>
                      <div class='col-md-4' style="margin-top: 13px !important;display: none;" id="div_local">
                          <label for='company'>Escoger Locales</label>
                          <div class='input-group'>
                              <span class='input-group-addon'>
                                  <i class='mdi mdi-timetable'></i>
                              </span>
                              <select class="form-control select2" id='txt_local' name='txt_local' style="width: 100%;" onchange="mostrarDashMetas();">
                                  <option value="">Sin Local</option>
                              </select>
                          </div>
                      </div>
                  </div>
                  <br>                  
                  <div id="metas" style="height: 225px;"></div>
              </form>
          <?php }else{ ?>
              <br><br>
              <div class="col-md-6">
                <div class="card stats-widget-2">
                  <div class="widget-body clearfix bg-danger">
                      <div class="widget-text pull-left ">                        
                          <h2 class="widget-title text-white">Sin metas registradas</h2>
                      </div>

                      <span class="pull-right big-icon watermark text-disabled">
                          <i class="mdi mdi-cash-usd"></i>
                      </span>
                  </div>
                </div>
              </div>
          <?php } ?>
      </div>
  </div>
</div>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/multiselect/js/jquery.multi-select.js"></script>

<script src="<?php echo base_url("assets/js/jsMetas.js"); ?>"></script>
<script type="text/javascript">
    $('#txt_local').select2({});
</script>