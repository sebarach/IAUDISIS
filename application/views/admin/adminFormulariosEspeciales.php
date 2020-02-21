<link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/css/switch-especial.css">
<main class="main"  style="height: 100%;">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item active">Administración de Formularios</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                 <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body">
                            <h4 class="text-theme">Administración de Formulario</h4>
                            <!-- <p>Se puede ver la información, editar y cambiar de la vigencia de los usuarios</p> -->
                            <table id="tabla1" class="display table table-hover table-striped" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap"><i class="fa fa-cogs"></i> Opciones</th>
                                        <th><i class="mdi mdi-pencil-box-outline"></i> Nombre Formulario</th>
                                        <th><i class="mdi mdi-pencil-box-outline"></i> Grupo Local</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                        foreach($Formularios as $f){
                                            echo "<tr>";
                                            echo "<td>
                                                   <div class='btn-group btn-group-sm' role='group' aria-label='Basic example'>";
                                            echo "<button type='button' class='btn btn-sm btn-info' title='Grupo Local' onclick='configFormularioEspecialGrupoLocal(".$f['ID_FormularioEspecial'].")'><i class='fa fa-cogs'></i>Grupo Local</button>&nbsp;&nbsp;";
                                            if($f["Activo"]==0){
                                                echo"<button type='button' class='btn btn-sm btn-danger' title='Activar Formulario'  onclick='cambiarEstadoFormularioEspecial(".$f['ID_FormularioEspecial'].",".$f["Activo"].")'><i class='fa fa-times'></i></button>";
                                            }else{
                                                echo"<button type='button' class='btn btn-sm btn-success' title='Desactivar Formulario' onclick='cambiarEstadoFormularioEspecial(".$f['ID_FormularioEspecial'].",".$f["Activo"].")'><i class='fa fa-check'></i></button>";
                                            }                                            
                                            echo "</div></td>";
                                            echo "<td>".$f["NombreFormulario"]."</td>";
                                            echo "<td>".$f["NombreGL"]."</td>";
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

     <!-- Modal Asignar -->
    <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="modal-asignar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h6 class="modal-title text-white">Asignar Formulario</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                   <form method='post' id='asignarFormularioEspecialGrupoLocales' action='asignarFormularioEspecialGrupoLocales'>   
                        <div class="form-group">
                            <label for="control-demo-1" class="col-sm-6">Agregar Locales</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                                <select id="select1" class="form-control select2" data-plugin="select2" id='txt_grupo' name='txt_grupo' style="width: 100%;" required>
                                    <?php 
                                        if(isset($GrupoL)){
                                            echo "<option value='''>elegir Local</option>";
                                            foreach ($GrupoL as $g) {
                                                echo "<option value='".$g["ID_Grupolocal"]."''>".$g["NombreGL"]."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>                            
                        </div>    
                        <input type="hidden" name="txt_formu" id="txt_formu">
                    </form>;
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-info" onclick="document.getElementById('asignarFormularioEspecialGrupoLocales').submit();">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Desactivar -->
    <div class="modal fade" id="modal-desactivar-formulario" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estadoFormulario1"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarEstadoFormulario').submit();">Desactivar Formulario</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activar-formulario" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estadoFormulario2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarEstadoFormulario').submit();">Activar Formulario</button>
                </div>
            </div>
        </div>
    </div>

</main>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo  site_url(); ?>/assets/libs/clockpicker/dist/bootstrap-clockpicker.min.js"></script>
<script src="<?php echo  site_url(); ?>/assets/libs/timepicker/dist/jquery.timepicker.min.js"></script>
<script src="<?php echo  site_url(); ?>/assets/libs/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?php echo  site_url(); ?>/assets/libs/typeahead/typeahead.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/form-masks/dist/formatter.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/dropify/dist/js/dropify.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/js/jsFormulario.js"></script>
<script type="text/javascript">
    // Tabla 1


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
    var mensaje='<?php echo $mensaje; ?>';
    if (mensaje.length>0) {
        alertify.success(mensaje);
    }

});




</script>