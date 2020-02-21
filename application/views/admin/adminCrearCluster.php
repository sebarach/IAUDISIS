<style type="text/css">
  
  .bg {
  background-color: #F03434; 
  color:white;
}
</style>

<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo site_url(); ?>Adm_ModuloElementos/creacionElemento">Crear Elementos</a>
        </li>
    </ol>
    <div class="container-fluid">
      <div class="card-body"> 
        <h4 class="text-theme">Inserción Masiva de Elementos para cluster</h4>
            <div class="row">               
                <div class="col-md-12">
                    <div class="card card-accent-theme ">
                        <div class="todo-widget">
                            <div class="row">
                              <div class="col-md-9">
                                <h1>Cluster Elementos</h1>
                              </div>
                              <div class="col-md-3">
                                  <form action="DescargaExcelClusterElemento" method='POST' id="IngresarExcelClusterElemento" name="IngresarExcelClusterElemento" enctype="multipart/form-data">
                                    <button type='submit' class='btn btn-theme' title='Descargar Plantilla'><i class='mdi mdi-file-excel'></i> Descargar Plantilla</button>
                                     <!--  <a href="<?php echo  site_url(); ?>doc/plantilla/PlantillaElementosEjemplo.xlsx" class="btn btn-theme" title='Descargar Plantilla'><i class="mdi mdi-file-excel"></i> Descargar Plantilla</a> -->
                                  </form>
                              </div>
                            </div>
                            <form action="IngExcelElemento" method='POST' id="IngresarExcel" name="IngresarExcel" enctype="multipart/form-data" >
                                <input type="file"  class="btn btn-xs btn-danger" name="excelv" id="excelv" onchange="formatoValIngresoElemento('#excelv');">
                            </form>
                            <div class="table-responsive">
                                        <table class="table color-bordered-table danger-bordered-table stlye="width="100%">
                                            <thead class="bg">
                                                <tr>
                                                    <th>Cluster</th>
                                                    <th>Cantidad</th>
                                                    <th class="text-nowrap">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php foreach ($Cluster as $c){ 
                                                if($c['Activo']==1){$vigencia='Vigente';}else{$vigencia='No Vigente';}
                                                ?>
                                                <tr>
                                                  <form id='FrmVerCluster' method='POST' action="<?php echo  site_url();?>Adm_ModuloElementos/verCluster">
                                                    <td style="width: 300px;"><?php echo $c['NombreCluster']?></td>
                                                    <td style="width: 500px;">
                                                        <div class="progress progress-xs margin-vertical-10 ">
                                                            <div class="progress-bar bg-danger" style="width: 65%; height:6px;"></div>
                                                        </div>
                                                    </td>
                                                    <td style="width: 500px;" class="text-nowrap">
                                                       <input type="hidden" name="var" value="<?php echo $c['ID_Cluster'];?>"/>

                                                       <?php if ($c["Activo"]==1) { ?>
                                                         <button class="btn btn-block btn-danger" style="width: 80px;">Ver <i class="mdi mdi-eye"></i></button>
                                                       <?php }else{ ?>
                                                         <button class="btn btn-block btn-danger" style="width: 80px;" disabled>Ver <i class="mdi mdi-eye"></i></button>

                                                       <?php } ?>
                                                        
                                                        </form>
                                                        <?php if ($c['Activo']==1) {
                                                        ?>
                                                        <button onclick="actualizarCluster(<?php echo $c['ID_Cluster'];?>);" class="btn btn-block btn-danger" style="width: 140px;">Actualizar <i class="mdi mdi-refresh"></i></button>
                                                        <button onclick="cambiarCluster(<?php echo $c['ID_Cluster'];?>,<?php echo $c['Activo'];?>)" class="btn btn-block btn-success" style="width: 110px;">Activado <i class='fa fa-check'></i></button>

                                                        <?php 
                                                        }else{ 
                                                        ?>
                                                        <button onclick="cambiarCluster(<?php echo $c['ID_Cluster'];?>,<?php echo $c['Activo'];?>)" class="btn btn-block btn-danger" style="width: 140px;">Desactivado <i class='mdi mdi-close'></i></button>

                                                      <?php 
                                                      }
                                                      ?>
                                                    </td>
                                                  
                                                </tr>
                                              <?php 
                                              }
                                              ?>
                                            </tbody>
                                        </table>
                                    </div>
                              </div>
                                <div class="card-footer text-center"></div>
                        </div>
                    </div>
              </div>
          </div>
        </div> 

        <div class="modal fade" id="modal-activarCluster" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar Cluster</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estado2Cluster"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarCluster').submit();">Activar Cluster</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-desactivarCluster" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar Cluster</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sa-icon sa-danger animate"></div>
                    <div id="estado1Cluster"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarCluster').submit();">Desactivar Cluster</button>
                </div>
            </div>
        </div>
    </div> 

    <div class="modal fade" id="modal-actualizarCluster" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Actualizar Cluster</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sa-icon sa-danger animate"></div>
                    <div id="actualizarCluster"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('IngresarExcelCluster').submit();">Actualizar Excel</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>  
</main>

<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/dropify/dist/js/dropify.min.js"></script>
<script type="text/javascript">


    function formatoValIngresoElemento(excelv){
      if($(excelv).val()!=''){
          var f=($(excelv).val().substring($(excelv).val().lastIndexOf("."))).toLowerCase();
          var validar=true;
          if(f==".xls" || f==".xlsx"){ validar=true;} else {validar=false;}
          if(validar==false){
              alertify.error("El Formato del archivo es invalido");
              document.getElementById("excelv").value="";
          }else if(validar==true){
            $("#ingresarExcelSpin").attr("class","fa fa-spin fa-circle-o-notch");
            var form = $(this);
            var file = document.getElementById("IngresarExcel").submit();
            $.ajax({
                url:"IngExcelElemento",                     
                type : form.attr('method'),
                data : new FormData(form[0]), // <-- usamos `FormData`
                dataType : 'json',
                processData: false,  // <-- le indicamos a jQuery que no procese el `data`
                contentType: false,
                error:function(data){
                    console.log("success");
                    $("#ingresarExcelSpin").attr("class","");
                    $("#excelv").val('');
                }
            });
          }
      }
  }

  function cambiarCluster(id,estado){    
    $.ajax({
            url: "cambiarClusterC",
            type: "POST",
            data: "id="+id+"&estado="+estado,            
            success: function(data) {               
                if(estado==1){
                    $("#estado1Cluster").html("");
                    $("#estado1Cluster").html(data);
                    $("#modal-activarCluster").modal('hide');
                    $("#modal-desactivarCluster").modal('show');
                }else{
                  // alert(data);
                    $("#estado2Cluster").html("");
                    $("#estado2Cluster").html(data);
                    $("#modal-desactivarCluster").modal('hide');
                    $("#modal-activarCluster").modal('show');
                }                
            }
        });
  }

  function actualizarCluster(id){
    $.ajax({
            url: "actualizarCluster",
            type: "POST",
            data: "id="+id,
            success: function(data){
                $("#actualizarCluster").html("");
                $("#actualizarCluster").html(data);
                $("#modal-actualizarCluster").modal('show');
            }

    });
  }



</script>