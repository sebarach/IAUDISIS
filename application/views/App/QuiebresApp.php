<main class="main">
  <hr>
  <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb"> 
    <li class="breadcrumb-item ">
      <a href="<?php echo base_url("menu/index");?>"><i class="mdi mdi-keyboard-backspace"></i></a>
    </li>     
    <li class="breadcrumb-item active">
      Quiebres
    </li>
  </ol>  
  <div class="col-md-12">
    <h4 class="text-theme">Quiebres <?php echo $Titulo ?></h4>    
  </div>
<!--   <div class="input-group" >
    <form id="lol" name="lol" method="post" action="<?php echo site_url();?>App_ModuloTareas/elegirTareasAsignadas">
      <div class="row">
        <div class='col-md-4'>
          <label for='company'>&nbsp;&nbsp;&nbsp;&nbsp;Buscar Mensual</label>
          <br>
          <div class='input-group'> &nbsp;&nbsp;&nbsp;&nbsp;
            <span class='input-group-addon'><i class='fa fa-user'></i></span>
            <select class='form-control select2' id='local' name='local' onchange="document.getElementById('lol').submit();" style="width: 350px;" data-plugin='select2' >
            </select>
          </div>
    </form>
  </div> -->
  <hr>
  <div class="row">
    <?php foreach ($Quiebres as $q) { ?>    
    <div class="col-md-12">
        <div class="card card-accent-danger ecom-widget-sales">
          <div class="card-body">            
            <div class="col-md-4">
              <div class="card ecom-widget-sales">
                <div class="card-body">
                  <div class="ecom-sales-icon text-center" style="font-size: 400%;color: red;">
                    <i class="mdi mdi-percent"></i> <?php echo $q["PorcentajeQuiebre"];?>
                    <br>
                  </div>
                  <h5 class="text-center"><?php echo $q["NombreFormulario"];?></h5>
                  <ul>
                    <li>Fecha
                        <span><?php echo $q["Fecha"];?></span>
                    </li>
                    <li>Hora
                        <span><?php echo $q["Hora"];?></span>
                    </li>
                  <!--   <li>Porcentaje(%)
                        <span><?php echo $q["PorcentajeQuiebre"];?>%</span>
                    </li> -->
                    <li>Local
                        <span><?php echo $q["NLocal"];?></span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>          
          </div>
        </div>
      <?php } ?>
    </div>
  </div> 
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