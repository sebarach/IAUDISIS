<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item active">Administración Zonas</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                 <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body">
                            <h4 class="text-theme">Administración de Zonas</h4>
                            <p>Se puede ver la información, editar, agregar y cambiar de la vigencia de las zonas</p>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarZona"><i class="fa fa-plus-circle" ></i> Agregar Zona</button>
                            <br><br><br>
                            <h4 class="text-theme">Lista de Zonas</h4>
                            <table id="tabla1" class="display table table-hover table-striped" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap"><i class="fa fa-cogs"></i> Opciones</th>
                                        <th><i class="mdi mdi-factory"></i> Nombre Zonas</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                        foreach($zonas as $c){
                                           // var_dump($zonas);
                                            echo "<tr>";                                                                                       
                                            echo"<td><button type='submit' class='btn btn-sm btn-warning' title='Editar zona' onclick='EditarZona(".$c["id_zona"].")'  data-target='#editZona'><i class='fa  fa-edit'></i> &nbsp;Editar zona </button>";
                                            if($c["activo"]==0)
                                            {
                                                 echo"<button type='button' class='btn btn-danger' title='Activar zona'  onclick='cambiarEstadoZona(".$c['id_zona'].",".$c["activo"].")'><i class='fa fa-times'></i></button>";
                                            }
                                            else
                                            {
                                                echo"<button type='button' class='btn btn-success' title='Desactivar zona' onclick='cambiarEstadoZona(".$c['id_zona'].",".$c["activo"].")'><i class='fa fa-check'></i></button>";
                                            }                                            
                                            echo "</td>";
                                            echo "<td>".$c["zona"]."</td>";
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
    <div class="modal fade" id="modal-desactivar-Zona" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estadozona1"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarEstadoZona').submit();">Desactivar Zona</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activar-Zona" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estadoZona2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarEstadoZona').submit();">Activar Zona</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal Editar Zona -->
     <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="editZona">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h6 class="modal-title text-white">Editar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editarZonas"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Cerrar</button>
                    <button type="submit" class="btn btn-warning" onclick="return ValidarCreacionZona();"><i class="fa fa-check-square-o"  id="botonAgregarZona"></i> Editar Zona</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar GrupoU -->
    <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="agregarZona">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white">Agregar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='post' id='FormNuevoZona' action='#'>
                        <div class="form-group">
                            <label for="control-demo-1" class="col-sm-6">Nombre Zona <label style="color:red">* &nbsp;</label></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                                <input type="text" id="txt_Zona" name="txt_Zona" class="form-control" placeholder='Nombre de la Zona' required>
                            </div>
                            <div  id="val_Zona" style="color:red;"></div>                               
                        </div> 
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary" onclick="return ValidarCreacionZona();"><i class="fa fa-check-square-o"  id="botonAgregarZona"></i> Agregar Zona</button>
                </div>
            </div>
        </div>
    </div>

</main>

<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">

    function ValidarCreacionZona()
    {    

    $("#botonAgregarZona").attr("class","fa fa-spin fa-circle-o-notch");
    var vacios=0;
    if($("#txt_Zona").val()==''){  
        $("#txt_Zona").attr('class','form-control is-invalid');
        $("#val_Zona").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Nombre de Zona Vacio');
        vacios+=1;
    }else if ($("#txt_Zona").val().length>100){
        $("#txt_Zona").attr('class','form-control is-invalid');
        $("#val_Zona").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Nombre de la zona debe tener menos de 100 caracteres');
        vacios+=1;
    } else { 
        $("#txt_Zona").attr('class','form-control is-valid');
        $("#val_Zona").html('');
    }

    //Segundo Validador e Insertar
    if(vacios==0)
    {
         $.ajax({
            url: "validarCreacionZona",
            method: "POST",
            data: $("#FormNuevoZona").serialize(), 
            success: function(data) {
                if(data.match("OP1")){
                    var resp = data.replace("OP1", "");
                    alertify.success("Se han ingresado "+resp+" registro");
                    setTimeout(function(){
                        window.location = "listarZona";
                    }, 1000);
                }
                if(data.match("OP2")){
                    alertify.error("No se Ingresaron los Datos");
                }
                if(data.match("OP3")){
                    var resp = data.replace("OP3","");
                     alertify.success("Se han Editado " +resp+ " registro");
                     setTimeout(function(){
                         window.location = "listarZona";
                     }, 1000);
                }
                if(data.match("OP4")){
                    $("#txt_Zona").attr('class','form-control is-invalid');
                    $("#val_Zona").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Nombre de la Zona ya esta registrado en el sistema');
                    alertify.error("No se Ingresaron los Datos");
                } 
                if(data.match("OP5")){
                    $("#txt_Zona").attr('class','form-control is-invalid');
                    $("#val_Zona").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Nombre de la Zona ya esta registrado en el sistema');
                    alertify.error("No se Ingresaron los Datos");
                }   
            }
        });

         $("#botonAgregarZona").attr("class","fa fa-check-square-o");
         return false;
    }else{
        alertify.error("No se Ingresaron los Datos");
        $("#botonAgregarZona").attr("class","fa fa-check-square-o");
        return false;
    }   
}


//Editar Zona
function EditarZona(Zona){
    $.ajax({
        url: "editarZona",
        type: "POST",
        data: "Zona="+Zona,
        success: function(data) {                
            $("#editarZonas").html("");
            $("#editarZonas").html(data);
            $("#editZona").modal('show');

        }
    });
}

function cambiarEstadoZona(Zona,Estado){
    $.ajax({
        url: "cambiarEstadoZona",
        type: "POST",
        data: "Zona="+Zona+"&estado="+Estado,
        success: function(data) {                
            if(Estado==1){
                $("#estadozona1").html("");
                $("#estadozona1").html(data);
                $("#modal-activar-Zona").modal('hide');
                $("#modal-desactivar-Zona").modal('show');
            }else{
                $("#estadoZona2").html("");
                $("#estadoZona2").html(data);
                $("#modal-desactivar-activar").modal('hide');
                $("#modal-activar-Zona").modal('show');
            }                
        }
    });
}


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