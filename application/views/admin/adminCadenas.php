
<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item active">Administración Cadenas</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                 <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body">
                            <h4 class="text-theme">Administración de Cadenas</h4>
                            <p>Se puede ver la información, editar, agregar y cambiar de la vigencia de las cadenas</p>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarCadena"><i class="fa fa-plus-circle" ></i> Agregar Cadena</button>
                            <br><br><br>
                            <h4 class="text-theme">Lista de Cadenas</h4>
                            <table id="tabla1" class="display table table-hover table-striped" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap"><i class="fa fa-cogs"></i> Opciones</th>
                                        <th><i class="mdi mdi-factory"></i> Nombre Cadena</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                        foreach($Cadenas as $c){
                                            echo "<tr>";                                                                                       
                                            echo"<td><button type='submit' class='btn btn-sm btn-warning' title='Editar Cadena' onclick='EditarCadenaLocal(".$c["ID_Cadena"].")'><i class='fa  fa-edit'></i> &nbsp;Editar Cadena </button>";
                                            if($c["Activo"]==0){
                                                 echo"<button type='button' class='btn btn-danger' title='Activar Cadena'  onclick='cambiarEstadoCadena(".$c['ID_Cadena'].",".$c["Activo"].")'><i class='fa fa-times'></i></button>";
                                            }else{
                                                echo"<button type='button' class='btn btn-success' title='Desactivar Cadena' onclick='cambiarEstadoCadena(".$c['ID_Cadena'].",".$c["Activo"].")'><i class='fa fa-check'></i></button>";
                                            }                                            
                                            echo "</td>";
                                            echo "<td>".$c["NombreCadena"]."</td>";
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
    <div class="modal fade" id="modal-desactivar-cadena" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estadoCadena1"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarEstadoCadena').submit();">Desactivar Cadena</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activar-cadena" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estadoCadena2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarEstadoCadena').submit();">Activar Cadena</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal Editar Cadena -->
     <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="editCadena">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h6 class="modal-title text-white">Editar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editarCadena"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Cerrar</button>
                    <button type="submit" class="btn btn-warning" onclick="return ValidarCreacionCadenaLoc();"><i class="fa fa-check-square-o"  id="botonAgregarCadena"></i> Editar Cadena</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar GrupoU -->
    <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="agregarCadena">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white">Agregar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='post' id='FormNuevoCadena' action='#'>
                        <div class="form-group">
                            <label for="control-demo-1" class="col-sm-6">Nombre Cadena <label style="color:red">* &nbsp;</label></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="mdi mdi-factory"></i></span>
                                <input type="text" id="txt_cadena" name="txt_cadena" class="form-control" placeholder='Nombre de la Cadena' required>
                            </div>
                            <div  id="val_cadena" style="color:red;"></div>                               
                        </div> 
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary" onclick="return ValidarCreacionCadena();"><i class="fa fa-check-square-o"  id="botonAgregarCadena"></i> Agregar Cadena</button>
                </div>
            </div>
        </div>
    </div>

</main>

<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
    // Tabla 1

function EditarCadenaLocal(Cadena){
    $.ajax({
        url: "editarCadena",
        type: "POST",
        data: "cadena="+Cadena,
        success: function(data) {                
            $("#editarCadena").html("");
            $("#editarCadena").html(data);
            $("#editCadena").modal('show');
        }
    });
}

function ValidarCreacionCadenaLoc(){
    $("#botonAgregarCadena").attr("class","fa fa-spin fa-circle-o-notch");
    var vacios=0;
    if($("#txt_cadena").val()==''){  
        $("#txt_cadena").attr('class','form-control is-invalid');
        $("#val_cadena").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Campo Nombre de Cadena Vacio');
        vacios+=1;
    } else if ($("#txt_cadena").val().length>100){
        $("#txt_cadena").attr('class','form-control is-invalid');
        $("#val_cadena").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Nombre debe tener menos de 100 caracteres');
        vacios+=1;
    } else { 
        $("#txt_cadena").attr('class','form-control is-valid');
        $("#val_cadena").html('');
    }

    //Segundo Validador e Insertar
    if(vacios==0){
         $.ajax({
            url: "validarCreacionCadena",
            method: "POST",
            data: $("#FormNuevoCadena").serialize(), 
            success: function(data) {
                if(data.match("OP1")){
                    var resp = data.replace("OP1", "");
                    alertify.success("Se han ingresado "+resp+" registro");
                    setTimeout(function(){
                        window.location = "listarCadenas";
                    }, 1000);
                }

                if(data.match("OP3")){
                    var resp = data.replace("OP3", "");
                    alertify.success("Se han Editado "+resp+" registro");
                    setTimeout(function(){
                        window.location = "listarCadenas";
                    }, 1000);
                }

                if(data.match("OP5")){
                    $("#txt_cadena").attr('class','form-control is-invalid');
                    $("#val_cadena").html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Nombre de la Cadena ya esta registrado en el sistema');
                    alertify.error("No se Ingresaron los Datos");
                }   

                if(data.match("OP2")){
                    alertify.error("No se Ingresaron los Datos");
                }
            }
        });
         $("#botonAgregarCadena").attr("class","fa fa-check-square-o");
         return false;
    }else{
        alertify.error("No se Ingresaron los Datos");
        $("#botonAgregarCadena").attr("class","fa fa-check-square-o");
        return false;
    }   
}


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