<link rel="stylesheet" href="<?php echo  site_url(); ?>/assets/css/switch-especial.css">
<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo site_url(); ?>Adm_ModuloFormulario/crearFormulario">Creación de Formularios</a>
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
                            <div style="text-align:right; width:100%; padding:0;">                
                                <button class="btn btn-outline-theme text-right" type="button" data-toggle="modal" data-target="#modal-duplica"><i class="fa fa-plus"></i> Duplicar Formulario </button>
                            </div>
                            <br>
                            <table id="tabla1" class="display table table-hover table-striped" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap"><i class="fa fa-cogs"></i> Opciones</th>
                                        <th><i class="mdi mdi-pencil-box-outline"></i> Nombre Formulario</th>
                                        <th><i class="fa fa-bookmark-o"></i> Observaciones</th>
                                        <th><i class="fa fa-calendar"></i> Fecha Creación</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                        foreach($Formularios as $f){
                                            echo "<tr>";
                                            echo "<td>
                                                   <div class='btn-group btn-group-sm' role='group' aria-label='Basic example'>";
                                            echo "<button type='button' class='btn btn-sm btn-danger' title='Configurar Formulario' onclick='configFormulario(".$f['ID_Formulario'].")'><i class='fa fa-cogs'></i>Configurar</button>&nbsp;&nbsp;";
                                            echo " <form method='post' action ='".site_url()."Adm_ModuloFormulario/editarFormulario'>";
                                            echo "<input type='hidden' name='txt_id' value='".$f['ID_Formulario']."'>
                                            <button type='submit' class='btn btn-sm btn-danger' title='Editar Formulario'><i class='fa  fa-edit'></i> Editar</button>&nbsp;&nbsp;
                                            ";
                                            echo "</form>";
                                            echo "<button type='button' class='btn btn-sm btn-danger' title='Agregar Dependencias' onclick='dependeciasFormulariosP(".$f['ID_Formulario'].")'><i class='fa fa-chain'></i>Dependencias</button>&nbsp;&nbsp;";
                                            if($f["galeria"]>0){
                                                echo " <form method='post' action ='".site_url()."Adm_ModuloFormulario/galeria/".str_replace('/','@@',openssl_encrypt($_SESSION["Cliente"].'-'.$f['ID_Formulario'],"AES-256-CBC","25c6c7ff35b9979b151f2136cd13b0ff",0,"1234567812345678"))."'>";
                                                echo "<input type='hidden' name='txt_id' value='".$f['ID_Formulario']."'><button type='submit' class='btn btn-sm btn-danger' title='Ver Galería' onclick=''><i class='fa fa-camera'></i> Galería</button>&nbsp;&nbsp;";
                                                echo "</form>";
                                            }                                               
                                            if($f["Activo"]==0){
                                                echo"<button type='button' class='btn btn-sm btn-danger' title='Activar Formulario'  onclick='cambiarEstadoFormulario(".$f['ID_Formulario'].",".$f["Activo"].")'><i class='fa fa-times'></i></button>";
                                            }else{
                                                echo"<button type='button' class='btn btn-sm btn-success' title='Desactivar Formulario' onclick='cambiarEstadoFormulario(".$f['ID_Formulario'].",".$f["Activo"].")'><i class='fa fa-check'></i></button>";
                                            }                                            
                                            echo "</div></td>";
                                            echo "<td>".$f["NombreFormulario"]."</td>";
                                            echo "<td>".$f["observacion"]."</td>";
                                            echo "<td>".$f["FechaCreacion"]."</td>";
                                           
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
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Asignar Formulario</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="asignar"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="IngresarFormulario();">Guardar Cambios</button>
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

     <!-- Modal Dependencias Padre-->
    <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="modal-depenP">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Asignar Dependencias</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modal-dependenciaP"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal Dependencias Hijo-->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"  aria-hidden="true" id="modal-depenH">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Asignar Dependencias</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modal-dependenciaH"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('FrmDependencias').submit();">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Duplicar Formulario -->
    <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="modal-duplica">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method='post' action='<?php echo site_url(); ?>/Adm_ModuloFormulario/DuplicarFormulario'>
                    <div class="modal-header bg-info">
                        <h6 class="modal-title text-white">Duplicar Formulario</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h7>Para duplicar un formulario, solo debe escoger el cliente de donde proviene dicho formulario. Después debe escoger el formulario y colocar un nuevo nombre. Las listas de Maestra de Elementos y locales no se pueden replicar.</h7>
                        <br>
                        <hr>
                        <div class="card card-body border-info mb-3" style="text-align:center; border-bottom-right-radius: 10px 10px; border-bottom-left-radius: 10px 10px; text-align:center; border-top-left-radius: 10px 10px; border-top-right-radius: 10px 10px" id="div_cliente">
                            <h6 class="text-info">Clientes</h6>
                            <select class="form-control" id="lb_cliente" name="lb_cliente" style="width: 100%;" onchange="elegirClienteDuplicar();">
                                <option value="">Elegir Cliente</option>
                                <?php
                                    foreach ($Clientes as $c) {
                                        echo "<option value='".$c["NombreBD"]."' >".$c["NombreCliente"]."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="card card-body border-info mb-3" style="text-align:center; border-bottom-right-radius: 10px 10px; border-bottom-left-radius: 10px 10px; text-align:center; border-top-left-radius: 10px 10px; border-top-right-radius: 10px 10px; display: none;" id="div_formulario">
                            <h6 class="text-info">Formularios</h6>
                            <select class="form-control" id="lb_formulario" name="lb_formulario" style="width: 100%;" onchange="validardatosDuplicar();">
                                <option value="">Elegir Formulario</option>
                            </select>
                        </div>
                        <div class="card card-body border-info mb-3" style="text-align:center; border-bottom-right-radius: 10px 10px; border-bottom-left-radius: 10px 10px; text-align:center; border-top-left-radius: 10px 10px; border-top-right-radius: 10px 10px; display: none;" id="div_nombre">
                            <h6 class="text-info">Nombre del Formulario</h6>
                            <input type="text" class="form-control" id="txt_nuevonombre" name="txt_nuevonombre" oninput="validardatosDuplicar();">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-info" id="bt_guardar" style="display: none;">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Configurar -->
    <div class="modal fade bs-example-modal-config" tabindex="-1" role="dialog"  aria-hidden="true" id="modal-config">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Configurar Formulario</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modal-configuracion"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>  
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('FrmConfig').submit();">Guardar Cambios</button>                  
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