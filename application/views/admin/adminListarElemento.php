<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
                <li class="breadcrumb-item ">
                <a href="<?php echo site_url(); ?>menu">Menú</a>
                </li>
                <li class="breadcrumb-item">
                <a href="<?php echo site_url(); ?>Adm_ModuloUsuario/listarElemento">Administración de Elementos</a>
                </li>
            </ol>
            <div class="container">

                <div class="animated fadeIn">
                    <div class="row">
                         <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    
                                    <h4 class="text-theme">Administración de Elementos</h4>
                                    <p>Modulo de Administrador de elementos. Este modulo esta creado para ver en detalle los elementos, editarlos y desactivarlos.</p>
                                    <hr>
                                    <!-- <form id="vigencia" name="vigencia" method="post" action="<?php echo  site_url();?>Adm_ModuloElementos/buscarVigencia">
                                        <div class='col-md-3' style='margin-top:10px;'>
                                                <label for='company'>Vigencia</label>
                                                <div class='input-group'>
                                                    <span class='input-group-addon'>
                                                        <i class='fa fa-check-circle-o'></i>
                                                    </span>
                                        <select id='msltVig' name='msltVig' class='form-control form-control-sm' onchange="document.getElementById('vigencia').submit();">
                                            <option value=5>Seleccione...</option>
                                            <option value=1>Vigente</option>
                                            <option value=0>No Vigente</option>
                                            <option value=2>Todos</option>
                                        </select>
                                        </div>
                                        </div>
                                    </form> -->
                                    <br>
                                    <hr>
                        
                                    <h4 class="text-theme">Lista de Elementos</h4>
                                        
                                        <table id="example" class="table color-bordered-table danger-bordered-table"  width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap">Opciones</th>
                                                    <th><i class="mdi mdi-border-all"></i> Nombre</th>
                                                    <th><i class="mdi mdi-border-all"></i> Foto</th>
                                                    <th><i class="mdi mdi-codepen"></i>Categoría</th>
                                                    <th><i class="mdi mdi-clipboard"></i>Marca</th>
                                                    <th><i class="mdi mdi-barcode"></i> Código </th>      
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                    <?php
                                        foreach ($Elementos as $e) {
                                            if($e['Activo']==1){$vigencia='Vigente';}else{$vigencia='No Vigente';}
                                        echo "<tr> 
                                                <form id='FrmEditarElemento' method='POST'> 
                                                    
                                                    <td class='text-nowrap'>
                                                        <button type='button' id='editElementofrom' data-toggle='modal' data-target='.bs-example-modal-Elemento' class='btn btn-sm btn-warning' onclick='MeditarElemento(\"$e[ID_Elemento]\");' ><i class='fa fa-edit text-inverse'></i>Editar Elemento</button>";
                                                         if($e["Activo"]==0){
                                                 echo"<button type='button' class='btn btn-danger' title='Activar Elemento'  onclick='cambiarElemento(".$e['ID_Elemento'].",".$e["Activo"].")'><i class='fa fa-times'></i></button>";
                                            }else{
                                                echo"<button type='button' class='btn btn-success' title='Desactivar Elemento' onclick='cambiarElemento(".$e['ID_Elemento'].",".$e["Activo"].")'><i class='fa fa-check'></i></button>";
                                            };      
                                                       
                                              echo"      </td>
                                              <td>".$e['Nombre']."</td>
                                              <td><div class='u-img'><img src='".site_url().$e["Foto"]."'></div></td>
                                                    <td>".$e['Categoria']."</td>            
                                                    <td>".$e['Marca']."</td>
                                                    <td>".$e['Cod_SKU']."</td>
                                                </form>
                                            </tr>
                                        ";}?>                                         
                                            </tbody>
                                        </table>
                                        
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                </div>
                <!-- end animated fadeIn -->
            </div>
            <!-- end container-fluid -->

        </main>

        <!-- Modal Desactivar -->
    <div class="modal fade" id="modal-desactivarElemento" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar Elemento</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estado1Elemento"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarElemento').submit();">Desactivar Elemento</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activarElemento" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar Elemento</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sa-icon sa-success animate"></div>
                    <div id="estado2Elemento"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarElemento').submit();">Activar Elemento</button>
                </div>
            </div>
        </div>
    </div>
   <div class="modal fade bs-example-modal-Elemento" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="MEditarElementos">
        <div class="modal-dialog ">
            <div class="modal-content" id="MEditarElemento">
             
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

<script src="<?php echo  site_url(); ?>assets/libs/bootstrap-switch/bootstrap-switch.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/bootbox/bootbox.min.js"></script>
    <!--sweetalert -->
<script src="<?php echo  site_url(); ?>assets/libs/sweetalert/sweetalert.js"></script>

<script type="text/javascript">

function MeditarElemento(idele){      
    $.ajax({
            url: "EditarElemento",
            type: "POST",
            data: "idele="+idele,
            success: function(data) {
              $("#MEditarElemento").html(data);
             }
        });
      }    

function cambiarElemento(idele,estado){
        $.ajax({
            url: "cambiarElemento",
            type: "POST",
            data: "idele="+idele+"&estado="+estado,
            success: function(data) {                
                if(estado==1){
                    $("#estado1Elemento").html("");
                    $("#estado1Elemento").html(data);
                    $("#modal-activarElemento").modal('hide');
                    $("#modal-desactivarElemento").modal('show');
                }else{
                    $("#estado2Elemento").html("");
                    $("#estado2Elemento").html(data);
                    $("#modal-desactivarElemento").modal('hide');
                    $("#modal-activarElemento").modal('show');
                }                
            }
        });
    }

    $(document).ready(function() {
    var table = $('#example').DataTable( {
        scrollY: "350px",
        scrollX: true,
        searching: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: {
            leftColumns: 1,
        },
            "language": {
        "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "No se encontraron resultados",
        "sEmptyTable":    "Ningún dato disponible en esta tabla",
        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":   "",
        "sSearch":        "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":    "Último",
            "sNext":    "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
    } );
} );

</script>