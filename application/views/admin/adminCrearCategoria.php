<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="<?php echo site_url(); ?>menu">Menú</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?php echo site_url(); ?>Adm_ModuloElementos/crearCategoria">Administración de Categorías</a>
                </li>
            </ol>

            <div class="container">

                <div class="animated fadeIn">

                    <h3>Administración de Categorías</h3>
                <small>Módulo de Administrador de categorías de elementos. Este módulo esta creado para ver en detalle las categorías, editarlas, crearlas y desactivarlas</small>
                <br><br/>
              <!--   <div class="row">
                         <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <form id="vigencia" name="vigencia" method="post" action="<?php echo  site_url();?>Adm_ModuloElementos/buscarVigenciaCategoria">
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
                                        </div>
                                 <button data-toggle="modal" data-target=".bs-example-modal-Categoria" id="crearCategoria" type="button" class="btn btn-danger" onclick="crearCategoriaElemento()">Agregar Categoría</button>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
             <div class="container">

                <div class="animated fadeIn">

                    
                <div class="row">
                         <div class="col-md-12">
                            <div class="card card-accent-theme">
                                <div class="card-body">
                                    <h4 class="text-theme">Lista de Categorías</h4>
                                    <button data-toggle="modal" data-target=".bs-example-modal-Categoria" id="crearCategoria" type="button" class="btn btn-sm btn-danger pull-right" onclick="crearCategoriaElemento()"><i class="mdi mdi-plus"></i>Agregar Categoría</button>
                                    
                                        <br/>
                                        <table class="display table table-hover table-striped" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap"><i class="fa fa-pencil"></i> Opciones</th>
                                                    <th><i class="fa fa-group"></i> Nombre</th>      
                                                    <th><i class="fa fa-thumbs-up"></i> Vigencia</th>
                                                    <th><i class="fa fa-group"></i> Familia</th>                                          
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                    <?php
                                        foreach ($CategoriaT as $c) {
                                            if($c['Vigencia']==1){$vigencia='Vigente';}else{$vigencia='No Vigente';}
                                        echo "<tr> 
                                                <form id='FrmEditarCategoria' method='POST'> 
                                                               
                                                    <td class='text-nowrap'>
                                                        <button type='button' id='editCategoriafrom' data-toggle='modal' data-target='.bs-example-modal-Categoria-e' class='btn btn-sm btn-warning' onclick='MeditarCategoria(\"$c[ID_Categoria]\");' ><i class='fa fa-edit text-inverse '></i>Editar Categoría</button>";
                                                         if($c["Vigencia"]==0){
                                                 echo"<button type='button' class='btn btn-danger' title='Activar Categoría'  onclick='cambiarCategoria(".$c['ID_Categoria'].",".$c["Vigencia"].")'><i class='fa fa-times'></i></button>";
                                            }else{
                                                echo"<button type='button' class='btn btn-success' title='Desactivar Categoría' onclick='cambiarCategoria(".$c['ID_Categoria'].",".$c["Vigencia"].")'><i class='fa fa-check'></i></button>";
                                            };      
                                                       
                                              echo"      </td>
                                              <td>".$c['Nombre']."</td>
                                                    <td>$vigencia</td>
                                                    <td>".$c['Familia']."</td> 
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

        <div class="modal fade bs-example-modal-Categoria" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="CrearCategorias">
        <div class="modal-dialog ">
            <div class="modal-content" id="CrearCategoria">
             
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-desactivarCategoria" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar Familia</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estado1Categoria"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarCategoria').submit();">Desactivar Elemento</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activarCategoria" tabindex="-1" role="dialog"  aria-hidden="true">
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
                    <div id="estado2Categoria"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarCategoria').submit();">Activar Elemento</button>
                </div>
            </div>
        </div>
    </div>

    <!-- /.modal-editar -->
    <div class="modal fade bs-example-modal-Categoria-e" tabindex="-1" role="dialog"  aria-hidden="true"
        style="display: none;" id="MEditarFamilias">
        <div class="modal-dialog ">
            <div class="modal-content" id="MEditarCategoria">
             aaaa
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

function cambiarCategoria(idcat,estado){
        $.ajax({
            url: "cambiarCategoria",
            type: "POST",
            data: "idcat="+idcat+"&estado="+estado,
            success: function(data) {                
                if(estado==1){
                    $("#estado1Categoria").html("");
                    $("#estado1Categoria").html(data);
                    $("#modal-activarCategoria").modal('hide');
                    $("#modal-desactivarCategoria").modal('show');
                }else{
                    $("#estado2Categoria").html("");
                    $("#estado2Categoria").html(data);
                    $("#modal-desactivarCategoria").modal('hide');
                    $("#modal-activarCategoria").modal('show');
                }                
            }
        });
    }

    function crearCategoriaElemento(){ 
    $.ajax({
            url: "crearCategoriaElemento",
            type: "POST",    
            success: function(data) {
              $("#CrearCategoria").html(data);
             }
        });
      }

    function MeditarCategoria(idcat){
    $.ajax({
            url: "EditarCategoria",
            type: "POST",
            data: "idcat="+idcat,
            success: function(data) {
               $("#MEditarCategoria").html(data);
             }
        });    
    }  

</script>