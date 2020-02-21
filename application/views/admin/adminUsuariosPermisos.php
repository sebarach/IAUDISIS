
<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo site_url(); ?>Adm_ModuloUsuario/creacionUsuario">Creación de Usuario</a>
        </li>
        <li class="breadcrumb-item active">Administración de Usuarios</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                 <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body">
                            <h4 class="text-theme">Administración de Usuarios</h4>
                            <p>Se puede ver la información, editar y cambiar de la vigencia de los usuarios</p>
                            <table id="tabla1" class="display table table-hover table-striped" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap"><i class="fa fa-cogs"></i> Opciones</th>
                                        <th><i class="fa fa-camera"></i> Fotografía</th> 
                                        <th><i class="fa fa-user"></i> Nombre</th> 
                                        <th><i class="fa fa-user-o"></i> Rut</th>                                         
                                        <th><i class="mdi mdi-gender-male-female"></i> Género</th> 
                                        <th><i class="mdi mdi-cellphone-iphone"></i> Teléfono</th> 
                                        <th><i class="mdi mdi-email-outline"></i> Email</th> 
                                        <th><i class="mdi mdi-home"></i> Dirección</th> 
                                        <th><i class="fa fa-vcard-o"></i> Cargo</th> 
                                        <th><i class="fa fa-group"></i> Perfil</th> 
                                        <th><i class="fa fa-id-badge"></i> Usuario</th> 
                                        <th><i class="fa fa-key"></i> Clave</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                        foreach($Usuarios as $u){
                                            echo "<tr>";
                                            echo "<td><form method='post' action ='".site_url()."Adm_ModuloUsuario/editarUsuario'><div class='btn-group btn-group-sm' role='group' aria-label='Basic example'>
                                            <input type='hidden' name='txt_id' value='".$u['ID_Usuario']."'>
                                            <button style='width:250px;' type='button' class='btn  btn-outline-theme' title='Asignar Modulo' onclick='asignarModulo(".$u['ID_Usuario'].");'><i class='fa fa-hand-o-right'></i>&nbsp; Asignar Módulos</button>&nbsp;&nbsp;";               
                                            echo "</div></form></td>";
                                            echo "<td><div class='u-img'><img src='".site_url().$u["FotoPerfil"]."'></div></td>";
                                            echo "<td>".$u["Nombre"]."</td>";
                                            echo "<td>".$u["RUT"]."</td>";
                                            echo "<td>".$u["Genero"]."</td>";
                                            echo "<td>".$u["Telefono"]."</td>";
                                            echo "<td>".$u["Email"]."</td>";
                                            echo "<td>".$u["Direccion"]."</td>";
                                            echo "<td>".$u["Cargo"]."</td>";
                                            echo "<td>".$u["NombrePerfil"]."</td>";
                                            echo "<td>".$u["Usuario"]."</td>";
                                            echo "<td>".openssl_decrypt($u["Clave"],"AES-128-ECB","12314")."</td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <!-- <form method="POST" action="generarExcelUsuarios">
                                <button class="btn btn-outline-theme" type="submit" title='Descargar Plantilla'><i class="mdi mdi-file-excel"></i> Descargar Lista de Usuarios</button> 
                            </form>  -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="animated fadeIn">
            <div class="row">
                 <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body">
                            <h4 class="text-theme">Lista de Módulos</h4>
                            <p>Se puede ver la información acerca de los módulos.</p>
                            <table id="tabla1" class="display table table-hover table-striped" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap"><i class="fa fa-briefcase"></i> Nombre</th>
                                        <th style="padding-left:600px;"><i class="fa fa-file-text"></i> Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                        foreach($Modulos as $m){
                                            echo "<tr>";
                                            echo "<td>".$m["NombreModulo"]."</td>";
                                            echo "<td style='padding-left:600px;'>".$m["Descripcion"]."</td>";
                                            echo "</tr>";
                                        }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Desactivar -->
    <div class="modal fade" id="modal-desactivar" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estado1"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarEstado').submit();">Desactivar Usuario</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activar" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estado2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarEstado').submit();">Activar Usuario</button>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modal-asignarModulo" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Asignar Módulos a Coordinador</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="sa-icon sa-danger animate"></div>
                <div id="asignarModulo"></div>
            </div>
        </div>
    </div>
</div> 

<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
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
});

function asignarModulo(id){
    $.ajax({
            url: "asignarModulo",
            type: "POST",
            data: "id="+id,
            success: function(data){
                $("#asignarModulo").html("");
                $("#asignarModulo").html(data);
                $("#modal-asignarModulo").modal('show');
            }
    });
}
</script>