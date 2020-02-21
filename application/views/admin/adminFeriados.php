
<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item active">Administración Feriados</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                 <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body">
                            <h4 class="text-theme">Administración de Feriados</h4>
                            <p>Se puede ver la información, editar, agregar y cambiar de la vigencia de los feriados</p>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarFeriado"><i class="fa fa-plus-circle" ></i> Agregar Feriado</button>
                            <br><br><br>
                            <h4 class="text-theme">Lista de Feriados</h4>
                            <table id="tabla1" class="display table table-hover table-striped" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap"><i class="fa fa-cogs"></i> Opciones</th>
                                        <th><i class="mdi mdi-factory"></i> Nombre Feriado</th>                                        
                                        <th><i class="mdi mdi-factory"></i> Fecha Feriado</th>      
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                        foreach($Feriados as $f){
                                            echo "<tr>";                                                                                       
                                            echo"<td><button type='submit' class='btn btn-sm btn-warning' title='Editar Feriado' onclick='EditarFeriado(".$f["ID_Feriado"].")'><i class='fa  fa-edit'></i> &nbsp;Editar Feriado </button>";
                                            if($f["Vigencia"]==0){
                                                 echo"<button type='button' class='btn btn-danger' title='Activar Feriado'  onclick='cambiarEstadoFeriado(".$f['ID_Feriado'].",".$f["Vigencia"].")'><i class='fa fa-times'></i></button>";
                                            }else{
                                                echo"<button type='button' class='btn btn-success' title='Desactivar Feriado' onclick='cambiarEstadoFeriado(".$f['ID_Feriado'].",".$f["Vigencia"].")'><i class='fa fa-check'></i></button>";
                                            }                                            
                                            echo "</td>";
                                            echo "<td>".$f["Nombre_Feriado"]."</td>";
                                            echo "<td>".$f["Fecha_Feriado"]."</td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Desactivar -->
    <div class="modal fade" id="modal-desactivar-Feriado" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estadoFeriado1"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarEstadoFeriado').submit();">Desactivar Feriado</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activar-Feriado" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estadoFeriado2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarEstadoFeriado').submit();">Activar Feriado</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal Editar Feriado -->
     <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="editFeriado">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h6 class="modal-title text-white">Editar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editarFeriado"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Cerrar</button>
                    <button type="submit" class="btn btn-warning" onclick="return ValidarCreacionFeriado();"><i class="fa fa-check-square-o"  id="botonAgregarFeriado"></i> Editar Feriado</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Feriado -->
    <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="agregarFeriado">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white">Agregar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='post' id='FormNuevoFeriado' action=''>
                        <div class="form-group">
                            <label for="control-demo-1" class="col-sm-6">Nombre Feriado <label style="color:red">* &nbsp;</label></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                                <input type="text" id="txt_Nombre" name="txt_Nombre" class="form-control" placeholder='Nombre del Feriado' required>
                            </div>
                            <div  id="val_Nombre" style="color:red;"></div>                               
                        </div> 
                        <div class="form-group">
                            <label for="control-demo-1" class="col-sm-6">Fecha Feriado <label style="color:red">* &nbsp;</label></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                                <input type="text" id="txt_Fecha" name="txt_Fecha" class="form-control" data-mask required>
                            </div>
                            <div  id="val_Fecha" style="color:red;"></div>                               
                        </div> 
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary" onclick="return ValidarCreacionFeriado();"><i class="fa fa-check-square-o"  id="botonAgregarFeriado"></i> Agregar Feriado</button>
                </div>
            </div>
        </div>
    </div>

</main>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<!-- <script src="<?php echo  site_url(); ?>assets/libs/form-masks/dist/formatter.min.js"></script> -->
<script src='<?php echo  site_url(); ?>/assets/js/bootstrap.min.js'></script>
<script src='<?php echo base_url('assets/libs/input-mask/jquery.inputmask.js')?>'></script>
<script src='<?php echo base_url('assets/libs/input-mask/jquery.inputmask.date.extensions.js')?>'></script>
<script src='<?php echo base_url('assets/libs/input-mask/jquery.inputmask.extensions.js')?>'></script>

<script type="text/javascript">
    // Tabla 1

$('#txt_Fecha').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-aaaa' });  

$(document).ready(function() {
    var table = $('#tabla1').DataTable( {
        scrollY:        "350px",
        scrollX:        true,
        searching: true,
        scrollCollapse: true,
        paging:         true,
        fixedColumns:   {
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
    });
});
</script>