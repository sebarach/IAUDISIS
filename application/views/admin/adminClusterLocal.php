<main class="main" style="height: 100%;">
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
            <h4 class="text-theme">Inserción Masiva de Locales para Clúster</h4>
            <div class="row">               
                <div class="col-md-12">
                    <div class="card card-accent-theme ">
                        <div class="todo-widget">
                            <div class="row">
                                <div class="col-md-9">
                                  <h1>Clúster Locales</h1>
                                </div>
                                <div class="col-md-3">
                                    <a href="<?php echo  site_url(); ?>doc/plantilla/PlantillaClusterLocal.xlsx" class="btn btn-theme" title='Descargar Plantilla'><i class="mdi mdi-file-excel"></i> Descargar Plantilla</a>
                                </div>
                            </div>

                            <form action="IngExcelClusterLocal" method='POST' id="IngresarExcel" name="IngresarExcel" enctype="multipart/form-data" >
                                <input type="file"  class="btn btn-xs btn-danger" name="excelv" id="excelv" onchange="formatoValIngresoLocal('#excelv');">
                            </form>

                            <div class="table-responsive">
                                <table class="table color-bordered-table danger-bordered-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="padding-left: 100px;">Nombre Clúster</th>
                                            <th>Fecha Creación</th>
                                            <th style="padding-left: 50px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php $contador=1;
                                        foreach ($ClusterLocal as $c) { 
                                         ?>
                                        <tr>
                                            <td style="padding-top: 35px;"><?php echo $contador?></td>
                                            <td style="padding-left: 110px; padding-top: 35px;"><?php echo $c['Nombre_Cluster_Local']?></td>
                                            <td style="padding-top: 35px;"><?php echo $c['FechaRegistro']?></td>
                                            <td style="padding-left: 50px;">  
                                              <form id='FrmVerClusterLocal' method='POST' action="<?php echo  site_url();?>Adm_ModuloElementos/verClusterLocal">    
                                              <input type="hidden" name="var" value="<?php echo $c['ID_Cluster_Local_Union'];?>"/>   
                                              <button class="btn btn-danger"><i class="mdi mdi-eye"></i>&nbsp;Ver Clúster</button> 
                                              <?php if ($c["Activo"]==1) { ?>
                                              <button type="button" class="btn btn-danger" onclick='actualizarCluster("<?php echo $c["ID_Cluster_Local_Union"];?>");'><i class="mdi mdi-grease-pencil"></i>&nbsp;Editar Clúster</button>
                                              <button type="button" class="btn btn-success" onclick='activarClusterLocal("<?php echo $c["ID_Cluster_Local_Union"]?>","<?php echo $c["Activo"];?>");'><i class="mdi mdi-check"></i></button></form></td>
                                              <?php }else{ ?>
                                              <button type="button" class="btn btn-danger" onclick='activarClusterLocal("<?php echo $c["ID_Cluster_Local_Union"]?>","<?php echo $c["Activo"];?>");'><i class="mdi mdi-block-helper"></i></button></td>
                                            <?php } ?>
                                        </tr>
                                      <?php  $contador++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</main>

<div class="modal fade" id="modal-desactivarCluster" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar Clúster</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estado1Cluster"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarCluster').submit();">Desactivar Clúster</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activarCluster" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar Clúster</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sa-icon sa-success animate"></div>
                    <div id="estado2Cluster"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarCluster').submit();">Activar Clúster</button>
                </div>
            </div>
        </div>
    </div>

     <div class="modal fade" id="modal-actualizarClusterLocal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Actualizar Clúster Local</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sa-icon sa-danger animate"></div>
                    <div id="actualizarClusterLocal"></div>
                </div>
            </div>
        </div>
    </div> 

<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/dropify/dist/js/dropify.min.js"></script>
<script type="text/javascript">

    function activarClusterLocal(idcluster,estado){
        $.ajax({
              url: "ActivarCluster",
              type: "POST",
              data: "idcluster="+idcluster+"&estado="+estado,
              success: function(data) {
                if(estado==1){
                  $("#estado1Cluster").html("");
                      $("#estado1Cluster").html(data);
                      $("#modal-activarCluster").modal('hide');
                      $("#modal-desactivarCluster").modal('show');
                }else{
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
            url: "actualizarClusterLocal",
            type: "POST",
            data: "id="+id,
            success: function(data){
                $("#actualizarClusterLocal").html("");
                $("#actualizarClusterLocal").html(data);
                $("#modal-actualizarClusterLocal").modal('show');
            }

    });
    }

    function formatoValIngresoLocal(excelv){
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
                url:"Adm_ModuloElementos/IngExcelClusterLocal",                     
                type : form.attr('method'),
                data : new FormData(form[0]), 
                dataType : 'json',
                processData: false,  
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

</script>