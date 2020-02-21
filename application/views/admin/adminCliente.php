<style type="text/css">
    
table.noticia td {
  text-align: justify;
}

</style>
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
                <li class="breadcrumb-item ">
                     <a href="<?php echo site_url(); ?>menu">Menú</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">Clientes</a>
                </li>
                <li class="breadcrumb-item active">Administración de Clientes</li>
            </ol>

            <div class="container-fluid">

                <div class="animated fadeIn">

                    <h3>Administración de Clientes</h3>
                <small>Modulo de Administrador de clientes. Este modulo esta creado para ver en detalle el cliente y desactivarlo</small>
                <br><br/>
                <div class="row">
                         <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <h4 class="text-theme">Lista de Empresas</h4>
                                    <p></p>
                                    <div class="table-responsive">
                                        <table id="example-empresas" class="table table-striped" cellspacing="0" width="100%" >
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap">Opciones</th>
                                                    <th ><i class="mdi mdi-factory"></i> Nombre</th>
                                                    <th><i class="mdi mdi-content-paste"></i>Razón Social</th>
                                                    <th><i class="mdi mdi-barcode"></i> Rut Empresa</th>
                                                    <th><i class="mdi mdi-alarm-check"></i> Fecha Registro</th>
                                                    <th><i class="mdi mdi-account-plus"></i> Usuario Creador</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($ListarEmpresa as $c) {
                                                    echo "<tr><form id='FrmEditarEmpresa' method='POST'>
                                                    <td class='text-nowrap'>
                                                            
                                                                <button type='button' id='editEmpresafrom' data-toggle='modal' data-target='.bs-example-modal-Empresa' class='btn btn-sm btn-danger' onclick='MeditarEmpresa(\"$c[ID_Empresa]\");' ><i class='fa fa-edit text-inverse '></i>Editar Empresa</button> ";
                                            if($c["estado"]==0){
                                                 echo"<button type='button' class='btn btn-danger' title='Activar Empresa'  onclick='cambiarEstadoEmpresa(".$c['ID_Empresa'].",".$c["estado"].")'><i class='fa fa-times'></i></button>";
                                            }else{
                                                echo"<button type='button' class='btn btn-success' title='Desactivar Empresa' onclick='cambiarEstadoEmpresa(".$c['ID_Empresa'].",".$c["estado"].")'><i class='fa fa-check'></i></button>";
                                            }      
                                                                
                                            echo"                </td> 
                                                    <td style='word-break:break-all;' width=1000 >".$c['NombreEmpresa']."</td>
                                                            <td style='word-break:break-all;' width=1000><p>".$c['RazonSocial']."</p></td>
                                                            <td  >".$c['RutEmpresa']."</td>
                                                            <td  >".$c['FechaRegistro']."</td>
                                                            <td >".$c['Usuario']."</td>
                                                            </form>
                                                            </tr>
                                                    ";}?>
                                                
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                         <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <h4 class="text-theme">Lista de Clientes</h4>
                                    <p></p>
                                    <div class="table-responsive">
                                        <table id="example-Cliente" class="table table-striped" cellspacing="0" width="100%" >
                                             <thead>
                                                <tr>
                                                    <th >Opciones</th>
                                                    <th><i class="mdi mdi mdi-castle"></i> Nombre</th>
                                                    <th><i class="mdi mdi-factory"></i> Empresa </th>
                                                    <th><i class="mdi mdi-mail-ru"></i>Email Cliente</th>
                                                    <th><i class="mdi mdi-alarm-check"></i> Fecha Registro</th>
                                                    <th><i class="mdi mdi-account-plus"></i> Usuario Creador</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                    <?php
                                        foreach ($ListarCliente as $c) {
                                        echo "<tr> 
                                                <form id='FrmEditarCliente' method='POST'>
                                                <td class='text-nowrap'>
                                                    <button type='button' id='editEmpresafrom' data-toggle='modal' data-target='.bs-example-modal-Cliente' class='btn btn-sm btn-danger' onclick='MeditarCliente(\"$c[ID_Cliente]\");' ><i class='fa fa-edit text-inverse '></i>Editar Cliente</button>";
                                        if($c["estado"]==0){
                                            echo"<button type='button' class='btn btn-danger' title='Activar Cliente'  onclick='cambiarEstadoCliente(".$c['ID_Cliente'].",".$c["estado"].")'><i class='fa fa-times'></i></button>";
                                            }else{
                                                echo"<button type='button' class='btn btn-success' title='Desactivar Cliente' onclick='cambiarEstadoCliente(".$c['ID_Cliente'].",".$c["estado"].")'><i class='fa fa-check'></i></button>";
                                            };      
                                              echo"       </td>
                                                    <td>".$c['Nombre']."</td>
                                                    <td>".$c['Empresa']."</td>
                                                    <td>".$c['EmailCliente']."</td>
                                                    <td>".$c['FechaRegistro']."</td>
                                                    <td>".$c['Usuario']."</td>
                                                    
                                                </form>
                                            </tr>
                                        ";}?>                                         
                                            </tbody>
                                        </table>
                                    </div>
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
    <div class="modal fade" id="modal-desactivarEmpresa" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar Empresa</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estado1Empresa"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarEstadoEmpresa').submit();">Desactivar Empresa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activarEmpresa" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar Empresa</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sa-icon sa-success animate"></div>
                    <div id="estado2Empresa"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarEstadoEmpresa').submit();">Activar Empresa</button>
                </div>
            </div>
        </div>
    </div>


<!-- Modal Desactivar -->
    <div class="modal fade" id="modal-desactivarCliente" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar Cliente</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estado1Cliente"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarEstadoCliente').submit();">Desactivar Cliente</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activarCliente" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar Cliente</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sa-icon sa-success animate"></div>
                    <div id="estado2Cliente"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarEstadoCliente').submit();">Activar Cliente</button>
                </div>
            </div>
        </div>
    </div>

         <!-- sample modal content -->
    <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="MEditarEmpresas">
        <div class="modal-dialog ">
            <div class="modal-content" id="MEditarEmpresa">
             
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade bs-example-modal-Activar-Empresa" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="ModaldaActivarEmpresas">
        <div class="modal-dialog ">
            <div class="modal-content" id="MActivarEmpresa">
             
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
    <div class="modal fade bs-example-modal-Cliente" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="MEditarClientes" >
        <div class="modal-dialog ">
            <div class="modal-content" id="MEditarCliente">
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

        <!-- end main -->
<script src="<?php echo  site_url(); ?>assets/libs/bootstrap-switch/bootstrap-switch.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/bootbox/bootbox.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/dropify/dist/js/dropify.min.js"></script>
    <!--sweetalert -->
<script src="<?php echo  site_url(); ?>assets/libs/sweetalert/sweetalert.js"></script>

<script type="text/javascript">

    $('.dropify').dropify({
        messages: {
            default: 'Subir Logo Cliente',
            replace: 'Nuevo Logo del Cliente',
            remove:  'Elimnar',
            error:   '-vacio-'
        },

        defaultFile: '',
        maxFileSize: 0,
        minWidth: 0,
        maxWidth: 0,
        minHeight: 0,
        maxHeight: 0,
        showRemove: true,
        showLoader: true,
        showErrors: true,
        errorTimeout: 3000,
        errorsPosition: 'overlay',
        imgFileExtensions: ['png', 'jpg', 'jpeg', 'gif', 'bmp'],
        maxFileSizePreview: "5M",
        allowedFormats: ['portrait', 'square', 'landscape'],
        allowedFileExtensions: ['*'],
         error: {
            'fileSize': 'The file size is too big ({{ value }} max).',
            'minWidth': 'The image width is too small ({{ value }}}px min).',
            'maxWidth': 'The image width is too big ({{ value }}}px max).',
            'minHeight': 'The image height is too small ({{ value }}}px min).',
            'maxHeight': 'The image height is too big ({{ value }}px max).',
            'imageFormat': 'The image format is not allowed ({{ value }} only).',
            'fileExtension': 'The file is not allowed ({{ value }} only).'
        },
        tpl: {
            wrap:            '<div class="dropify-wrapper"></div>',
            loader:          '<div class="dropify-loader"></div>',
            message:         '<div class="dropify-message"><span class="file-icon" /> <p>{{ default }}</p></div>',
            preview:         '<div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-infos-message">{{ replace }}</p></div></div></div>',
            filename:        '<p class="dropify-filename"><span class="dropify-filename-inner"></span></p>',
            clearButton:     '<button type="button" class="dropify-clear">{{ remove }}</button>',
            errorLine:       '<p class="dropify-error">{{ error }}</p>',
            errorsContainer: '<div class="dropify-errors-container"><ul></ul></div>'
        }
    });

    Dropify.prototype.isImage = function()
    {
        if (this.settings.imgFileExtensions.indexOf(this.getFileType()) != "-1") {
            return true;
        }

        return false;
    };

    function MeditarCliente(idemp){      
    $.ajax({
            url: "<?php echo base_url();?>Adm_ModuloCliente/EditarCliente",
            type: "POST",
            data: "idemp="+idemp,
            success: function(data) {
              $("#MEditarCliente").html(data);
             }
        });
      }

      function MeditarEmpresa(idemp){      
    $.ajax({
            url: "<?php echo site_url();?>Adm_ModuloCliente/EditarEmpresa",
            type: "POST",
            data: "idemp="+idemp,
            success: function(data) {
              $("#MEditarEmpresa").html(data);
             }
        });
      }


     function cambiarEstadoEmpresa(idemp,estado){
        $.ajax({
            url: "<?php echo site_url();?>Adm_ModuloCliente/cambiarEstadoEmpresa",
            type: "POST",
            data: "idemp="+idemp+"&estado="+estado,
            success: function(data) {                
                if(estado==1){
                    $("#estado1Empresa").html("");
                    $("#estado1Empresa").html(data);
                    $("#modal-activarEmpresa").modal('hide');
                    $("#modal-desactivarEmpresa").modal('show');
                }else{
                    $("#estado2Empresa").html("");
                    $("#estado2Empresa").html(data);
                    $("#modal-desactivarEmpresa").modal('hide');
                    $("#modal-activarEmpresa").modal('show');
                }                
            }
        });
    }


     function cambiarEstadoCliente(idcli,estado){
        $.ajax({
            url: "<?php echo site_url();?>Adm_ModuloCliente/cambiarEstadoCliente",
            type: "POST",
            data: "idcli="+idcli+"&estado="+estado,
            success: function(data) {                
                if(estado==1){
                    $("#estado1Cliente").html("");
                    $("#estado1Cliente").html(data);
                    $("#modal-activarCliente").modal('hide');
                    $("#modal-desactivarCliente").modal('show');
                }else{
                    $("#estado2Cliente").html("");
                    $("#estado2Cliente").html(data);
                    $("#modal-desactivarCliente").modal('hide');
                    $("#modal-activarCliente").modal('show');
                }                
            }
        });
    }

function activarCliente(idcli){
    
     $.ajax({
            url: "<?php echo site_url();?>Adm_ModuloCliente/ActivarCliente",
            type: "POST",
            data: "idclie="+idcli,
            success: function(data) {
              $("#MActivarCliente").html(data);
             }
        });
      
      }


    $(document).ready(function() {
    var table = $('#example-empresas').DataTable( {
        scrollX:        true,
        searching: false,
        scrollCollapse: true,
        paging:         false,
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

     $(document).ready(function() {
    var table = $('#example-Cliente').DataTable( {
        scrollX:        true,
        searching: false,
        scrollCollapse: true,
        paging:         false,
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