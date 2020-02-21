<main class="main">
    <ol class="breadcrumb bc-colored bg-theme" id="breadcrumb">
        <li class="breadcrumb-item ">
            <a href="<?php echo site_url(); ?>menu">Menú</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo site_url(); ?>Adm_ModuloPuntosVentas/creacionPuntosVentas">Creación Locales</a>
        </li>
        <li class="breadcrumb-item active">administración Locales</li><?php if(!isset($buscador)){echo " (Total de Locales  ".$totalFilas['filas']. ")";}  ?>
    </ol>
                 <div class="col-md-12">
                    <div class="card card-accent-theme">
                        <div class="card-body">
                            <h4 class="text-theme">Administración de Locales</h4>
                            <p>Se puede ver la información, editar y cambiar de la vigencia de los locales</p>
                            
                             <form method="POST" action="generarExcelLocales">
                                <button class="btn btn-outline-theme" type="submit" title='Descargar Plantilla'><i class="mdi mdi-file-excel"></i> Descargar Lista de Locales</button> 
                            </form> 
                            <hr>
                            

                            <div class="row">
                            <form method="POST" id="frmEditarLocales" name="frmEditarLocales" action="listarLocales">

                                        <div class="md-form mt-0">
                                              <label  for="">Buscar Local</label> <input id="txtLocal"  name="txtLocal" class="form-control" type="text" placeholder="Buscar" aria-label="Buscar">
                                              <button type="submit" onclick=validar();  class="btn btn-success btn-sm">Buscar</button>

                                         </div>                                       
                                </div> 

                            </form> 
                            <br>
                            <h4 class="text-theme">Lista de Locales</h4>

                     <div class="col-md-12">
                        <div class="card card-accent-theme">
                            <div class="card-body">
                                <div class='table-responsive'>
                            <table class="table table-sm  hover-table">
                                <thead>
                                    <tr>
                                       <?php if(!isset($buscador)){ echo " <th><i class='mdi mdi-format-list-'></i>Nro</th>";} ?>
                                        <th class="text-nowrap"><i class="fa fa-cogs"></i> Opciones</th>
                                        <th><i class="mdi mdi-pencil"></i> Nombre Local</th>                                        
                                        <th><i class="fa fa-map-marker"></i> Dirección</th>    
                                        <th><i class="ti-signal"></i> Rango</th>    
                                        <th><i class="mdi mdi-factory"></i> Cadena</th>    
                                        <th><i class="mdi mdi-google-maps"></i> Region</th>    
                                        <th><i class="mdi mdi-map"></i> Comuna</th>
                                        <th><i class="mdi mdi-home-map-marker"></i> Zona</th>          
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($Locales as $l){
                                            echo "<tr>";
                                            if(isset($l["filas"])) {echo "<td>".$l["filas"]."</td>";}
                                            echo "<td><div class='btn-group btn-group-sm' role='group' aria-label='Basic example'>
                                            <button type='button' class='btn btn-warning' title='Editar Local' onclick='EditarLocalEl(".$l["ID_Local"].")'><i class='fa  fa-edit'></i>&nbsp; Editar Local</button>&nbsp;&nbsp;";
                                            if($l["Activo"]==0){
                                                 echo"<button type='button' class='btn btn-danger' title='Activar Local'  onclick='cambiarEstadoLocal(".$l['ID_Local'].",".$l["Activo"].")'><i class='fa fa-times'></i></button>";
                                            }else{
                                                echo"<button type='button' class='btn btn-success' title='Desactivar Local' onclick='cambiarEstadoLocal(".$l['ID_Local'].",".$l["Activo"].")'><i class='fa fa-check'></i></button>";
                                            }    
                                            echo "&nbsp;&nbsp;<button type='button' class='btn btn-info' data-toggle='modal' data-target='#mapLocal'  title='mapa de Local' onclick='mapaLocal(\"$l[Latitud]\",\"$l[Longitud]\",\"$l[Rango]\")'><i class='mdi mdi-compass-outline'></i></button";
                                            echo "</div></td>";
                                            echo "<td>".$l["NombreLocal"]."</td>";
                                            echo "<td>".$l["Direccion"]."</td>";
                                            // echo "<td>".$l["Latitud"]."</td>";
                                            // echo "<td>".$l["Longitud"]."</td>";
                                            echo "<td>".$l["Rango"]."</td>";
                                            echo "<td>".$l["NombreCadena"]."</td>";
                                            echo "<td>".$l["Region"]."</td>";
                                            echo "<td>".$l["Comuna"]."</td>";
                                            echo "<td>".$l["Zona"]."</td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                            
                       <?php

if(!isset($buscador)) 
{
    if(isset($opcion))
    {                
    echo "                   
    <div class='col-md-4' >
    <nav aria-label='Page navigation example'>
    <ul class='pagination'>";
    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloPuntosVentas/listarLocales?opcion=0'>Inicio</a></li>";
    if(!$opcion==0){                     
    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloPuntosVentas/listarLocales?opcion=".($opcion-1)."' > Anterior</a></li>";
    }
    if(($opcion-2)>0){
    
    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloPuntosVentas/listarLocales?opcion=".($opcion-2)."' >".($opcion-2)."</a></li>";
    }
    if(($opcion-1)>0){
    
    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloPuntosVentas/listarLocales?opcion=".($opcion-1)."' >".($opcion-1)."</a></li>";
    }   
    
    echo "<li class='page-item active'><a class='page-link text-red' style='border-color: #e01111; background-color: #fff; color: #e01111; href=''  ><span class='badge badge-danger hertbit'>$opcion</span></a></li>";
    
    if(($opcion+1)<=$cantidad){
    
    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloPuntosVentas/listarLocales?opcion=".($opcion+1)."' >".($opcion+1)."</a></li>";
    }
    if(($opcion+2)<=$cantidad){
    
    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloPuntosVentas/listarLocales?opcion=".($opcion+2)."' >".($opcion+2)."</a></li>";
    }
    if(($opcion+3)<=$cantidad){
    echo "<li class='page-item'><a class='page-link bg-danger text-white'>...</a></li>";
    
    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloPuntosVentas/listarLocales?opcion=$cantidad'>$cantidad</a></li>";
    }
    if($opcion!=$cantidad){
    
    echo "<li class='page-item'><a class='page-link bg-danger text-white' href='".site_url()."Adm_ModuloPuntosVentas/listarLocales?opcion=".($opcion+1)."'>Siguiente</a></li>
    </ul>
    </nav>";
    }
    
    echo "</form></div>";  
    }
}


?>                         

                           </div>
                        </div>
                    </div>
                </div>

     <!-- Modal Desactivar -->
    <div class="modal fade" id="modal-desactivar-local" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h6 class="modal-title text-white">Desactivar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estadoLocal1"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('cambiarEstadoLocal').submit();">Desactivar Local</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Activar -->
    <div class="modal fade" id="modal-activar-local" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h6 class="modal-title text-white">Activar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="estadoLocal2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('cambiarEstadoLocal').submit();">Activar Local</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal Editar Local -->
    <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="editLocal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h6 class="modal-title text-white">Editar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editarLocal"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Cerrar</button>
                    <button type="submit" class="btn btn-warning" onclick="return ValidarCreacionLocal();"><i class="fa fa-check-square-o"  id="botonLocal"></i> Editar Local</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Mapa Local -->


    <div class="modal fade bs-example-modal-Empresa" tabindex="-1" role="dialog"  aria-hidden="true" id="mapLocal">
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class="modal-header bg-info">
                    <h6 class="modal-title text-white">Ubicación del Local</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!-- <div class="modal-body"> -->
                    <div class="row">
                        <div class="col-md-12" id='modalmapa'>
                                    
                        </div>
                    </div>
                <!-- </div> -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</main>
 <!--<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4Zt12Kgpaar2fMBofnlnslSF9cvG6F5M&callback=initMap"></script> -->
<script src="<?php echo  site_url(); ?>assets/libs/Alertify/js/alertify.js"></script>
<script src="<?php echo  site_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">

        function EditarLocalEl(Local){
        $.ajax({
            url: "editarLocal",
            type: "POST",
            data: "local="+Local,
            success: function(data) {                
                $("#editarLocal").html("");
                $("#editarLocal").html(data);
                $("#editLocal").modal('show');          
            }
        });
    }

    function validar(){

    $('#frmEditarLocales').submit(function(e) 
    {
    if ($("#txtLocal").val()=='') 
        {
            e.preventDefault();
            alertify.error("Debe escribir el nombre de un local");
            $("#txtLocal").focus();
            alertify.remove();
        }
        if ($("#txtLocal").val().length > 50) 
        {
            e.preventDefault();
            alertify.error("Excede el maximo de palabras");
            $("#txtLocal").focus();
            alertify.remove();
        }
  });
}


    function mapaLocal(lat,long,Rango){      
    $.ajax({
            url: "<?= base_url();?>/Adm_ModuloPuntosVentas/mapaLocal",
            type: "POST",
            data: "lat="+lat+"&long="+long+"&rang="+Rango,
            success: function(data) {
              // $("#modalmapa").html('');
              $("#modalmapa").html('');
              $("#modalmapa").html(data);
             }
        });
      }


    // Tabla 1

// $(document).ready(function() {
//     var table = $('#tabla1').DataTable( {
//         scrollY:        "350px",
//         scrollX:        true,
//         searching: true,
//         scrollCollapse: true,
//         paging:         true,
//         fixedColumns:   {
//             leftColumns: 1,
//         },
//         "language": {
//             "sProcessing":    "Procesando...",
//             "sLengthMenu":    "Mostrar _MENU_ registros",
//             "sZeroRecords":   "No se encontraron resultados",
//             "sEmptyTable":    "Ningún dato disponible en esta tabla",
//             "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
//             "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
//             "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
//             "sInfoPostFix":   "",
//             "sSearch":        "Buscar:",
//             "sUrl":           "",
//             "sInfoThousands":  ",",
//             "sLoadingRecords": "Cargando...",
//             "oPaginate": {
//                 "sFirst":    "Primero",
//                 "sLast":    "Último",
//                 "sNext":    "Siguiente",
//                 "sPrevious": "Anterior"
//             },
//             "oAria": {
//                 "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
//                 "sSortDescending": ": Activar para ordenar la columna de manera descendente"
//             }
//         }
//     });
// });
</script>