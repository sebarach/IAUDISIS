
<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item active">Administración Grupo Locales</li>
    </ol>
    <div class="container-fluid">
        <h4 class="text-theme">Inserción Masiva de Locales a un Grupo de Locales</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="car">
                    <div class="card-header">
                        <i class="mdi mdi-arrow-right-drop-circle"></i> Paso 1 
                    </div>
                    <div class="card-body" style="height:300px;">
                        <h5 class="card-title">Plantilla de carga masiva a grupo de locales</h5>
                        <p class="card-text">Para poder ingresar locales de manera masiva a un grupo de locales a travez de un Excel debemos tener la plantilla con las columnas bien definidas para que la plataforma valide e ingrese sin problemas.</p>
                        <br>                    
                        <a href="<?php echo  site_url(); ?>doc/plantilla/PlantillaGruposLocalesEjemplo.xlsx" class="btn btn-theme" title='Descargar Plantilla'><i class="mdi mdi-file-excel"></i> Descargar Plantilla</a>
                    </div>
                    <div class="card-footer text-muted">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="car">
                    <div class="card-header">
                        <i class="mdi mdi-arrow-right-drop-circle"></i> Paso 2 
                    </div>
                    <div class="card-body" style="height:300px;">
                        <h5 class="card-title">Ingresar Excel</h5>
                        <p class="card-text">Antes de ingresar la plantilla con los locales al grupo de locales, debemos saber cómo son las columnas y/o campos requeridos. Si usted no tiene conocimiento al respecto, descargue la plantilla.</p>             
                        <div class="btn btn-theme"><i class="mdi mdi-alarm-plus"></i> Seleccione Excel para Ingresar <i id="ingresarExcelSping" class=""></i> 
                            <form action="IngresarLocalesMasivos" method='POST' id="IngresarExcelg" name="IngresarExcelg" enctype="multipart/form-data" >                    
                                <input type='file' class="btn btn-xs btn-dark" id="excelvg" name="excelvg" onchange="formatoValIngresoGrupo('#excelvg');">
                            </form>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                    </div>
                </div>
            </div>
        </div>
        <div class="animated fadeIn">
            <div class="row">
                 <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body">
                            <h4 class="text-theme">Administración de Grupo Locales</h4>
                            <p>Se puede ver la información, editar, agregar y cambiar de la vigencia de los Grupo de Locales</p>                            
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarGrupoL"><i class="fa fa-plus-circle" ></i> Agregar Grupo Local</button>
                            <br><br><br>
                            <h4 class="text-theme">Lista de Grupo de Locales</h4>
                            <table id="tabla1" class="display table table-hover table-striped" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap"><i class="fa fa-cogs"></i> Opciones</th>
                                        <th><i class="mdi mdi-factoryx|"></i> Nombre del Grupo Local</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                        foreach($GrupoL as $g){
                                            echo "<tr>";                                                                                       
                                            echo"<td><button type='button' class='btn btn-sm btn-warning' title='Editar Grupo Locales' onclick='EditarGrupoLocales(".$g["ID_Grupolocal"].",1)'><i class='fa  fa-edit'> &nbsp;Editar Grupo </i></button>";
                                            echo"<button type='button' class='btn btn-sm btn-info' title='Editar Locales del Grupo' onclick='EditarGrupoLocales(".$g["ID_Grupolocal"].",2)'><i class='fa fa-user'> &nbsp;Editar Locales </i></button>";

                                            if($g["Activo"]==0){
                                                 echo"<button type='button' class='btn btn-danger' title='Activar Grupo Locales'  onclick='cambiarEstadoGrupoLocal(".$g['ID_Grupolocal'].",".$g["Activo"].")'><i class='fa fa-times'></i></button>";
                                            }else{
                                                echo"<button type='button' class='btn btn-success' title='Desactivar Grupo Usuarios' onclick='cambiarEstadoGrupoLocal(".$g['ID_Grupolocal'].",".$g["Activo"].")'><i class='fa fa-check'></i></button>";
                                            }                                            
                                            echo "</td>";
                                            echo "<td>".$g["NombreGL"]."</td>";
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
    <div class="modal fade" id="modal-desactivar-grupoL" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estadoGrupoL1"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarEstadoGrupoLocal').submit();">Desactivar Grupo Usuario</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activar-grupoL" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estadoGrupoL2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarEstadoGrupoLocal').submit();">Activar Grupo Usuario</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal Editar Cadena -->
     <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="editGrupoL">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h6 class="modal-title text-white">Editar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editarGrupoL"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Cerrar</button>
                    <button type="submit" class="btn btn-warning" onclick="return ValidarCreacionGrupoLocal();"><i class="fa fa-check-square-o"  id="botonAgregarGrupoL"></i> Editar Grupo Local</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar GrupoL -->
    <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="agregarGrupoL">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white">Agregar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='post' id='FormNuevoGrupoL' action='#'>
                        <div class="form-group">
                            <label for="control-demo-1" class="col-sm-6">Nombre Grupo Local <label style="color:red">* &nbsp;</label></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <input type="text" id="txt_grupoLocal" name="txt_grupoLocal" class="form-control" placeholder="Nombre del Grupo Local" required>
                            </div>
                            <div  id="val_grupoLocal" style="color:red;"></div>                               
                        </div>    
                        <div class="form-group">
                            <label for="control-demo-1" class="col-sm-6">Agregar Locales</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                                <select id="select1" class="form-control select2" data-plugin="select2" multiple  id='txt_locales[]' name='txt_locales[]' style="width: 100%;">
                                    <?php 
                                        foreach ($LocalesA as $l) {
                                            echo "<option value='".$l["ID_Local"]."''>".$l["NombreLocal"]."</option>";
                                        }
                                    ?>
                                </select>
                            </div>                            
                        </div>    
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary" onclick="return ValidarCreacionGrupoLocal();"><i class="fa fa-check-square-o"  id="botonAgregarGrupoL"></i> Agregar Grupo Local</button>
                </div>
            </div>
        </div>
    </div>

</main>

<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/select2/dist/js/select2.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/multiselect/js/jquery.multi-select.js"></script>

<script type="text/javascript">
    
//select multiple 1
$('#select1').select2({});

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
});
</script>