<style type="text/css">
    th { font-size: 12px; }
    td { font-size: 11px; }

    #loader {
  position: absolute;
  left: 50%;
  top: 72.5%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #f03434;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<main class="main">
  <hr>
  <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
      <li class="breadcrumb-item ">
          <a href="<?php echo base_url("menu/index");?>"><i class="mdi mdi-keyboard-backspace"></i></a>
      </li>
      <li class="breadcrumb-item">
          <a href="">Libro de Marcaciones</a>
      </li>
  </ol>
  <div class="container">
    <div class="animated fadeIn">
      <br>
     <div class="row">
        <div class="col-md-12">
          <div class="col-sm-12">
            <h7>Mostrar libro de Marcación de la fecha correspondiente, las fechas en color rojo, corresponde a los horarios que fueron modificados durante el mes.</h7>
            <br>
            <hr>
            <select class="form-control select2" id='txt_libro' name='txt_libro' style="width: 100%;" onchange="elegirMarcacion();">
              <option value="">Elegir Fechas</option>
              <?php 
                  foreach ($Fechas as $F) {
                      echo "<option value='".$F["ID_Fecha"]."'>".$F["Fecha"]."</option>";
                  }
              ?>
            </select>
          </div>
          <br>
          <!-- <div class="input-group" id="div_filtros" style="display: none;"> -->
<!--             <form name="lol" method="post" action="<?php echo site_url();?>App_ModuloTareas/elegirTareasAsignadas">
              <div class="row">
                <div class='col-md-3'>
                  <label for='company'>&nbsp;&nbsp;&nbsp;&nbsp;Buscar por Local</label>
                   <div class='input-group'> &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class='input-group-addon'><i class='fa fa-user'></i></span>
                    <select class='form-control select2' id='local' name='local' onchange="document.getElementById('lol').submit();" style="width: 350px;" data-plugin='select2' >
                            <option value=''>Selecione un Local</option>
                    </select>
                  </div>
                </div>
                 <div class='col-md-3'>
                  <label for='company'>&nbsp;&nbsp;&nbsp;&nbsp;Buscar por Local</label>
                   <div class='input-group'> &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class='input-group-addon'><i class='fa fa-user'></i></span>
                    <select class='form-control select2' id='local' name='local' onchange="document.getElementById('lol').submit();" style="width: 350px;" data-plugin='select2' >
                            <option value=''>Selecione un Local</option>
                    </select>
                  </div>
                </div>
              </div>
            </form> -->
          <!-- </div> -->
          <div id="div_libro">
            <div id="loader" style="display: none;" ></div>         
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
