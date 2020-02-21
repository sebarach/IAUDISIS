<main class="main">
  <hr>
  <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
    <li class='breadcrumb-item '>
        <a href="<?php echo base_url("menu");?>">Menú</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="">Asistencia</a>
    </li>
  </ol>
  <div class="container">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-property-single">
            <div class="card-body">
              <div class='property-details'>
                <div class='clearfix'>
                  <div class='card-body p-3 clearfix'>
                    <i class='mdi mdi-av-timer bg-danger p-3 font-2xl mr-3 float-left text-white'></i>
                    <div class='h5 text-danger mb-0 mt-2'>Tienes más de un local Asignado para el día de hoy</div>
                    <hr>
                    <div class='text-muted text-uppercase font-weight-bold font-xs'>
                      <small>Selecciona el local con la jornada abierta</small>
                    </div>
                    <form id="form1" name="form1" method="post" action="<?php echo  site_url();?>/Adm_ModuloAsistencia/AsistenciaPorIdJor">
                      <select class='form-control select2' id='Jornada' name='Jornada' data-plugin='select2' onchange="chanche();" >
                        <option value="">Seleccione local</option>
                        <?php
                          foreach ($ListarJornadas as $e) { 
                            echo "<option value='".$e['FK_Jornadas_ID_Jornada']."'>".$e['locales']."</option>";  
                          };
                        ?>
                      </select>
                    </form>
                  </div>     
                </div>
              </div>          
            </div>                                                         
          </div>
        </div> 
      </div>
    </div>
  </div>
</main>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script type="text/javascript">
  function chanche() {
    var i = $("#Jornada").val();
    if (i=='') {
      alertify.error('Seleccione su Local');
    }else{
      document.getElementById('form1').submit();
    }
  }

</script>