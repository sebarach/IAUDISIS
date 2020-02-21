<main class="main">
        <!-- Breadcrumb -->
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo site_url(); ?>Adm_ModuloPermisos/AdministrarPermisos">Adminsitración Permisos</a>
        </li>
    </ol>
<div class="container">
            <div class="animated fadeIn">    
                <div class="row">
                         <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <h4 class="text-theme">Lista de Permisos</h4>
                                    <hr>
                                    <form id="vigencia" name="vigencia" method="post" action="<?php echo  site_url();?>Adm_ModuloPermisos/buscarVigencia">
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
                                    </form>
                                    <br>
                                    <hr>                                 
                                        <br/>
                                        <table style='font-size: 13px;' class="display table table-hover table-striped" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap"><i class="fa fa-pencil"></i> Opciones</th>
                                                    <th><i class="fa fa-group"></i> Nombre</th>      
                                                    <th><i class="fa fa-thumbs-up"></i> Vigencia</th>
                                                    <th><i class="mdi mdi-book-open"></i> Tipo</th>
                                                    <th><i class="fa fa-dollar"></i> Remunerado</th>
                                                    <th><i class="mdi mdi-barcode"></i> Código</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                    <?php
                                        foreach ($listaPermisos as $p) {
                                            if($p['Vigencia']==1){$vigencia='Vigente';}else{$vigencia='No Vigente';}
                                            if($p['Remunerado']==1){$remunerado='Remunerado';}else{$remunerado='No Remunerado';}
                                        echo "<tr> 
                                                <form id='FrmEditarPermiso' method='POST'> 
                                                               
                                                    <td class='text-nowrap'>
                                                        <button type='button' id='editPermisofrom' data-toggle='modal' data-target='.bs-example-modal-Permiso-e' class='btn btn-sm btn-warning' onclick='MeditarPermiso(\"$p[id_permiso]\");' ><i class='fa fa-edit text-inverse '></i>Editar Permiso</button>";
                                                         if($p["Vigencia"]==0){
                                                 echo"<button type='button' class='btn btn-danger' title='Activar Permiso'  onclick='cambiarPermiso(".$p['id_permiso'].",".$p["Vigencia"].")'><i class='fa fa-times'></i></button>";
                                            }else{
                                                echo"<button type='button' class='btn btn-success' title='Desactivar Permiso' onclick='cambiarPermiso(".$p['id_permiso'].",".$p["Vigencia"].")'><i class='fa fa-check'></i></button>";
                                            };      
                                                       
                                              echo" </td>
                                                    <td>".$p['NombrePermiso']."</td>
                                                    <td>".$p['Tipo']."</td>
                                                    <td>$vigencia</td>
                                                    <td>$remunerado</td> 
                                                    <td>".$p['Codigo']."</td> 
                                                </form>
                                            </tr>
                                        ";}
                                        ?>                                         
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

            <div class="modal fade bs-example-modal-Permiso-e" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="MEditarPermisos">
        <div class="modal-dialog ">
            <div class="modal-content" id="MEditarPermiso">
             
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-desactivarPermiso" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar Permiso</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estado1Permiso"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarPermiso').submit();">Desactivar Permiso</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activarPermiso" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar Familia</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sa-icon sa-success animate"></div>
                    <div id="estado2Permiso"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarPermiso').submit();">Activar Permiso</button>
                </div>
            </div>
        </div>
    </div>

<script src="<?php echo  site_url(); ?>assets/libs/bootstrap-switch/bootstrap-switch.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/bootbox/bootbox.min.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/sweetalert/sweetalert.js"></script>

<script type="text/javascript">

function MeditarPermiso(idPer){      
    $.ajax({
            url: "EditarPermiso",
            type: "POST",
            data: "idPer="+idPer,
            success: function(data) {
               $("#MEditarPermiso").html(data);
             }
        });
    }

function cambiarPermiso(idPer,estado){
        $.ajax({
            url: "cambiarPermiso",
            type: "POST",
            data: "idPer="+idPer+"&estado="+estado,
            success: function(data) {                
                if(estado==1){
                    $("#estado1Permiso").html("");
                    $("#estado1Permiso").html(data);
                    $("#modal-activarPermiso").modal('hide');
                    $("#modal-desactivarPermiso").modal('show');
                }else{
                    $("#estado2Permiso").html("");
                    $("#estado2Permiso").html(data);
                    $("#modal-desactivarPermiso").modal('hide');
                    $("#modal-activarPermiso").modal('show');
                }                
            }
        });
    }        
</script>